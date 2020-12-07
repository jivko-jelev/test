<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exam;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ExamController extends Controller
{

    public function __construct()
    {
        View::composer([
            'exams.create',
            'exams.edit',
        ],
            function ($view) {
                $categories = Category::whereNotNull('parent_id')
                                      ->with('parent')
                                      ->withCount('questions')
                                      ->orderBy('name')
                                      ->get();

                $view->with(compact('categories'));
            }
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return view('exams.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('exams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'categories' => 'required',
        ]);
        $exam = Exam::create();
        if (in_array('on', $request->categories)) {
            $exam->categories()->attach(Category::whereNotNull('parent_id')->pluck('id'));
            $exam->questions()->attach(Question::pluck('id'));
        } else {
            $exam->categories()->attach($request->input('categories'));
            $exam->questions()->attach(Question::whereIn('category_id', $request->input('categories'))->pluck('id'));
        }

        session()->flash('message', "Преговорът беше успешно създаден");

        return response()->json(['route' => route('exams.questions.show', $exam)]);
    }

    /**
     * @param Exam $exam
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Exam $exam)
    {
        return view('exams.show', [
            'exam'              => $exam,
            'questionsNum'      => $exam->questions->count(),
            'answeredQuestions' => $exam->answeredQuestions,
        ]);
    }

    /**
     * @param Exam    $exam
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Exam $exam)
    {
        $answeredQuestionsCategory   = $exam->answeredQuestions->unique('category_id')->pluck('category_id');
        $unansweredQuestionsCategory = $exam->unansweredQuestions->unique('category_id')->pluck('category_id');
        $exam->categories()->detach($unansweredQuestionsCategory->diff($answeredQuestionsCategory));
        $exam->unansweredQuestions()->detach($exam->unansweredQuestions->pluck('id'));

        return redirect()->back()->with('message', 'Преговорът беше успешно приключен');
    }

    /**
     * @param Exam    $exam
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function destroy(Exam $exam, Request $request)
    {
        if (!$request->input('delete-confirmed')) {
            return view('partials.confirm-delete', [
                'message'    => 'Сигурни ли сте, че искате да изтриете преговора?',
                'route'      => route('exams.destroy', $exam),
                'resourceId' => $exam->id,
            ]);
        }

        $exam->delete();
    }

    /**
     * @param Exam $exam
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wrongAnswers(Exam $exam)
    {
        return view('exams.wrong-answers', ['wrongAnswers' => $exam->wrongAnswers]);
    }

    /**
     * @param Exam $exam
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function correctAnswers(Exam $exam)
    {
        return view('exams.correct-answers', ['correctAnswers' => $exam->correctAnswers]);
    }

    /**
     * @param Exam $exam
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unansweredQuestions(Exam $exam)
    {
        return view('exams.unanswered-questions', ['unansweredQuestions' => $exam->unansweredQuestions]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createAnsweringWrongAnswers()
    {
        $exams              = Exam::with('categories')
                                  ->withCount('wrongAnswers')
                                  ->has('wrongAnswers')
                                  ->latest()
                                  ->get();
        $uniqueWrongAnswers = $this->getUniqueWrongAnswers();

        return view('exams.answering-wrong-answers', compact('exams', 'uniqueWrongAnswers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postAnsweringWrongAnswers(Request $request)
    {
        $request->validate(['exam' => 'required|array']);

        $exam         = Exam::create();
        $wrongAnswers = $this->getUniqueWrongAnswers($request->exam);
        $exam->categories()->attach($wrongAnswers->pluck('category_id')->unique());
        $exam->questions()->attach($wrongAnswers->pluck('question_id'));
        if ($request->ajax()) {
            return response()->json(['route' => route('exams.questions.show', $exam)]);
        }

        return redirect()->to(route('exams.questions.show', $exam));
    }

    /**
     * @param array|string[] $examIds
     * @return mixed
     */
    private function getUniqueWrongAnswers(array $examIds = ['on'])
    {
        return Exam::select('questions.id as question_id', 'categories.id as category_id', 'categories.name')
                   ->join('exam_question as eq', function ($join) use ($examIds) {
                       $join->on('eq.exam_id', 'exams.id')
                            ->when(!in_array('on', $examIds), function ($query) use ($examIds) {
                                $query->whereIn('exams.id', $examIds);
                            });
                   })
                   ->join('questions', function ($join) {
                       $join->on('questions.id', 'eq.question_id')
                            ->whereNull('deleted_at')
                            ->whereColumn('questions.answer', '!=', 'eq.answer');
                   })
                   ->join('categories', function ($join) {
                       $join->on('categories.id', 'questions.category_id')
                            ->whereNull('categories.deleted_at');
                   })
                   ->distinct()
                   ->get();
    }

    public function ajax(Request $request)
    {
        $ajaxGridColumnNames = [
            1 => 'created_at',
        ];

        $exams = Exam::with('categories')
                     ->withCount('questions', 'answeredQuestions', 'correctAnswers', 'wrongAnswers');

        $recordsTotal = $recordsFiltered = $exams->count();

        $recordsFiltered = $exams->count();

        $orderState = $request->get('order');
        foreach ($orderState as $singleOrderState) {
            $exams->orderBy($ajaxGridColumnNames[$singleOrderState['column']], $singleOrderState['dir']);
        }

        if ($request->input('start') > 0) {
            $exams->skip($request->input('start'));
        }
        if ($request->input('length') > 0) {
            $exams->take($request->input('length'));
        }

        $data = collect();
        foreach ($exams->get() as $key => $exam) {
            $data->push([
                ++$key,
                '<span title="' . $exam->created_at->format('d/m/Y H:i:s') . '">' . $exam->created_at->diffForHumans() . '</span>',
                $exam->categories->pluck('name')->join(', ', ' и '),
                $exam->answered_questions_count,
                $exam->questions_count - $exam->answered_questions_count,
                $exam->correct_answers_count,
                $exam->wrong_answers_count,
                view('exams.partials.negotiate-wrong-answers', compact('exam'))->render(),
                view('exams.partials.continue-exam', compact('exam'))->render(),
                view('exams.partials.finish-exam', compact('exam'))->render(),
                view('exams.partials.delete-exam', compact('exam'))->render(),
            ]);
        }

        return response()->json([
            'data'            => $data,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'filter'          => [],
        ]);
    }
}
