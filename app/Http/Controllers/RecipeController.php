<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
        $categories = Category::all();

        return view('recipes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $posts = $request->all();

        Recipe::insert([
            'id' => Str::uuid(),
            'title' => $posts['title'],
            'description' => $posts['description'],
            'category_id' => $posts['category'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('recipe.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recipe = Recipe::with('ingredients', 'steps', 'reviews.user', 'user')->where('recipes.id', $id)->first();
        $recipe_record = Recipe::find($id);
        $recipe_record->increment('views');

        return view('recipes.show', compact('recipe'));
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
