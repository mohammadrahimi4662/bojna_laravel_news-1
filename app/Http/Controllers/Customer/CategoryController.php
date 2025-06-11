<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function show(Category $category)
    {
        // $categories = Category::where('status', 1)->withCount('category')->get();

        

        return view('customer.news.category', compact('category'));
    }


}
