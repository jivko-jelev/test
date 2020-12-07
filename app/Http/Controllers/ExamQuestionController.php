<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Question;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{

    /**
     * @param Exam $exam
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show(Exam $exam)
    {
        $question = $exam->unansweredQuestions()->inRandomOrder()->first();

        if (!$question) {
            return response()->json(['route' => route('exams.show', $exam)]);
        }

        $totalQuestionsNum = $exam->questions->count();
        $answeredQuestions = $exam->answeredQuestions->count();

        $view = \request()->ajax() ? 'partials.question' : 'questions-show';

        return view($view, [
            'exam'              => $exam,
            'question'          => $question,
            'totalQuestionsNum' => $totalQuestionsNum,
            'answeredQuestions' => $answeredQuestions,
        ]);
    }

    public function store(Exam $exam, Question $question, Request $request)
    {
        if ($request->input('answer')) {
            $exam->questions()->updateExistingPivot($question, ['answer' => $request->input('answer')]);
        }

        return $this->show($exam);
    }
}
