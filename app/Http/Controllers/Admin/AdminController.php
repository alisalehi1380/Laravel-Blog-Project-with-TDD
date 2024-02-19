<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Writer\Requests\CreateWriterRequest;
use App\Http\Requests\createCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function storeWriter(CreateWriterRequest $request)
    {
        User::query()->create([
            User::NAME     => $request->name,
            User::EMAIL    => $request->email,
            User::PASSWORD => Hash::make($request->name),
            User::TYPE     => User::WRITER
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
    
    public function storeNewCategory(CreateCategoryRequest $request)
    {
        $slug = SLUG($request->title);
        
        Category::query()->create([
            Category::TITLE => $request->title,
            Category::SLUG  => $slug
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
            Category::TITLE => $request->title,
            Category::SLUG  => SLUG($request->title)
        ]);
        
        return redirect(route('list.category.admin'))->with('success', 'category updated successfully');
    }
}
