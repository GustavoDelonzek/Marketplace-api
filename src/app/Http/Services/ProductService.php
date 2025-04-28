<?php

namespace App\Http\Services;

use App\Exceptions\Business\ImageNotFoundException;
use App\Exceptions\Business\NothingToUpdateException;
use App\Exceptions\Http\BadRequestException;
use App\Http\Repositories\ProductRepository;
use App\Http\Resources\ProductResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductService{
    use CanLoadRelationships;
    private array $relations = ['category', 'discounts'];

    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function getAllProducts(){
        $queryProducts = $this->productRepository->getAllProducts();

        $products = $this->loadRelationships($queryProducts)->get();

        return ProductResource::collection($products);
    }

    public function createProduct($productData){
        return $this->productRepository->createProduct($productData);
    }

    public function showProduct($productId){
        $productQuery = $this->productRepository->showProduct($productId);
        $product = $this->loadRelationships($productQuery);
        return new ProductResource($product);
    }

    public function updateProduct($productId, $productData){
        if(empty($productData)){
            throw new NothingToUpdateException();
        }

        $updated = $this->productRepository->updateProduct($productId, $productData);

        if(!$updated){
            throw new NothingToUpdateException();
        }

        return $updated;
    }

    public function updateStock($productId, $productData){
        if(empty($productData)){
            throw new NothingToUpdateException();
        }
        $updated = $this->productRepository->updateProduct($productId, $productData);

        if(!$updated){
            throw new NothingToUpdateException();
        }

        return $updated;
    }

    public function deleteProduct( $productId){
        return $this->productRepository->deleteProduct($productId);
    }

    public function getAllProductsByCategory($categoryId){
        $products = $this->productRepository->getAllProductsByCategory($categoryId);
        return ProductResource::collection($products);
    }

    public function updateImage($productId, $image){
        $product = $this->productRepository->showProduct($productId);
        $imageNome = Str::uuid() . '.' . $image->getClientOriginalExtension();


        if($product->image_path){
            Storage::delete($product->image_path);
        }

        $path = Storage::putFileAs('public/products', $image, $imageNome);

        return $this->productRepository->updateProduct($productId, ['image_path' => $path]);
    }

    public function showImage($productId){
        $product = $this->productRepository->showProduct($productId);

        if(!$product->image_path || !Storage::exists($product->image_path)){
            throw new ImageNotFoundException();
        }

        $file = Storage::get($product->image_path);
        $mime = Storage::mimeType($product->image_path);

        return response()->make($file, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
        ]);

    }
}
