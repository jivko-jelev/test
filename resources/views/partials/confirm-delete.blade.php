<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Изтриване</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>{{ $message }}</p>
            <span class="error d-none" id="error">Възникна някаква грешка!</span>
        </div>
        <div class="modal-footer">
            <form action="{{ $route }}" method="post" class="delete-form">
                <button type="submit" class="btn btn-primary">Да</button>
                @method('delete')
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отказ</button>
        </div>
    </div>
</div>

<script>
    $('.delete-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'delete',
            data: {'delete-confirmed': 1},
            success: function () {
                $('#delete-modal').modal('hide');
                let resource=$('#resource-{{ $resourceId }}');
                $(resource).fadeOut("slow", function() {
                    resource.remove();
                    $('#resource-table tr td:first-child').each(function (index) {
                        $(this).html(++index + '.');
                    });
                });
            },
            error: function (data) {
                let error = $('#error');
                error.html('Грешка: ' + JSON.parse(data.responseText).message)
                error.removeClass('d-none');
            },
        });
    });
</script>
