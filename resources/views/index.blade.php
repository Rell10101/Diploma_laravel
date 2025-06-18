
@auth
@extends('layout') 

@section('title')
    Главная страница
@endsection

@section('main_content')
    <p>Главная</p>
    

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .news {
            background: #fff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .news strong {
            display: block;
            margin-bottom: 5px;
        }
        .date {
            font-size: 0.9em;
            color: #777;
        }
    </style>

    <h1>Создать объявление</h1>
    <form action="/news" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Тема объявления" required>
        <textarea name="content" placeholder="Содержимое объявления" required></textarea>
        <button type="submit">Создать</button>
    </form>

    <h2>Список объявлений</h2>
    <div>
        @foreach ($news as $item)
            <div class="news">
                <strong>{{ $item->title }}</strong>
                <p>{{ $item->content }}</p>
                <div class="date">Создано: {{ $item->created_at->format('d.m.Y H:i') }}</div>
            </div>
        @endforeach
    </div>

@endsection
@endauth


@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest
