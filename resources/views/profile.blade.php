@auth

@extends('layout') 

@section('title')
    Профиль
@endsection

@section('main_content')
    <h1>Ваш профиль</h1>

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

    <p><strong>Имя:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    
    <p><strong>Роль:</strong> 
        @if($user->role_id == 3)
            Клиент
        @elseif($user->role_id == 1)
            Администратор
        @elseif($user->role_id == 2)
            Менеджер
        @elseif($user->role_id == 4)
            Исполнитель
        @else
            Неизвестная роль
        @endif
    </p>

    <form action="{{ route('logout') }}" method="POST" style="position: fixed; bottom: 20px; left: 20px;">
    @csrf
    <button type="submit" class="btn btn-danger">Выйти</button>
    </form>
    

@endsection
@endauth

@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest