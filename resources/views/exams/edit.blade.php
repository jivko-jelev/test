@extends('layouts.master')

@section('content')
    <div class="col-md-4 offset-4">
        <form action="{{ route('exams.update', $exam) }}" method="post" class="ajax-form">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="categories[]" id="categories[0]"
                            {{ $categories->diff($exam->categories)->isEmpty() ? 'checked' : '' }}>
                            <label class="form-check-label" for="categories[0]"><span></span>
                                Всички ({{ $categories->sum->questions_count }})
                            </label>
                        </div>
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input type="checkbox" value="{{ $category->id }}" name="categories[]"
                                       id="categories[{{ $category->id }}]"
                                    @if($categories->diff($exam->categories)->isNotEmpty())
                                    {{ $exam->categories->contains('id', $category->id) ? 'checked' : '' }}
                                @endif
                                >
                                <label class="form-check-label" for="categories[{{ $category->id }}]"><span></span>
                                    {{ $category->name }} ({{ $category->questions_count }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-success">Запази</button>
            </div>
            @method('put')
        </form>
    </div>
@endsection

