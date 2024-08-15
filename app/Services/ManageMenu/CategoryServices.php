<?php

namespace App\Services\ManageMenu;
use App\Models\Category;
use App\Services\CRUDServices;
class CategoryServices  extends CRUDServices
{

    public function __construct()
    {
        parent::__construct(new Category); 
    }
    

    public function ShowCategory(){
        $data = Category::with('section')->get();
    return ['message' => 'show succ',
    'data' => $data];
    }

    public function delete($id)
    {
        // return $this->model->find($id);
        $this->model->find($id)->each->delete();
        return ['message' => ' delete succ', 'data' => '  '];
    }

}