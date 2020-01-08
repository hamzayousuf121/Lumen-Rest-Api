<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderdetails extends Model
{
    protected $table = 'order_detail';
    public $timestamps = false;
    protected $fillable = ['discount','price','product_id','order_id', 'description', 'status'];
    static public function rules($id=NULL)
    {
        return [
            'order_id' => 'required',
            'discount' => 'required',
            'price' => 'required',
            'product_id' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
    }

    static public function search($request)
    {

        $page = $request->input('page');
        $limit = $request->input('limit');
        $order = $request->input('order');

        $search = $request->input('search');

        if(isset($search)){
            $params=$search;
        }

        $limit = isset($limit) ? $limit : 10;
        $page = isset($page) ? $page : 1;


        $offset = ($page - 1) * $limit;

        $query = Orderdetails::select(['discount','price',
        'product_id','order_id', 'description', 'status']);
            //->limit($limit)
            //->offset($offset);

       // $count = Developer::where('active', 1)->count();


        if(isset($params['id'])) {
            $query->where(['id' => $params['id']]);
        }
        if(isset($params['discount'])) {
            $query->where(['discount' => $params['discount']]);
        } 
        if(isset($params['price'])) {
            $query->where(['price' => $params['price']]);
        }
         if(isset($params['product_id'])) {
            $query->where(['product_id' => $params['product_id']]);
        }
         if(isset($params['order_id'])) {
            $query->where(['order_id' => $params['order_id']]);
        }
         if(isset($params['description'])) {
            $query->where(['description' => $params['description']]);
        }

         if(isset($params['status'])) {
            $query->where(['status' => $params['status']]);
        }

        // if(isset($params['created_at'])) {
        //     $query->where(['created_at' => $params['created_at']]);
        // }
        // if(isset($params['updated_at'])) {
        //     $query->where(['updated_at' => $params['updated_at']]);
        // }
       
        if(isset($order)){
              $query->orderByRaw($order);        }

        $totalCount=$query->count();

        $query->limit($limit)->offset($offset);

        $data=$query->get();

        return [
            'status'=>1,
            'data' => $data,
            'page' => (int)$page,
            'size' => $limit,
            'totalCount' => (int)$totalCount
        ];
    }
}
