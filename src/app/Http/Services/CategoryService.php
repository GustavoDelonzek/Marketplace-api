<?php

namespace App\Http\Services;

use App\Exceptions\Business\ImageNotFoundException;
use App\Exceptions\Business\NothingToUpdateException;
use App\Http\Repositories\CategoryRepository;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\CanLoadRelationships;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService{
    use CanLoadRelationships;
    private array $relations = ['products'];

    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getAllCategories(){
        $query = $this->categoryRepository->getAllCategories();

        $categories = $this->loadRelationships($query)->get();

        return CategoryResource::collection($categories);
    }

    public function createCategory($categoryData){
        return $this->categoryRepository->createCategory($categoryData);
    }

    public function showCategory($categoryId){
        $categoryQuery = $this->categoryRepository->showCategory($categoryId);
        $category = $this->loadRelationships($categoryQuery);
        return new CategoryResource($category);
    }

    public function updateCategory($categoryData, $categoryId){
        if(empty($categoryData)){
            throw new NothingToUpdateException();
        }

        return $this->categoryRepository->updateCategory($categoryId, $categoryData);
    }

    public function deleteCategory($categoryId){
        return $this->categoryRepository->deleteCategory($categoryId);
    }

    public function updateImage($categoryId, $image){
        $category = $this->categoryRepository->showCategory($categoryId);
        $imageNome = Str::uuid() . '.' . $image->getClientOriginalExtension();

        if($category->image_path){
            Storage::delete($category->image_path);
        }

        $path = Storage::putFileAs('public/categories', $image, $imageNome);

        return $this->categoryRepository->updateCategory($categoryId, ['image_path' => $path]);
    }

    public function showImage($categoryId){
        $category = $this->categoryRepository->showCategory($categoryId);

        if(!$category->image_path || !Storage::exists($category->image_path)){
            throw new ImageNotFoundException();
        }

        $file = Storage::get($category->image_path);
        $mime = Storage::mimeType($category->image_path);

        return response()->make($file, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
        ]);
    }
}
