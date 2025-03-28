<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;
use App\Models\User;
use Error;
use Exception;

class CategoryService{

    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getAllCategories(){
        return $this->categoryRepository->getAllCategories();
    }

    public function createCategory(User $user, $categoryData){
        if($user->role !== 'admin'){
            throw new Error('Permission denied for this action');
        }

        return $this->categoryRepository->createCategory($categoryData);
    }

    public function showCategory($categoryId){
        return $this->categoryRepository->showCategory($categoryId);
    }

    public function updateCategory($categoryData, $categoryId,User $user){

        if($user->role !== 'admin'){
            throw new Error('Permission denied for this action');
        }

        if(empty($categoryData)){
            throw new Exception('Nothing to update!', 204);
        }

        return $this->categoryRepository->updateCategory($categoryId, $categoryData);

    }

    public function deleteCategory($categoryId,User $user){
        if($user->role !== 'admin'){
            throw new Error('Permission denied for this action');
        }

        return $this->categoryRepository->deleteCategory($categoryId);
    }
}
