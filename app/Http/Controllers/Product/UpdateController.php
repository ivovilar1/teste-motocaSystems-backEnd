<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Product $product, ProductRequest $request)
    {
        $validated = $request->validated();
        $validated['price'] = formatPriceAsInt($validated['price']);
        $product->update($validated);
        return ProductResource::make($product);
    }
}
