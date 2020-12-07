@if(!$exam->isFinished())
    <a href="{{ route('exams.questions.show', $exam) }}" class="btn btn-sm btn-primary">
{{--        <i class="fab fa-leanpub"></i> --}}
        Продължи
    </a>
@endif
