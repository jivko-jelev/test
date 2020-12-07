<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('site-icon.png') }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('styles/style.css') }}">
    @yield('style')
</head>
<body>
<div class="mt-2 d-flex justify-content-center">
    <div class="row main-menu">
        <div class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Категории
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('categories.create') }}">Създай</a>
                <a class="dropdown-item" href="{{ route('categories.index') }}">Редактирай / Изтрий</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Въпроси
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('questions.create') }}">Създай</a>
                <a class="dropdown-item" href="{{ route('questions.index') }}">Редактирай / Изтрий</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Преговори
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('exams.create') }}">Създай</a>
                <a class="dropdown-item" href="{{ route('exams.index') }}">Виж / Редактирай / Изтрий</a>
                <a class="dropdown-item" href="{{ route('exams.create.answering.wrong.answers') }}">Отговаряне на сгрешени отговори</a>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 offset-4 mt-5" id="messages">
    @if(!is_null(session('message')))
        <div class="alert alert-success text-center">
            {{ session('message') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger text-center">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
</div>

@yield('content')

<div class="modal fade" tabindex="-1" role="dialog" id="delete-modal"></div>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ url('js/custom.js') }}"></script>

@yield('script')
</body>
</html>
