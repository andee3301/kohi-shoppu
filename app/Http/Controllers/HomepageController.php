<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class HomepageController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->with('products')
            ->orderBy('id')
            ->get();

        return view('homepage', [
            'categories' => $categories,
        ]);
    }
}
