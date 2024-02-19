<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\createCategoryRequest;
use App\Http\Requests\CreateWriterRequest;
use App\Http\Requests\ListWriterRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function storeWriter(CreateWriterRequest $request)
    {
        User::query()->create([
            User::col_name     => $request->name,
            User::col_email    => $request->email,
            User::col_password => Hash::make($request->name),
            User::col_type     => User::type_writer
        ]);
        
        return redirect(route('new.writer.admin'))->with('success', 'new Writer Created Successfully');
    }
    
    public function showWriterList()
    {
        $writers = User::query()->where('type', 'writer')->paginate(2);
        return view('admin.writer.list', compact('writers'));
        
    }
    
    public function showWriterPosts(User $user)
    {
        $writer = $user;
        return view('admin.writer.writerpostlists', compact('writer'));
    }
    
    public function storeNewCategory(createCategoryRequest $request)
    {
        $slug = SLUG($request->title);
        
        Category::query()->create([
            Category::col_title => $request->title,
            Category::col_slug  => $slug
        ]);
        
        return redirect(route('new.category.admin'))->with('success', 'new Category Created SuccessFully');
    }
    
    public function showCategoryList()
    {
        $categories = Category::query()->paginate(3);
        return view('admin.category.list', compact('categories'));
    }
    
    public function editCategory(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }
    
    public function updateCategory(UpdateCategoryRequest $request, Category $category)
    {
        $category->update([
            Category::col_title => $request->title,
            Category::col_slug  => SLUG($request->title)
        ]);
        
        return redirect(route('list.category.admin'))->with('success', 'category updated successfully');
    }
}
