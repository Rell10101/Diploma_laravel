@auth

@extends('layout') 

@section('title')
    Просмотр заявок
@endsection

@section('main_content')

    <style>
    .comments-container {
        margin-top: 20px; /* Отступ сверху для контейнера комментариев */
        padding: 15px; /* Внутренние отступы */
        background-color: #f9f9f9; /* Цвет фона контейнера */
        border-radius: 8px; /* Закругленные углы */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Тень для контейнера */
    }

    .comment {
        margin-bottom: 15px; /* Отступ снизу для каждого комментария */
        padding: 10px; /* Внутренние отступы для комментария */
        background-color: #ffffff; /* Цвет фона комментария */
        border: 1px solid #e0e0e0; /* Цвет границы */
        border-radius: 5px; /* Закругленные углы для комментария */
    }

    .comment strong {
        display: block; /* Отображение имени пользователя как блочный элемент */
        color: #333; /* Цвет текста имени пользователя */
        font-weight: bold; /* Жирный шрифт для имени пользователя */
    }

    .comment p {
        margin: 5px 0; /* Вертикальные отступы для текста комментария */
        color: #555; /* Цвет текста комментария */
    }

    .comment small {
        display: block; /* Отображение даты и времени как блочный элемент */
        margin-top: 5px; /* Отступ сверху для даты и времени */
        color: #888; /* Цвет текста для даты и времени */
        font-size: 0.9em; /* Уменьшенный размер шрифта для даты и времени */
    }

     .comment-form {
        margin-top: 20px; /* Отступ сверху для формы */
        padding: 15px; /* Внутренние отступы */
        background-color: #f9f9f9; /* Цвет фона формы */
        border-radius: 8px; /* Закругленные углы */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Тень для формы */
    }

    .comment-form label {
        display: block; /* Отображение меток как блочных элементов */
        margin-bottom: 5px; /* Отступ снизу для меток */
        font-weight: bold; /* Жирный шрифт для меток */
    }

    .comment-form input[type="text"],
    .comment-form textarea {
        width: 100%; /* Ширина полей ввода на всю ширину контейнера */
        padding: 10px; /* Внутренние отступы */
        margin-bottom: 15px; /* Отступ снизу для полей ввода */
        border: 1px solid #ccc; /* Цвет границы */
        border-radius: 5px; /* Закругленные углы для полей ввода */
        font-size: 1em; /* Размер шрифта */
    }

    .comment-form textarea {
        resize: vertical; /* Позволяет изменять размер только по вертикали */
        min-height: 100px; /* Минимальная высота текстовой области */
    }

    .comment-form button {
        background-color:rgb(11, 125, 38); /* Цвет фона кнопки */
        color: #fff; /* Цвет текста кнопки */
        padding: 10px 15px; /* Внутренние отступы */
        border: none; /* Убираем границу */
        border-radius: 5px; /* Закругленные углы для кнопки */
        cursor: pointer; /* Указатель при наведении */
        transition: background-color 0.3s; /* Плавный переход цвета фона */
    }

    .comment-form button:hover {
        background-color: #0056b3; /* Цвет фона кнопки при наведении */
    }
    </style>


    <div class="container">
        <h1>{{ $request->title }}</h1>
        <p><strong>ID:</strong> {{ $request->id }}</p>
        <p><strong>Описание:</strong> {{ $request->description }}</p>
        <p><strong>Клиент:</strong> {{ $request->client }}</p>
        <p><strong>Срок выполнения:</strong> {{ $request->deadline ?? 'Не установлен' }}</p>
        <p><strong>Приоритет:</strong> {{ $request->priority ?? 'Не установлен' }}</p>
        <p><strong>Исполнитель:</strong> {{ $request->executor ? $request->executor->name : '-' }}</p>
        <p><strong>Статус выполнения:</strong> {{ $request->status }}</p>
        <p><strong>Менеджер:</strong> {{ $request->manager }}</p>
        <p><strong>Аппаратура:</strong> {{ $request->equipment->title }}</p>

        <a href="{{ route('requests.request_show') }}">Назад к списку заявок</a>

        


    </div>


    <div class="comment-form">
        <h2>Комментарии</h2>
        <form action="{{ route('comments.store', $request->id) }}" method="POST">
            @csrf
            <div>
                <label for="content">Комментарий:</label>
                <textarea name="content" id="content" required></textarea>
            </div>
            <button type="submit">Добавить комментарий</button>
        </form>
    </div>


    <div class="comments-container">
    <h3>Список комментариев</h3>
    @foreach($comments as $comment)
    <div class="comment">
        <div>
            <strong>{{ $comment->user->name }}</strong>
            <p>{{ $comment->content }}</p>
            <small>Написан {{ $comment->created_at->format('d.m.Y H:i') }}</small>
        </div>
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