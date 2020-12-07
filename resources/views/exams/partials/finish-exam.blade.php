@if($exam->answered_questions_count && !$exam->isFinished())
    <form action="{{ route('exams.update', $exam) }}" method="post">
        <button class="btn btn-sm btn-primary"
                title="Ще бъдат изтрити всички въпроси на които не е отговорено,{{ PHP_EOL }}както и тези категории към преговора, за които няма въпрос{{ PHP_EOL }}на който е отговорено.">
            <i class="fas fa-hourglass-end"></i> Приключи
        </button>
        @csrf
        @method('put')
    </form>
@endif
