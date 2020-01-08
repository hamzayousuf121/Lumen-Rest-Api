<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'product';
    public $timestamps = false;
    protected $fillable = ['id','name','description','price','category_id', 'supplier_id','unit_id','status'];
    static public function rules($id=NULL)
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'unit_id' => 'required',
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

        $query = Products::select(['id','name','description','price','category_id', 
        'supplier_id','unit_id','status']);
            //->limit($limit)
            //->offset($offset);

       // $count = Developer::where('active', 1)->count();


        if(isset($params['id'])) {
            $query->where(['id' => $params['id']]);
        }

        // if(isset($params['created_at'])) {
        //     $query->where(['created_at' => $params['created_at']]);
        // }
        // if(isset($params['updated_at'])) {
        //     $query->where(['updated_at' => $params['updated_at']]);
        // }
        
        if(isset($params['name'])) {
            $query->where('name','like',$params['name']);
        }
        if(isset($params['description'])){
            $query->where('description','like',$params['description']);
        }
        if(isset($params['price'])){
            $query->where('price','like',$params['price']);
        }
        if(isset($params['category_id'])){
            $query->where('category_id','like',$params['category_id']);
        }
        if(isset($params['supplier_id'])){
            $query->where('supplier_id','like',$params['supplier_id']);
        }
        if(isset($params['unit_id'])){
            $query->where('unit_id','like',$params['unit_id']);
        }
        if(isset($params['status'])){
            $query->where('status','like',$params['status']);
        }

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
?>