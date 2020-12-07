@if($exam->answered_questions_count)
    @if($exam->correct_answers_count)
        <a href="{{ route('exams.correct.answers', $exam) }}">
    @endif
        <span class="bb-3-{{ $exam->answered_questions_count == $exam->correct_answers_count ? 'seagreen' : 'red' }}">
            {{ round(($exam->correct_answers_count / $exam->answered_questions_count) * 100) }}%
            ({{ $exam->correct_answers_count . '/' . $exam->answered_questions_count }})
        </span>
    @if($exam->correct_answers_count)
        </a>
    @endif
@else
    <span>N / A</span>
@endif
