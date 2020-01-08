<?php

namespace App\Http\Controllers;

use App\Orderdetails;
use Illuminate\Http\Request;


class OrderdetailsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth',['except'=>[]]);
    }


    public function create(Request $request)
    {
        $this->validate($request, Orderdetails::rules());

        $model = Orderdetails::create($request->all());

        $response = [
            'status' => 1,
            'data' => $model
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }

    public function index($id)
    {
        $orderdetails = Orderdetails::where('id', $id)->get();
       
        return $orderdetails->toJson(JSON_PRETTY_PRINT);
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
        $this->validate($request, Orderdetails::rules($id));

        $model->order_id = $request->input('order_id');
        $model->product_id = $request->input('product_id');
        $model->price = $request->input('price');
        $model->discount = $request->input('discount');
        $model->description = $request->input('description');
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
        $orderdetails = Orderdetails::where('status', 1)->get();
       
        return $orderdetails->toJson(JSON_PRETTY_PRINT);
        // $models = Orderdetails::search($request);

        // $response = [
        //     'status' => 1,
        //     'data' => $models
        // ];

        // return response()->json($response, 200, [], JSON_PRETTY_PRINT);

    }

    public function findModel($id)
    {

        $model = Orderdetails::find($id);
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