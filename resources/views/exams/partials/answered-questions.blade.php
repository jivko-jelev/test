@if($exam->answered_questions_count)
    <a href="{{ route('exams.show', $exam) }}">
@endif
    <span class="bb-3-{{ $exam->isFinished() ? 'seagreen' : 'red' }}">
        {{ round(($exam->answered_questions_count / $exam->questions_count) * 100) }}%
        ({{ $exam->answered_questions_count . '/' . $exam->questions_count }})
    </span>
@if($exam->answered_questions_count)
    </a>
@endif

