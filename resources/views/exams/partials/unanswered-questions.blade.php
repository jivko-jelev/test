<span class="bb-3-{{ $exam->isFinished() ? 'seagreen' : 'red' }}">
@if($exam->questions_count - $exam->answered_questions_count == 0)
    0% ({{ $exam->questions_count - $exam->answered_questions_count . '/' . $exam->questions_count }})
@else
    <a href="{{ route('exams.unanswered.questions', $exam) }}">
        {{ $exam->getUnansweredQuestionsPercent() }}%
        ({{ $exam->questions_count - $exam->answered_questions_count . '/' . $exam->questions_count }})
    </a>
@endif
</span>
