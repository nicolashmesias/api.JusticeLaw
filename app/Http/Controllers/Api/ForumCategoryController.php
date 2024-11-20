<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use Illuminate\Http\Request;

class ForumCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $forumCategories = ForumCategory::all();
        $forumCategories = ForumCategory::included()->get();
        return response()->json($forumCategories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required|max:210'
        ]);

        $forumCategory = ForumCategory::create($request->all());

        return response()->json($forumCategory);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $forumCategory = ForumCategory::findOrFail($id);
        return response()->json($forumCategory);
    }

    public function showView($id)
{
    $category = ForumCategory::findOrFail($id);
    $category->increment('views'); // Incrementa el contador de visitas
    return view('foro.categoria', compact('category')); // Muestra la vista con la categoría
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForumCategory $forumCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ForumCategory $forumCategory)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required|max:210'
        ]);

        $forumCategory->update($request->all());

        return response()->json($forumCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumCategory $forumCategory)
    {
        $forumCategory->delete();
        return response()->json($forumCategory);
    }

    public function getTrends()
    {
        $trendingItems = ForumCategory::orderBy('views', 'desc')->take(5)->get();
        return response()->json($trendingItems);
    }

}
