<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function all()
    {
        return ProductResource::collection(
            $this->productRepository->all()
        );
    }

    public function show($product)
    {
        return response()->json(['data' => ProductResource::make(
            $this->productRepository->findOrFail($product)
        )]);
    }

    public function store(StoreRequest $request)
    {
        $product = $this->productRepository->create(
            $request->name,
            $request->description,
            $request->file('image'),
            $request->price,
            $request->slug,
            $request->is_active,
        );
        return response()->json(['data' => ProductResource::make($product)]);
    }

    public function update(UpdateRequest $request, $product)
    {
        $product = $this->productRepository->findOrFail($product);

        // update all sent attributes except image
        $product->update(
            Arr::except($request->validated(), ['image'])
        );

        // update image if exist
        if ($request->hasFile('image')) {
            $product->updateImage($request->file('image'));
        }
        return $this->show($product->id);
    }

    public function delete($product)
    {
        $this->productRepository->findOrFail($product)->delete();
        return response()->json();
    }
}
