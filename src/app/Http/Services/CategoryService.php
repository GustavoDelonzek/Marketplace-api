<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;

class CategoryService{

    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getAllCategories(){
        return $this->categoryRepository->getAllCategories();
    }
}
