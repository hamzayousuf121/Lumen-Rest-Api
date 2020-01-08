<?php

namespace App\Http\Controllers;

use App\Masters;
use Illuminate\Http\Request;


class MastersController extends Controller
{
    public function __construct(Request $request)
    {
        // $this->middleware('auth',['except'=>[]]);

    }


    public function create(Request $request)
    {
        //$this->validate($request, Masters::rules());
        //$request =new Request();
        
        // $request->headers->set('X-Access-Token', 'fb688cd4263610ab652f8501c973cf5b');
        // $request->headers->set('Content-Type', 'application/json');

        // $request = Request::create(route('api.v1.b.show', ['booking' => 4]), 'GET');
        // $request->headers->set('X-Authorization', 'xxxxx');
    
        //var_dump($request->all());exit;
        $model = Masters::create($request->all());
        
        $response = [
            'status' => 1,
            'data' =>'succusfull',
            'data' => $model
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }

    public function index($parent_id, $table_type)
    {
        // $model = $this->findModel($id);
        $masters = Masters::where('parent', $parent_id)
        ->where('table_type', $table_type)
        ->get();
        return $masters->toJson(JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {

        $model = $this->findModel($id);
        $this->validate($request, Masters::rules($id));

        $model->name = $request->input('name');

        $model->save();  

        $response = [
            'status' => 1,
            'data' => $model
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function deleteRecord($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        $response = [
            'status' => 1,
            'data' => $model,
            'message'=>'Removed successfully.'
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function view(Request $request)
    {
        
        $models = Masters::where('status', 1)->get();
       
        return $models->toJson(JSON_PRETTY_PRINT);
        $response = [
            'status' => 1,
            'data' => $models
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }

    public function findModel($id)
    {

        $model = Masters::find($id);
        if (!$model) {
            $response = [
                'status' => 0,
                'errors' => "Invalid Record"
            ];

            response()->json($response, 400, [], JSON_PRETTY_PRINT)->send();
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
                    'Access-Control-Allow-Methods'     => 'GET,POST,OPTIONS, PUT, DELETE',
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Max-Age'           => '86400',
                    // 'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
                    'Access-Control-Allow-Headers'     => '*',
                    'Content-Length'=>'0',
                    'Content-Type'=>'application/json'
                ];

                //return response()->json('{"method":"OPTIONS"}', 200, $headers);
                return response()->json(["method"=>"OPTIONS"], 200, $headers);
            }

            response()->json($response, 400, [], JSON_PRETTY_PRINT)
                ->header('Access-Control-Allow-Origin','*')
                ->header('Access-Control-Allow-Methods','POST, GET, OPTIONS, PUT, DELETE')
                ->header('Access-Control-Allow-Credentials','true')
                ->header('Access-Control-Max-Age','86400')
                ->header('Access-Control-Allow-Headers','*')
                ->send();
            die();

        }

        return true;
    }
}
