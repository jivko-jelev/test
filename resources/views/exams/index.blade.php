@extends('layouts.master')

@section('style')
@endsection
@section('content')
    <div class="col-sm-10 offset-1">
        <table class="table table-striped table-sm" id="resource-table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Кога</th>
                <th>Категории</th>
                <th class="text-center">Отговорени</th>
                <th class="text-center">Неотговорени</th>
                <th class="text-center">Верни</th>
                <th class="text-center">Грешни</th>
                <th class="text-center" title="само сгрешените"> Преговорѝ</th>
                <th class="text-center">Продължи</th>
                <th class="fit text-center">Приключи</th>
                <th class="text-center">Изтриване</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/dt-1.10.21/fh-3.1.7/sb-1.0.0/sp-1.1.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/fh-3.1.7/sb-1.0.0/sp-1.1.1/datatables.min.js"></script>

    <script>
        let dataTable = $('#resource-table').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "ajax": {
                "type": 'POST',
                "url": "{{ route('exams.ajax') }}",
            },
            "order": [[1, "desc"]],
            "columnDefs": [{
                "orderable": false,
                "targets": [2, 7, 8, 9, 10]
            }],
            "language": {
                "metronicGroupActions": "_TOTAL_ общо избрани записа: ",
                "metronicAjaxRequestGeneralError": "&nbsp;Грешка! Не може да бъде осъществена връзка до сървъра.",
                "lengthMenu": "Показване на _MENU_ записа",
                "info": "Намерени общо _TOTAL_ записа",
                "infoEmpty": "&nbsp;Няма намерени записи",
                "emptyTable": "&nbsp;Няма данни",
                "zeroRecords": "&nbsp;Няма намерени записи",
                "sInfoFiltered": "(филтрирани от общо _MAX_ записа)",
                "search": "Търси",
                "paginate": {
                    "previous": "Предишна",
                    "next": "Следваща",
                    "last": "Последна",
                    "first": "Първа",
                    "page": "Страница",
                    "pageOf": "от"
                }
            },
        });

    </script>
@endsection
