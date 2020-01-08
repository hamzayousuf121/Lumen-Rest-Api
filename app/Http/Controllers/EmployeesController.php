<?php

namespace App\Http\Controllers;

use App\Employees;
use Illuminate\Http\Request;


class EmployeesController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth',['except'=>[]]);

    }


    public function create(Request $request)
    {
        $this->validate($request, Employees::rules());

        $model = Employees::create($request->all());

        $response = [
            'status' => 1,
            'data' => $model
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }

    public function index($id)
    {
        $employees = Employees::where('id', $id)->get();
       
        return $employees->toJson(JSON_PRETTY_PRINT);
        // $model = $this->findModel($id);
        // $model = Employees::where('supplier_id', $id)
        // ->get();
        // $response = [
        //     'status' => 1,
        //     'data' => $model
        // ];
        // return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {

        $model = $this->findModel($id);
        $this->validate($request, Employees::rules($id));

        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->mobile = $request->input('mobile');
        $model->address = $request->input('address');
        $model->status = $request->input('status');
        $model->user_id = $request->input('user_id');
        $model->email = $request->input('supplier_id');

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
        $employees = Employees::where('status', 1)->get();
       
        return $employees->toJson(JSON_PRETTY_PRINT);
        // $models = Employees::search($request);

        // $response = [
        //     'status' => 1,
        //     'data' => $models
        // ];

        // return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }

    public function findModel($id)
    {

        $model = Employees::find($id);
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

?>