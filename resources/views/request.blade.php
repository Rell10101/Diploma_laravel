@auth

@extends('layout') 

@section('title')
    Отправка заявки
@endsection

@section('main_content')
    <h1>Форма отправки заявки</h1>

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

    <form method="post" action="/request/send">
        @csrf
        <input type="text" name="title" id="title" placeholder="Введите название заявки" class="form-control"><br>
        <textarea name="description" id="description" placeholder="Введите подробное описание" class="form-control"></textarea><br>
         <!-- Скрытое поле для логина пользователя -->
        <input type="hidden" name="client" id="client" value="{{ Auth::user()->name }}">
        <label>Укажите срок выполнения</label>
        <input type="datetime-local" id="deadline" name="deadline" class="form-control"><br>
        <!-- <input type="text" id="priority" name="priority" placeholder="Введите приоритетность" class="form-control"><br> -->
        <label>Укажите приоритетность вашей задачи</label>
        <select id="priority" name="priority" class="form-control">
            <option>Малая</option>
            <option>Средняя</option>
            <option>Высокая</option>
        </select><br>
        <input type="text" id="equipment_id" name="equipment_id" placeholder="Выберите аппаратуру" class="form-control"><br>
        <button type="submit" class="btn btn-success">Отправить</button>
    </form>

@endsection
@endauth


@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest
