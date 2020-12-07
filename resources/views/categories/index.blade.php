@extends('layouts.master')

@section('content')
    <div class="col-md-4 offset-4 mt-5">
        <table class="table table-striped table-sm data-table" id="resource-table">
            <thead class="thead-dark">
            <tr>
                <th class="fit">#</th>
                <th class="w-40">Име</th>
                <th class="fit text-center nosort">Редактирай</th>
                <th class="fit text-center nosort">Изтрий</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr id="resource-{{ $category->id }}">
                    <td>{{ ++$loop->index }}.</td>
                    <td>
                        <span>{{ $category->name }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-primary">
                            <i class="far fa-edit"></i>
                            Редактирай
                        </a>
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger"
                                data-target="#delete-modal"
                                data-route="{{ route('categories.destroy', $category) }}">
                            <i class="far fa-trash-alt"></i> Изтрий
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
