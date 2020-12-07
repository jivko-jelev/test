@extends('layouts.master')

@section('content')
    <div class="col-md-10 offset-1 mt-2">
        <table class="table table-striped table-sm data-table" id="resource-table">
            <thead class="thead-dark">
            <tr>
                <th class="fit">#</th>
                <th class="w-35">Въпрос</th>
                <th class="w-35">Отговор</th>
                <th class="fit text-center">Категория</th>
                <th class="fit text-center nosort">Редактирай</th>
                <th class="fit text-center nosort">Изтрий</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $question)
                <tr id="resource-{{ $question->id }}">
                    <td>{{ ++$loop->index }}.</td>
                    <td>{{ $question->content }}</td>
                    <td>{{ $question->answer }}</td>
                    <td class="text-center">{{ $question->category->parent->name . '/' . $question->category->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-primary">
                            Редактирай
                        </a>
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger"
                                data-target="#delete-modal"
                                data-route="{{ route('questions.destroy', $question) }}">
                            Изтрий
                        </button>
                    </td>
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
