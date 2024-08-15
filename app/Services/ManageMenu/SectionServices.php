<?php

namespace App\Services\ManageMenu;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\JsonResponse;

use App\Models\Section;
use App\Services\CRUDServices;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SectionServices extends CRUDServices
{
    public function __construct()
    {
        parent::__construct(new Section()); 
    }

    public function ChangeStatus($request)
    {
        $section = Section::where('id', $request['id'])->first();
        if ($section['status']) {
            $section['status'] = false;
$products =ProductType::with('category.section')->get();
foreach($products as $product){
    
    if($product->category->section->id ==$request['id'] ){
      
        $product->status=0;
        $product->save();
    }
}

        }
        else {
            $section['status'] = true;
            $products =ProductType::with('category.section')->get();
            foreach($products as $product){
                
                if($product->category->section->id ==$request['id'] ){
                  
                    $product->status=1;
                    $product->save();
        }
        }}
        $section->save();
        return ['message' => 'status changed succ', 'data' => $section];
    }


    public function delete($id)
    {
        // return $this->model->find($id);
        $this->model->find($id)->each->delete();
        return ['message' => ' delete succ', 'data' => '  '];
    }


}