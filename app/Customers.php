<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customer';
    public $timestamps = false;
    protected $fillable = ['name', 'mobile', 'state_id','city_id','area_id',
     'block_id', 'address', 'delivery_boy_id', 'user_id','status'];
    static public function rules($id=NULL)
    {
        return [
            'name' => 'required',
            'mobile' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'block_id' => 'required',
            'address' => 'required',
            'delivery_boy_id' => 'required',
            'user_id' => 'required',
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

        $query = Customers::select(['name', 'mobile', 'state_id','city_id','area_id', 'block_id',
         'address', 'delivery_boy_id', 'user_id','status']);
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
        if(isset($params['mobile'])){
            $query->where('mobile','like',$params['mobile']);
        }
        if(isset($params['state_id'])){
            $query->where('state_id','like',$params['state_id']);
        }
        if(isset($params['city_id'])){
            $query->where('city_id','like',$params['city_id']);
        }
        if(isset($params['area_id'])){
            $query->where('area_id','like',$params['area_id']);
        }
        if(isset($params['block_id'])){
            $query->where('block_id','like',$params['block_id']);
        }
        if(isset($params['address'])){
            $query->where('address','like',$params['address']);
        }
        if(isset($params['delivery_boy_id'])){
            $query->where('delivery_boy_id','like',$params['delivery_boy_id']);
        }
        if(isset($params['user_id'])){
            $query->where('user_id','like',$params['user_id']);
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