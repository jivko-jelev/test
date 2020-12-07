$(function () {
    $('.dropdown-toggle').dropdown();

    let searchables = $('.searchable');
    if (searchables.length) {
        searchables.select2({
            theme: "classic",
        });
    }

    $(document).on('submit', '.ajax-form', function (e) {
        e.preventDefault();

        let form = $(this);
        let data = new FormData(form[0]);
        let url  = form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.help-block').remove();
                $('#messages').empty();
            },
            success: function (data) {
                if (data.route) {
                    window.location.replace(data.route);
                } else if (data.message) {
                    $('#messages').append(`<div class="alert alert-success text-center">${data.message}</div>`);
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    let errors = data.responseJSON;
                    $.each(errors.errors, function (key, value) {
                        let name = key;
                        if (name.indexOf('.') !== -1) {
                            name = key.replace(".", "[").replace(/\./g, "][") + "]";
                        }

                        let input = form.find(':input[name="' + name + '"]').first();
                        if (input.length === 0) {
                            input = form.find(':input[name="' + name + '[]"]').last();
                        }

                        let inputGroup       = input.closest('.input-group');
                        let select2Container = input.parent().find('.select2-container');

                        let inputContainer;
                        let text = '<span class="help-block"><strong>' + value + '</strong></span>';
                        if (select2Container.length) {
                            inputContainer = select2Container;
                            inputContainer.after(text);
                        } else if (inputGroup.length) {
                            inputContainer = inputGroup;
                            inputContainer.append(text);
                        }

                        input.addClass('has-error');
                    });
                } else {
                    $('#messages').append(`<div class="alert alert-danger text-center">${data.responseJSON.message}</div>`);
                }
            }
        });
    });

    let modal = $('#delete-modal');
    $('[data-target="#delete-modal"]').click(function () {
        $.ajax({
            url: $(this).data('route'),
            method: 'delete',
            success: function (data) {
                modal.html(data);
                modal.modal('show');
            },
        });
    });

    let dataTable;
    if ($('script[src="https://cdn.datatables.net/v/bs4/dt-1.10.21/fh-3.1.7/sb-1.0.0/sp-1.1.1/datatables.min.js"]').length) {
        let defaultSort = $('th.defaultSort');
        dataTable       = $('.data-table').DataTable({
            "order": [(defaultSort.index() != -1 ? defaultSort.index() : 0), defaultSort.data('order-by')],
            "pageLength": -1,
            "paging": false,
            "columnDefs": [{
                "targets": 'nosort',
                "orderable": false
            },],
            "language": {
                "lengthMenu": "Показване на _MENU_ записа",
                "info": "Намерени общо _TOTAL_ записа",
                "infoEmpty": "&nbsp;Няма намерени записи",
                "emptyTable": "&nbsp;Няма данни",
                "search": "Търсене:",
                "zeroRecords": "&nbsp;Няма намерени записи",
                "sInfoFiltered": "(филтрирани от общо _MAX_ записа)",
            },
        });
    }
});
