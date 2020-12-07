@extends('layouts.master')

@section('content')
    <div class="col-md-6 offset-3 mt-5">
        <form action="{{ route('questions.update', $question) }}" method="post" class="ajax-form">
            <div class="form-group row">
                <div class="col-md-12 input-group">
                    <select name="category_id" class="form-control searchable">
                        @foreach($categories as $category)
                            <optgroup label="{{ $category->name }}"></optgroup>
                            @foreach($category->children as $child)
                                <option
                                    value="{{ $child->id }}" {{ $child->id == session('category_id') ? 'selected' : '' }}>{{ $child->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 input-group">
                <textarea class="form-control" name="content" rows="2" placeholder="Въпрос"
                          autofocus>{{ $question->content }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 input-group">
                <textarea class="form-control" name="answer" rows="15"
                          placeholder="Отговор">{{ $question->answer }}</textarea>
                </div>
            </div>
            <div class="row">
                <button class="btn btn-block btn-secondary">Запиши</button>
            </div>
            @method('put')
        </form>
    </div>
@endsection

