@if($exam->wrong_answers_count)
    <form action="{{ route('exams.post.answering.wrong.answers') }}" method="post">
        <input type="hidden" value="{{ $exam->id }}" name="exam[]">
        <button class="btn btn-sm btn-primary">
{{--            <i class="fab fa-leanpub"></i> --}}
            Сгрешените</button>
    </form>
@endif
