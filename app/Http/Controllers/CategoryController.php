<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
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
        $this->authorize('manage', 'App\Models\Category');
        $categories = Category::orderBy('display_order')->get();

        return view('admin.categories.index',[
            'categories' => $categories
        ]);
    }

    public function upsert(Request $request)
    {
        $this->authorize('manage', 'App\Models\Category');

        $categories = $request->post('categories');

        foreach ($categories as $cat){
            
            $cat['created_at'] = Carbon::now()->toDateTimeString();
            $cat['updated_at'] = Carbon::now()->toDateTimeString();

            if($cat['id']){
                Category::where('id', $cat['id'])->update($cat);
            } else {
                Category::create($cat);
            }
        }
        
        return [
            'success' => true,
            'categories' => Category::all()
        ];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the items in a category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function items(Category $category)
    {
        return $category->menuItems->map(function ($item) {
            return $item->only(['id', 'name']);
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return ['success' => true];
    }
}
