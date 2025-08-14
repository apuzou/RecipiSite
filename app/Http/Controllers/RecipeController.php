<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\Category;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function home()
    {
        $recipes = Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.image', 'users.name')
            ->join('users', 'recipes.user_id', '=', 'users.id')
            ->orderBy('recipes.created_at', 'desc')
            ->limit(3)
            ->get();
        // dd($recipes);

        $popular = Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.image', 'recipes.views', 'users.name')
            ->join('users', 'recipes.user_id', '=', 'users.id')
            ->orderBy('recipes.views', 'desc')
            ->limit(2)
            ->get();
        // dd($popular);

        return view('home', compact('recipes', 'popular'));
    }

    public function index(Request $request)
    {
        $filters = $request->all();

        $query = Recipe::query()->select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.image', 'users.name', \DB::raw('AVG(reviews.rating) as rating'))
            ->join('users', 'recipes.user_id', '=', 'users.id')
            ->leftJoin('reviews', 'recipes.id', '=', 'reviews.recipe_id')
            ->groupBy('recipes.id')
            ->orderBy('recipes.created_at', 'desc');
        if (!empty($filters)) {

            if (!empty($filters['rating'])) {
                $query->havingRaw('AVG(reviews.rating) >= ?', [$filters['rating']])->orderBy('rating', 'desc');
            }

            if (!empty($filters['categories'])) {
                $query->whereIn('recipes.category_id', $filters['categories']);
            }

            if (!empty($filters['title'])) {
                $query->where('recipes.title', 'like', '%' . $filters['title'] . '%');
            }
        }
        $recipes = $query->paginate(5);

        $categories = Category::all();

        return view('recipes.index', compact('recipes', 'categories', 'filters'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
