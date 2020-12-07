@extends('layouts.master')

@section('content')
    <div class="col-sm-10 offset-1">
        <table class="table table-striped table-sm data-table">
            <thead class="thead-dark">
            <tr>
                <th class="defaultSort" data-order-by="asc">#</th>
                <th>Въпрос</th>
                <th>Отговор</th>
                <th class="w-25">Отговор от документацията</th>
            </tr>
            </thead>
            <tbody>
            @foreach($wrongAnswers as $wrongAnswer)
                <tr>
                    <td class="text-right">{{ $loop->iteration }}.</td>
                    <td>{{ $wrongAnswer->content }}</td>
                    <td>{{ $wrongAnswer->pivot->answer }}</td>
                    <td>{{ $wrongAnswer->answer }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/dt-1.10.21/fh-3.1.7/sb-1.0.0/sp-1.1.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/fh-3.1.7/sb-1.0.0/sp-1.1.1/datatables.min.js"></script>
@endsection
