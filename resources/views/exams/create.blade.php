@extends('layouts.master')

@section('content')
    <div class="col-md-4 offset-4">
        <form action="{{ route('exams.store') }}" method="post" class="ajax-form">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="categories[]" id="categories[0]">
                            <label class="form-check-label" for="categories[0]"><span></span>
                                Всички ({{ $categories->sum->questions_count }})
                            </label>
                        </div>
                        @foreach($categories->sortBy('parent.name')->groupBy('parent_id') as $category)
                            {{ $category->first()->parent->name }}
                            @foreach($category as $childCategory)
                                <div class="form-check">
                                    <input type="checkbox" value="{{ $childCategory->id }}" name="categories[]"
                                           id="categories[{{ $childCategory->id }}]">
                                    <label class="form-check-label" for="categories[{{ $childCategory->id }}]"><span></span>
                                        {{ $childCategory->name }} ({{ $childCategory->questions_count }})
                                    </label>
                                </div>
                            @endforeach
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

