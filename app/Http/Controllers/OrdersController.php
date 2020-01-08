<?php

namespace App\Http\Controllers;

use App\Orders;
use Illuminate\Http\Request;


class OrdersController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth',['except'=>[]]);

    }


    public function create(Request $request)
    {
        $this->validate($request, Orders::rules());

        $model = Orders::create($request->all());

        $response = [
            'status' => 1,
            'data' => $model
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }

    public function index($id)
    {
        $orders = Orders::where('id', $id)->get();
        return $orders->toJson(JSON_PRETTY_PRINT);
        // $model = $this->findModel($id);
        // $response = [
        //     'status' => 1,
        //     'data' => $model
        // ];
        // return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {

        $model = $this->findModel($id);
        $this->validate($request, Orders::rules($id));

        $model->total_amount = $request->input('total_amount');
        $model->dis_amount = $request->input('dis_amount');
        $model->grand_total = $request->input('grand_total');
        $model->customer_id = $request->input('customer_id');
        $model->supplier_id = $request->input('supplier_id');
        $model->user_id = $request->input('user_id');
        $model->description = $request->input('description');
        $model->recieved_amount = $request->input('recieved_amount');
        $model->balance = $request->input('balance');
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

    public function view(Request $request)
    {
        $orders = Orders::where('status', 1)->get();
       
        return $orders->toJson(JSON_PRETTY_PRINT);
        $models = Orders::search($request);

        $response = [
            'status' => 1,
            'data' => $models
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }

    public function findModel($id)
    {

        $model = Orders::find($id);
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