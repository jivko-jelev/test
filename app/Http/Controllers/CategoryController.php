<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{

    public function __construct()
    {
        View::composer([
            'categories.create',
            'categories.edit',
        ],
            function ($view) {
                $parentCategories = Category::whereNull('parent_id')->pluck('name', 'id');
                $view->with(compact('parentCategories'));
            }
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $categoryRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $categoryRequest)
    {
        $category = Category::create($categoryRequest->validated());
        session()->flash('message', "Категорията \"{$category->name}\" беше успешно създадена");
        if (!is_null($category->parent_id)) {
            session()->flash('category_id', $category->id);
        }

        return response()->json(['route' => route($category->parent_id ? 'questions.create' : 'categories.create')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $categoryRequest
     * @param Category        $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $categoryRequest, Category $category)
    {
        $category->fill($categoryRequest->validated())->save();

        return response()->json(['message' => "Категорията \"{$category->name}\" беше успешно обновена"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @param Request  $request
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function destroy(Category $category, Request $request)
    {
        if (!$request->input('delete-confirmed')) {
            return view('partials.confirm-delete', [
                'message'    => 'Сигурни ли сте, че искате да изтриете категорията?',
                'route'      => route('categories.destroy', $category),
                'resourceId' => $category->id,
            ]);
        }
        $category->delete();
    }
}
