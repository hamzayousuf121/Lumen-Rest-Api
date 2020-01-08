<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\AuthorizationCodes;
use App\AccessTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{


    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['create', 'accesstoken', 'auth']]);

    }

    public function create(Request $request)
    {
        $this->validate($request, User::rules());

        $attributes = $request->all();


        $attributes['password'] = Hash::make($attributes['password']);

        $model = User::create($attributes);


        $response = [
            'status' => 1,
            'data' => $model
        ];

        return response()
               ->json($response, 200, [], JSON_PRETTY_PRINT)
               ->setCallback($request->input('callback'));

    }

    public function me(Request $request)
    {
        $data = Auth::user()->getAttributes();

        unset($data['password']);
        unset($data['password_reset_token']);

        $response = [
            'status' => 1,
            'data' => $data
        ];

        return response()
            ->json($response, 200, [], JSON_PRETTY_PRINT)
            ->setCallback($request->input('callback'));
    }

    public function accesstoken(Request $request)
    {
        $this->validate($request, User::accessTokenRules());

        $attributes = $request->all();

        $auth_code = AuthorizationCodes::isValid($attributes['authorization_code']);

        if (!$auth_code) {
            $response = [
                'status' => 0,
                'error' => "Invalid Authorization Code"
            ];
            return response()
                ->json($response, 400, [], JSON_PRETTY_PRINT)
                ->setCallback($request->input('callback'));
        }

        $model = $this->createAccesstoken($attributes['authorization_code']);

        $data = [];
        $data['access_token'] = $model->token;
        $data['expires_at'] = $model->expires_at;

        $response = [
            'status' => 1,
            'data' => $data
        ];

        return response()
            ->json($response, 200, [], JSON_PRETTY_PRINT)
            ->setCallback($request->input('callback'));


    }

    public function refresh(Request $request)
    {

        $headers = $request->headers->all();

        if (!$access_token = $this->refreshAccesstoken($headers['x-access-token'])) {

            $response = [
                'status' => 0,
                'error' => "Invalid Access token"
            ];
            return response()
                ->json($response, 400, [], JSON_PRETTY_PRINT)
                ->setCallback($request->input('callback'));
        }


        $data = [];
        $data['access_token'] = $access_token->token;
        $data['expires_at'] = $access_token->expires_at;
        $response = [
            'status' => 1,
            'data' => $data
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);


    }

    public function auth(Request $request)
    {
        $this->validate($request, User::authorizeRules());


        if ($model = User::authorize($request->all())) {

            $auth_code = $this->createAuthorizationCode($model->id);

            $data = [];
            $data['authorization_code'] = $auth_code->code;
            $data['expires_at'] = $auth_code->expires_at;

            $response = [
                'status' => 1,
                'data' => $data
            ];

            return response()
                ->json($response, 200, [], JSON_PRETTY_PRINT)
                ->setCallback($request->input('callback'));

        } else {

            $response = [
                'status' => 0,
                'errors' => [
                               "password"=>["Username or Password is wrong"]
                            ]
            ];

            return response()
                ->json($response, 400, [], JSON_PRETTY_PRINT)
                ->setCallback($request->input('callback'));

        }
    }

    public function logout(Request $request)
    {

        $token = $this->getAccessToken($request);

        $model = AccessTokens::where(['token' => $token])->first();


        if ($model->delete()) {

            $response = [
                'status' => 1,
                'message' => "Logged Out Successfully"
            ];
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);


        } else {
            $response = [
                'status' => 0,
                'message' => "Invalid request"
            ];
            return response()
                ->json($response, 400, [], JSON_PRETTY_PRINT)
                ->setCallback($request->input('callback'));

        }

    }


    public function view($id,Request $request)
    {
        $model = $this->findModel($id,$request);
        return response()->json($model, 200, [], JSON_PRETTY_PRINT)
            ->setCallback($request->input('callback'));
    }

    public function update(Request $request, $id)
    {

        $model = $this->findModel($id,$request);
        $this->validate($request, User::updateRules($id));

        $model->username = $request->input('username');
        $new_password = $request->input('password');

        $response = [
            'status' => 1,
        ];


        if (!empty($new_password)) {
            $model->password = Hash::make($new_password);

            $token = $this->getAccessToken($request);

            if ($new_token = $this->refreshAccesstoken($token)) {

                $response['new_access_token'] = $new_token->token;
            }
        }
        $email = $request->input('email');

        if (!empty($email))
            $model->email = $email;

        $model->save();

        $response['data'] = $model;

        return response()->json($response, 200, [], JSON_PRETTY_PRINT)
            ->setCallback($request->input('callback'));
    }

    public function deleteRecord($id,Request $request)
    {
        $model = $this->findModel($id);
        $model->delete();

        $response = [
            'status' => 1,
            'data' => $model,
            'message' => 'Removed successfully.'
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT)
            ->setCallback($request->input('callback'));
    }

    public function index(Request $request)
    {
        $response = User::search($request);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT)
            ->setCallback($request->input('callback'));


    }

    public function findModel($id,Request $request)
    {

        $model = User::find($id);
        if (!$model) {
            $response = [
                'status' => 0,
                'errors' => "Invalid Record"
            ];

            response()->json($response, 400, [], JSON_PRETTY_PRINT)
                ->setCallback($request->input('callback'))
                ->send();
            die;
        }
        return $model;
    }

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {

        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $response = [
                'status' => 0,
                'errors' => $validator->errors()
            ];




            if ($request->isMethod('OPTIONS'))
            {
                $headers = [
                    'Access-Control-Allow-Origin'      => '*',
                    'Access-Control-Allow-Methods'     => 'OPTIONS,GET,POST, PUT, DELETE',
                   // 'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Max-Age'           => '86400',
                    // 'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
                    'Access-Control-Allow-Headers'     => '*',
                    'Content-Length'=>'0',
                    'Content-Type'=>'application/json'
                ];

                return response("",200)
                    ->header('Access-Control-Allow-Origin','*')
                    ->header('Access-Control-Allow-Methods','POST, GET, OPTIONS, PUT, DELETE')
                   // ->header('Access-Control-Allow-Credentials','true')
                    ->header('Access-Control-Max-Age','86400')
                    ->header('Access-Control-Allow-Headers','*')
                    ->header('Content-Length','0')
                    ->header('Content-Type','text/plain');

                //return response()->json('{"method":"OPTIONS"}', 400, $headers);
                return response()->json(["method"=>"OPTIONS"], 200, $headers);
            }

            response()->json($response, 400, [], JSON_PRETTY_PRINT)
                ->header('Access-Control-Allow-Origin','*')
                ->header('Access-Control-Allow-Methods','POST, GET, OPTIONS, PUT, DELETE')
               // ->header('Access-Control-Allow-Credentials','true')
                ->header('Access-Control-Max-Age','86400')
                ->header('Access-Control-Allow-Headers','*')
                ->setCallback($request->input('callback'))
                ->send();
            die();

        }

        return true;
    }

    public function createAuthorizationCode($user_id)
    {
        $model = new AuthorizationCodes;

        $model->code = md5(uniqid());

        $model->expires_at = time() + (60 * 5);

        $model->user_id = $user_id;

        if (isset($_SERVER['HTTP_X_APPLICATION_ID']))
            $app_id = $_SERVER['HTTP_X_APPLICATION_ID'];
        else
            $app_id = null;

        $model->app_id = $app_id;

        $model->created_at = time();

        $model->updated_at = time();

        $model->save();

        return ($model);

    }

    public function createAccesstoken($authorization_code)
    {

        $auth_code = AuthorizationCodes::where(['code' => $authorization_code])->first();

        $model = new AccessTokens();

        $model->token = md5(uniqid());

        $model->auth_code = $auth_code->code;

        $model->expires_at = time() + (60 * 60 * 24 * 60); // 60 days

        // $model->expires_at=time()+(60 * 2);// 2 minutes

        $model->user_id = $auth_code->user_id;

        $model->created_at = time();

        $model->updated_at = time();

        $model->save();

        return ($model);

    }

    public function refreshAccesstoken($token)
    {
        $access_token = AccessTokens::where(['token' => $token])->first();
        if ($access_token) {

            $access_token->delete();
            $new_access_token = $this->createAccesstoken($access_token->auth_code);
            return ($new_access_token);
        } else {

            return false;
        }
    }

    public function getAccessToken($request)
    {

        $headers = $request->headers->all();

        $token = false;

        if (!empty($headers['x-access-token'][0])) {

            $token = $headers['x-access-token'][0];

        } else if ($request->input('access_token')) {
            $token = $request->input('access_token');
        }

        return $token;
    }
}

?>