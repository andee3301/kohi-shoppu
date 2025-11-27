<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('products')->orderBy('id')->get();

        return view('shop.index', [
            'categories' => $categories,
        ]);
    }
}
