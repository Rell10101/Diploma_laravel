@auth

@extends('layout') 

@section('title')
    Отправка заявки
@endsection

@section('main_content')

    <!-- если есть любая ошибка -->
    @if($errors->any())
        <!-- подключение стилей -->
        <div class="alert alert-danger">
            <ul>
                <!-- перебираем все имеющиеся ошибки -->
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach 
            </ul>
        </div>
    @endif

    <style>
        .btn {
            width: 100%;
            padding: 0.5rem;
            background:rgb(11, 125, 38);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2575fc;
        }
    </style>


        <h2>Выберите тип заявки</h2>
        <br>
        <a href="{{ url('/request_show') }}">
            <button class="btn">Починка оборудования</button>
        </a>
        <br>
        <br>
        <a href="{{ url('/simple_request_show') }}">
            <button class="btn">Запросы помощи</button>
        </a>



@endsection
@endauth


@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest