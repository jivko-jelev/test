<div class="col-md-6 offset-3 mt-2">
    <div class="col-md-12">
        <form action="{{ route('exams.questions.store', [$exam, $question->id] ) }}" method="post" id="question">
            <p><strong>Категория: </strong>{{ $question->category->name }}</p>
            <p><strong>Въпрос: </strong>{{ $question->content }}</p>
            <div class="form-group">
                <textarea class="form-control" name="answer" rows="15" placeholder="Отговор" autofocus id="answer"></textarea>
            </div>
            <button class="btn btn-block btn-secondary" id="submit">Следващ</button>
        </form>
        <p class="text-center mt-5">Отговорено на
            <strong>{{  $answeredQuestions . ' / ' . $totalQuestionsNum}}</strong> въпроса
        </p>
        <p class="text-center">{{ round(($answeredQuestions / $totalQuestionsNum) * 100) }}%</p>
        <div class="answered-questions" style="width: {{ ($answeredQuestions / $totalQuestionsNum) * 100 }}%">
        </div>
    </div>
</div>

<script>
    $('#question').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            method: 'post',
            beforeSend: function () {
                $('#messages').empty();
            },
            success: function (data) {
                if (data.route) {
                    window.location.replace(data.route);
                } else {
                    $('#question-content').html(data);
                    $('[name="answer"]').focus();
                }
            }
        })
    });

    $('#question').on('keyup', function (e) {
        $('#submit').html($('[name="answer"]').val().length ? 'Запиши' : 'Следващ');
    });
</script>
