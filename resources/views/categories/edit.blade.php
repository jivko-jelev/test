@extends('layouts.master')

@section('style')
@endsection

@section('content')
    <div class="col-md-6 offset-3">
        <form action="{{ route('categories.update', $category->id) }}" method="post" class="ajax-form">
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Име</label>
                    <div class="col-md-8 input-group">
                        <input type="text" class="form-control form-control-sm" placeholder="Име" name="name" id="name"
                               value="{{ old('name', $category->name) }}">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="parent_id" class="col-sm-4 col-form-label">Главна категория</label>
                    <div class="col-md-8 input-group">
                        <select name="parent_id" id="parent_id" class="form-control searchable">
                            <option value="">Без</option>
                            @foreach($parentCategories as $id => $name)
                                <option
                                    value="{{ $id }}" {{ $id == $category->parent_id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="float-right">
                <button class="btn btn-success">Запази</button>
            </div>
            @method('put')
        </form>
    </div>
@endsection
