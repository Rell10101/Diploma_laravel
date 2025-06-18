@auth

@extends('layout') 

@section('title')
    Просмотр оборудования
@endsection

@section('main_content')
<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 16px; /* Отступы между карточками */
    }

    .card {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 16px;
        width: 1300px; /* Ширина карточки */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .card-header {
        border-bottom: 1px solid #eee;
        margin-bottom: 10px;
    }

    .card-body {
        margin-bottom: 10px;
    }

    .card-footer {
        display: flex;
        justify-content: space-between; /* Распределение кнопок */
    }

        .button_eq_add {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #5cb85c; 
            border: none;
            border-radius: 5px; 
            text-decoration: none; 
            text-align: center;
            margin: 20px 0;
        }

        .button_eq_add:hover {
            background-color: #0056b3; /* Цвет фона при наведении */
        }
</style>

    <h1>Просмотр оборудования</h1>

    @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
        <a href="/equipment_add_show" class="button_eq_add">Добавить новое оборудование</a>
    @endif

    <div class="card-container" id="equipment-list">
        @foreach ($equipment as $eq)
            <div class="card">
                <div class="card-header">
                    <h2>{{ $eq->title }}</h2>
                </div>
                <div class="card-body">
                    <p><strong>Описание:</strong> {{ $eq->description }}</p>
                    <p><strong>Замечание:</strong> {{ $eq->remark }}</p>
                    <p><strong>Место нахождения:</strong> {{ $eq->location->title }}</p>
                    <p><strong>Тип:</strong> {{ $eq->equipment_type->type  }}</p>
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