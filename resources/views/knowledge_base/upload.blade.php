@auth

@extends('layout') 

@section('title')
    База знаний
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


    <h1>База знаний</h1>

    @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 2)
    <h2>Загрузить файл</h2>
    <form action="{{ route('knowledge_base.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Загрузить</button>
    </form>
    @endif
    <a href="{{ url('/knowledge_base') }}">Назад к списку</a>


@endsection
@endauth

@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest