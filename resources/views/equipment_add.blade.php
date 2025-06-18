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


    <form method="post" action="/equipment_add/send">
        @csrf

        <label for="title">Название</label>
        <input type="text" name="title" class="form-control" required>
        <label for="location">Место нахождения</label>
            <select id="location" name="location" class="select2 form-control">
                @foreach($locations as $item)
                    <option value="{{ $item->id }}">{{ $item->title . " " . $item->type}}</option>
                @endforeach
            </select>
        <br> 
        <br> 
        <label for="equipment_type">Тип оборудования</label>
            <select id="equipment_type" name="equipment_type" class="select2 form-control">
            <option value="Все">Все</option>
            @foreach($equipment_type as $item)
                <option value="{{ $item->id }}">{{ $item->type }}</option>
            @endforeach
            </select>
        <br> 
        <br> 

        <label for="description">Описание</label>
        <textarea name="description" id="description" class="form-control" rows="3" cols="10"></textarea><br>
        <label for="remark">Замечание</label>
        <textarea name="remark" id="remark" class="form-control" rows="3" cols="10"></textarea><br>

        <button type="submit" class="btn btn-success">Отправить</button>
    </form>



@endsection
@endauth


@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest
