<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transaction';
    public $timestamps = false;
    protected $fillable = ['order_id', 'total_amount','dis_amount', 'grand_total','customer_id','supplier_id','user_id','description','recieved_amount','balance', 'status'];
    static public function rules($id=NULL)
    {
        return [
            'order_id' => 'required',
            'total_amount' => 'required',
            'dis_amount' => 'required',
            'grand_total' => 'required',
            'customer_id' => 'required',
            'supplier_id' => 'required',
            'user_id' => 'required',
            'description' => 'required',
            'recieved_amount' => 'required',
            'balance' => 'required',
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

        $query = Transactions::select(['order_id', 'total_amount','dis_amount', 'grand_total',
        'customer_id','supplier_id','user_id','description','recieved_amount','balance', 'status']);
            //->limit($limit)
            //->offset($offset);

       // $count = Developer::where('active', 1)->count();


        if(isset($params['id'])) {
            $query->where(['id' => $params['id']]);
        }
        if(isset($params['order_id'])) {
            $query->where(['order_id' => $params['order_id']]);
        }
        if(isset($params['total_amount'])) {
            $query->where(['total_amount' => $params['total_amount']]);
        } 
        if(isset($params['dis_amount'])) {
            $query->where(['dis_amount' => $params['dis_amount']]);
        }
         if(isset($params['grand_total'])) {
            $query->where(['grand_total' => $params['grand_total']]);
        }
         if(isset($params['customer_id'])) {
            $query->where(['customer_id' => $params['customer_id']]);
        }
         if(isset($params['supplier_id'])) {
            $query->where(['supplier_id' => $params['supplier_id']]);
        }
         if(isset($params['user_id'])) {
            $query->where(['user_id' => $params['user_id']]);
        }
         if(isset($params['description'])) {
            $query->where(['description' => $params['description']]);
        }
         if(isset($params['recieved_amount'])) {
            $query->where(['recieved_amount' => $params['recieved_amount']]);
        }
         if(isset($params['balance'])) {
            $query->where(['balance' => $params['balance']]);
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
              $query->orderByRaw($order);

        }

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
