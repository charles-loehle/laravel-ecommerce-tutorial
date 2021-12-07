<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        // dd($categories);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'name' => 'required|unique:categories',
          'description' => 'required',
          'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        $image = $request->file('image')
                    ->store('public/files');

        // https://laravel.com/docs/8.x/structure#the-storage-directory
        // You should create a symbolic link at public/storage which points to this directory. You may create the link using the php artisan storage:link Artisan command.

        Category::create([
          'name' => $request->name,
          'slug' => Str::slug($request->name),
          'description' => $request->description,
          'image' => $image
        ]);

        // laravel-notify package
        notify()->success('Category created successfully');

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $image = $category->image;

        if($request->hasFile('image')) {
          $image = $request->file('image')
                      ->store('public/files');

          \Storage::delete($category->$image);
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $image;
        $category->save();
        
        // laravel-notify package
        notify()->success('Category updated successfully');

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $filename = $category->image;

        $category->delete();
        \Storage::delete($filename);
        
        // laravel-notify package
        notify()->success('Category deleted successfully');

        return redirect()->route('category.index');
    }
}
