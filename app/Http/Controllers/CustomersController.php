<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;


class CustomersController extends Controller
{
    public function __construct(Request $request)
    {
        //$this->middleware('auth',['except'=>[]]);
    }


    public function create(Request $request)
    {
        $this->validate($request, Customers::rules());

        $model = Customers::create($request->all());

        $response = [
            'status' => 1,
            'data' => $model
        ];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function view(Request $request)
    {
        
        $customer = Customers::where('status', 1)->get();
       
        return $customer->toJson(JSON_PRETTY_PRINT);

        // $response = [
        //     'status' => 1,
        //     'data' => $customer
        // ];

        // return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }
    public function view1()
    {
        $models = Customers::where('status', 1)->get();
        return $models->toJson(JSON_PRETTY_PRINT);
       // $model = $this->findModel($id);
    //    $models = Customers::where('id', $id)->get();
    //    return $models->toJson(JSON_PRETTY_PRINT);
        // $response = [
        //     'status' => 1,
        //     'data' => $models
        // ];
        // return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {

        $model = $this->findModel($id);
        $this->validate($request, Customers::rules($id));

        $model->name = $request->input('name');
        $model->mobile = $request->input('mobile');
        $model->state_id = $request->input('state_id');
        $model->city_id = $request->input('city_id');
        $model->area_id = $request->input('area_id');
        $model->block_id = $request->input('block_id');
        $model->address = $request->input('address');
        $model->delivery_boy_id = $request->input('delivery_boy_id');
        $model->user_id = $request->input('user_id');
        $model->status = $request->input('status');
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

    public function index($id)
    {
        $customer = Customers::where('id', $id)->get();
        return $customer->toJson(JSON_PRETTY_PRINT);
         // $response = [
        //     'status' => 1
        //     'data' => $model
        // ]
        //return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        // $masters = Customers::where('parent', $parent_id)
        // ->where('table_type', $table_type)
        // ->get();
        // return $masters->toJson(JSON_PRETTY_PRINT);

    }

    public function findModel($id)
    {

        $model = Customers::find($id);
        if (!$model) {
            $response = [
                'status' => 0,
                'errors' => "Invalid Record"
            ];

            response()->json($response, 400, [], JSON_PRETTY_PRINT)->send();
            die;
        }
        return $model->toJson(JSON_PRETTY_PRINT);;
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
