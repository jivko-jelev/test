@extends('layouts.master')

@section('content')
    <div class="col-md-4 offset-4">
        <form action="{{ route('exams.post.answering.wrong.answers') }}" method="post" class="ajax-form">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="exam[]" id="exam[0]">
                            <label class="form-check-label" for="exam[0]"><span></span>
                                Всички ({{ $uniqueWrongAnswers->count() }})
                            </label>
                        </div>
                        @foreach($exams as $exam)
                            <div class="form-check">
                                <input type="checkbox" value="{{ $exam->id }}" name="exam[]"
                                       id="exam[{{ $exam->id }}]">
                                <label class="form-check-label" for="exam[{{ $exam->id }}]"><span></span>
                                    {{ $exam->categories->pluck('name')->join(', ', ' и ') }}
                                    ({{ $exam->wrong_answers_count }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-success">Започни</button>
            </div>
        </form>
    </div>
@endsection

