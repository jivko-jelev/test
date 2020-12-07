@extends('layouts.master')

@section('content')
    <div class="col-md-10 offset-1">
        <p>Отговорено на: {{  $answeredQuestions->count() . ' / ' . $questionsNum }}</p>
        <table class="table table-striped table-sm data-table">
            <thead>
            <tr>
                <th class="defaultSort" data-order-by="asc">#</th>
                <th class="w-35">Въпрос</th>
                <th class="w-35">Моят отговор</th>
                <th>Отговор от документацията</th>
            </tr>
            </thead>
            <tbody>
            @foreach($answeredQuestions as $question)
                <tr class="{{ $question->pivot->answer == $question->answer ? 'bg-lightgreen' : 'bg-lightred' }}">
                    <td class="text-right">{{ $loop->iteration }}.</td>
                    <td>{{ $question->content }}</td>
                    <td>{!! nl2br(str_replace('  ', '&nbsp', $question->pivot->answer)) !!}</td>
                    <td>{!! nl2br(str_replace('  ', '&nbsp', $question->answer)) !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if($answeredQuestions->count() < $questionsNum)
            <a href="{{ route('exams.questions.show', $exam) }}" class="btn btn-primary">Продължи</a>
        @endif
    </div>
@endsection

@section('script')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/dt-1.10.21/fh-3.1.7/sb-1.0.0/sp-1.1.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/fh-3.1.7/sb-1.0.0/sp-1.1.1/datatables.min.js"></script>
@endsection
