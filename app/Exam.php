<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exam extends Model
{

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)
                    ->withPivot('answer');
    }

    public function answeredQuestions()
    {
        return $this->belongsToMany(Question::class)
                    ->withPivot('answer')
                    ->wherePivot('answer', '!=', null);
    }

    public function unansweredQuestions()
    {
        return $this->belongsToMany(Question::class)
                    ->withPivot('answer')
                    ->wherePivot('answer', null);
    }

    public function correctAnswers()
    {
        return $this->belongsToMany(Question::class)
                    ->withPivot('answer')
                    ->wherePivot('answer', '=', DB::raw('questions.answer'));
    }

    public function wrongAnswers()
    {
        return $this->belongsToMany(Question::class)
                    ->withPivot('answer')
                    ->wherePivot('answer', '!=', DB::raw('questions.answer'));
    }

    public function getCreatedAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->answered_questions_count == $this->questions_count;
    }

    /**
     * @return int
     */
    public function getUnansweredQuestionsPercent(): int
    {
        return $this->answered_questions_count ?
            (round((($this->questions_count - $this->answered_questions_count) / $this->questions_count) * 100)) :
            100;
    }

    /**
     * @return float|null
     */
    public function getCorrectAnswersPercent()
    {
        return $this->answered_questions_count ?
            round(($this->correct_answers_count / $this->answered_questions_count) * 100) :
            null;
    }

}
