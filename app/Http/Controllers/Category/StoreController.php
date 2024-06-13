<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(CategoryRequest $request)
    {
        $validated = $request->validated();

        $category = Category::query()->create($validated);
    }
}
