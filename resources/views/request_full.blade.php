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


    /* Стили для модального окна */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            padding-top: 100px; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.9); 
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 90%; 
            max-width: 90%; 
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .prev, .next {
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border: none;
    cursor: pointer;
    user-select: none;
}

.prev {
    left: 0;
}

.next {
    right: 0;
}

.prev:hover, .next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

    </style>

    <script>
        document.addEventListener('keydown', function(event) {
    if (document.getElementById("myModal").style.display === "block") {
        if (event.key === "ArrowLeft") {
            changeImage(-1); // Предыдущая фотография
        } else if (event.key === "ArrowRight") {
            changeImage(1); // Следующая фотография
        } else if (event.key === "Escape") {
            closeModal(); // Закрыть модальное окно при нажатии Esc
        }
    }
});

let currentImageIndex = 0; // Индекс текущего изображения
let imagesArray = []; // Массив изображений

function openModal(src) {
    var modal = document.getElementById("myModal");
    var img = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    
    // Заполняем массив изображений
    imagesArray = [...document.querySelectorAll('.gallery img')].map(img => img.src);
    
    currentImageIndex = imagesArray.indexOf(src); // Устанавливаем текущий индекс
    img.src = src;
    captionText.innerHTML = "Фото"; // Вы можете изменить текст подписи, если нужно
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

function changeImage(direction) {
    currentImageIndex += direction; 
    if (currentImageIndex < 0) {
        currentImageIndex = imagesArray.length - 1; 
    } else if (currentImageIndex >= imagesArray.length) {
        currentImageIndex = 0; 
    }
    var img = document.getElementById("img01");
    img.src = imagesArray[currentImageIndex];
}

    document.addEventListener('DOMContentLoaded', function() {
        const editButton = document.getElementById('editDescriptionBtn');
        if (editButton) {
            editButton.addEventListener('click', function() {
                document.getElementById('descriptionText').style.display = 'none';
                document.getElementById('descriptionForm').style.display = 'block';
                this.style.display = 'none'; 
            });
        }
    });

    </script>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <div class="container">
        <h1>{{ $request->title }}</h1>
        <p><strong>ID:</strong> {{ $request->id }}</p>
        <!-- <p><strong>Описание:</strong> {{ $request->description }}</p> -->
    <p><strong>Описание:</strong></p>
    <form action="{{ route('requests.updateDescription', $request->id) }}" method="POST" id="descriptionForm" style="display: none;">
        @csrf
        <textarea name="description" id="description" class="form-control">{{ $request->description }}</textarea>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
    <p id="descriptionText" style="border: 1px solid rgb(100, 101, 100); border-radius: 10px; padding: 15px;">{{ $request->description }}</p>
    @if($request->status = "В ожидании исполнителя" && $request->client == Auth::user()->name)
        <button id="editDescriptionBtn" class="btn btn-secondary" style="background-color: rgb(11, 125, 38);">Редактировать</button>
    @endif
    <br>
    <br>
        <p><strong>Клиент:</strong> {{ $request->client }}</p>
        @if($request->clientUser)
            <p><strong>Email клиента:</strong> {{ $request->clientUser->email }}</p>
            <p><strong>Телефон клиента:</strong> {{ $request->clientUser->phone }}</p>
        @else
            <p><strong>Телефон:</strong> Неизвестен</p>
            <p><strong>Email:</strong> Неизвестен</p>
        @endif
        <p><strong>Срок выполнения:</strong> 
                    @if($request->deadline)
                        {{ $request->deadline }}
                    @else
                        Не определён
                        @if(Auth::user()->role_id == 2)
                            <form action="{{ route('requests_updateDeadline', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="datetime-local" id="deadline" name="deadline" class="form-control">
                                <br>
                                <button type="submit">Установить срок</button>
                            </form>
                        @endif
                    @endif
                </p>
        <p><strong>Приоритет:</strong> 
                    @if($request->priority)
                        {{ $request->priority ? : 'Не определён' }}
                    @else 
                        Не определён
                        @if(Auth::user()->role_id == 2)
                            <form action="{{ route('requests_updatePriority', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <select id="priority" name="priority" class="form-control">
                                    <option>Малый</option>
                                    <option>Средний</option>
                                    <option>Высокий</option>
                                </select>
                                <br>
                                <button type="submit">Установить приоритет</button>
                            </form>
                        @endif
                    @endif
                </p>
        <p><strong>Исполнитель:</strong> {{ $request->executor ? $request->executor->name : 'Не назначен' }}</p>
        @if(Auth::user()->role_id == 2)
                    <form action="{{ route('requests.updateExecutor', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <select name="executor_id">
                            <option value="">Выберите исполнителя</option>
                            @foreach($executors as $executor)
                                <option value="{{ $executor->id }}" {{ $request->executor_id == $executor->id ? 'selected' : '' }}>
                                    {{ $executor->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit">Изменить исполнителя</button>
                    </form>
                @endif
        <p><strong>Статус выполнения:</strong> {{ $request->status }}</p>
        <p><strong>Менеджер:</strong> {{ $request->manager }}</p>
        <p><strong>Аппаратура:</strong> {{ $request->equipment->title }}</p>
        @if(Auth::user()->role_id == 4)
            @if($request->executor_id == NULL)
                <form action="{{ route('requests.accept', $request->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Принять</button>
                </form>
            @elseif($request->executor_id == Auth::user()->id)
                @if($request->status == 'В работе')
                    <form action="{{ route('requests.complete', $request->id) }}" method="POST" style="display:inline;">
                         @csrf
                        <button type="submit">Выполнено</button>
                    </form>
                    <form action="{{ route('requests.decline', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Не могу выполнить</button>
                    </form>
                    <br>
                @elseif($r->status == 'Выполнено')
                    <form action="{{ route('requests.markAsNotCompleted', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Не выполнено</button>
                    </form>
                @endif
            @endif
        @endif
        @if($request->client == Auth::user()->name) 
            <form action="{{ route('requests.destroy', $request->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Вы уверены, что хотите удалить эту запись?');">
                @csrf
                @method('DELETE')
                <button type="submit">Отозвать заявку</button>
            </form>
        @endif
        <br>

    

    <br>
    <h2>Фотографии</h2>
    @if(!empty($request->photos))
        <div class="gallery">
            @foreach($request->photos_array as $photo)
                <div class="photo-item">
                    <img src="{{ asset('uploads/' . trim($photo)) }}" alt="Фото" class="thumbnail" style="max-width: 200px; max-height: 200px; margin: 5px; cursor: pointer;" onclick="openModal(this.src)">
                    <form action="{{ route('requests.deletePhoto', [$request->id, trim($photo)]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <p>Нет фотографий для отображения.</p>
    @endif
    @if( $request->client == Auth::user()->name )
    <h2>Добавить фотографию</h2>
    <form action="{{ route('requests.uploadPhoto', $request->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photos[]" accept="image/*" multiple required> 
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </form>
    @endif
        <!-- Модальное окно -->
<div id="myModal" class="modal" style="display:none;">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
    <button class="prev" onclick="changeImage(-1)">&#10094;</button>
    <button class="next" onclick="changeImage(1)">&#10095;</button>
</div>


        

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