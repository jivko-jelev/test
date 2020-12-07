@if($exam->wrong_answers_count)
    <a href="{{ route('exams.wrong.answers', $exam) }}">
@endif
    @if($exam->answered_questions_count)
    <span class="bb-3-{{ $exam->correct_answers_count == $exam->answered_questions_count ? 'seagreen' : 'red' }}">
        {{ round(($exam->wrong_answers_count / $exam->answered_questions_count) * 100) }}%
        ({{ $exam->wrong_answers_count . '/' . $exam->answered_questions_count }})
    </span>
    @else
        N / A
    @endif
@if($exam->wrong_answers_count)
    </a>
@endif
