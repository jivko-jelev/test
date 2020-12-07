<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\QuestionRequest;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class QuestionController extends Controller
{
    public function __construct()
    {
        View::composer([
            'questions.create',
            'questions.edit',
        ],
            function ($view) {
                $categories = Category::with('children')
                                      ->whereNull('parent_id')
                                      ->orderBy('name')
                                      ->get()
                                      ->sortBy('children.name');

                $view->with(compact('categories'));
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
        $questions = Question::with('category.parent:id,name')->get();

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $category_id = session('category_id') ?? Question::latest()->first()->category_id;

        return view('questions.create', compact('category_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionRequest $questionRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(QuestionRequest $questionRequest)
    {
        Question::create($questionRequest->validated());
        $questionsNum = Question::where('category_id', $questionRequest->category_id)->count();
        session()->flash('message', "Въпрос №$questionsNum в тази категория беше успешно създаден");

        return response()->json(['route' => route('questions.create')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Question $question
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Question            $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(QuestionRequest $questionRequest, Question $question)
    {
        $question->fill($questionRequest->validated())->save();

        return response()->json(['message' => 'Въпросът беше успешно обновен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Question $question
     * @param Request       $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Throwable
     */
    public function destroy(Question $question, Request $request)
    {
        if (!$request->input('delete-confirmed')) {
            return view('partials.confirm-delete', [
                'message'    => 'Сигурни ли сте, че искате да изтриете въпроса?',
                'route'      => route('questions.destroy', $question),
                'resourceId' => $question->id,
            ]);
        }

        $question->delete();
    }
}
