<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactondetails extends Model
{
    protected $table = 'transaction_detail';
    public $timestamps = false;
    protected $fillable = ['transaction_id', 'debit','credit','account_num','type', 'description', 'status'];
    static public function rules($id=NULL)
    {
        return [
            'transaction_id' => 'required',
            'debit' => 'required',
            'credit' => 'required',
            'account_num' => 'required',
            'type' => 'required',
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

        $query = Transactondetails::select(['transaction_id', 'debit','credit','account_num','type', 'description', 'status']);
            //->limit($limit)
            //->offset($offset);

       // $count = Developer::where('active', 1)->count();

      // ['transaction_id', 'debit','credit','account_num','type', 'description', 'status']
        if(isset($params['id'])) {
            $query->where(['id' => $params['id']]);
        }
        if(isset($params['transaction_id'])) {
            $query->where(['transaction_id' => $params['transaction_id']]);
        } 
        if(isset($params['debit'])) {
            $query->where(['debit' => $params['debit']]);
        }
         if(isset($params['credit'])) {
            $query->where(['credit' => $params['credit']]);
        }
         if(isset($params['account_num'])) {
            $query->where(['account_num' => $params['account_num']]);
        }
         if(isset($params['type'])) {
            $query->where(['type' => $params['type']]);
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
