<?php

namespace App\Services\ManageMenu;
use App\Models\Review\Comment;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use App\Models\ProductType;
use App\Services\CRUDServices;
use Illuminate\Support\Facades\Storage;
use Illuminate\support\facades\DB; 
use Illuminate\Support\Str;

class ProductServices  extends CRUDServices
{

    public function __construct()
    {
        parent::__construct(new ProductType); 
    }


    public function Addproducts($request , $path){
        $data1 = Product::firstOrCreate([
            'product_information'=>$request['product_information'],
           'product_path'=>$path
        ]);

        $data = ProductType::create([
            'name'=>$request['name'],
            'price'=>$request['price'],
            'calories'=>$request['calories'],
           'category_id'=>$request['category_id'],
           'product_id'=>$data1->id,
        ]);

        return ['message' => ' create succ', 'data' =>$data];
    }    

 public function Filter($request){
    
    $data = DB::table('Categories')
    ->where('category_id','=',$request->id)
    ->leftJoin('product_types', 'product_types.Category_id', '=', 'Categories.id')
    ->leftJoin('products', 'products.id', '=', 'product_types.product_id')->where('product_types.status',1)
    ->get(['product_types.name as product_name','product_types.total_ratings','Products.product_information','Products.product_path','product_types.category_id' , 'Categories.category_name', 'product_types.id']);
 foreach($data as $product){
    $comment = Comment::where('product_id',$product->id)->get()->count();
    $product->comment=$comment;
    
 }
    return [
        'message' => 'show with filter succ',
       'data' => $data];
 } 

public function showproduct(){
    $data = DB::table('product_types')
    ->leftJoin('Categories', 'Categories.id', '=', 'product_types.category_id')
    ->leftJoin('products', 'products.id', '=', 'product_types.product_id')->where('product_types.status',1)
    ->get(['product_types.name as product_name','product_types.price','product_types.Calories','Products.product_information','Products.product_path','product_types.category_id' , 'Categories.category_name', 'product_types.id']);
  
return ['message' => 'show succ',
'data' => $data];
}

public function updateproduct($id, $data ,$path)
{

    $data['product_path']= $path;  
    $ProductId = Product::find($id);
    $ProductId->update($data);
     return ['message' =>   $ProductId, 'data' => $ProductId];  
}

public function updateproducts($id, $data)
{
    $TypeId = ProductType::find($id);
    $TypeId->update($data);
     return ['message' =>   $TypeId->product_id, 'data' => $TypeId];  
}

public function showDetails($request){
    $data = DB::table('product_types')
    ->where('product_types.id','=',$request->id)
    ->leftJoin('Categories', 'Categories.id', '=', 'product_types.category_id')
    ->leftJoin('products', 'products.id', '=', 'product_types.product_id')
    ->first(['product_types.name as product_name','product_types.price','product_types.total_ratings','product_types.Calories','Products.product_information','Products.product_path','product_types.category_id' , 'Categories.category_name', 'product_types.id']);
 $comment = Comment::where('product_id',$data->id)->get()->count();
 $data->comment=$comment;
 
    return [
    'message' => 'show succ',
    'data' => $data];
}
 
public function delete($id)
{
    $this->model->find($id)->each->delete();
    return ['message' => ' delete succ', 'data' => '  '];
}




}