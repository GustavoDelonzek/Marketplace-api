<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        if(!$category->image_path){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Image not found',
                ], 404)
            );
        }

        if (!Storage::exists($category->image_path)) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Image not found',
                ], 404)
            );
        }

        $file = Storage::get($category->image_path);
        $mime = Storage::mimeType($category->image_path);

        return response()->make($file, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
        ]);
    }
}
