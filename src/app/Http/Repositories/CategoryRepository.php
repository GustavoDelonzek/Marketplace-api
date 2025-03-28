<?php

namespace App\Http\Repositories;

use App\Models\Category;

class CategoryRepository{

    public function getAllCategories(){
        return Category::all();
    }

    public function createCategory($categoryData){
        return Category::create($categoryData);
    }

    public function updateCategory($categoryId, $categoryData){
        return Category::where('id', $categoryId)->update($categoryData);
    }

    public function showCategory($categoryId){
        return Category::findOrFail($categoryId);
    }

    public function deleteCategory($categoryId){
        return Category::where('id', $categoryId)->delete();
    }


}
