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
    <a href="{{ route('knowledge_base.upload.form') }}">Загрузить новый файл</a>
    @endif

    <ul>
    @foreach ($files as $file)
        <li>
            <a href="{{ url('/knowledge_base/' . $file) }}">{{ pathinfo($file, PATHINFO_FILENAME) }}</a>
            <form action="{{ route('files.destroy', $file) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить этот файл?');">Удалить</button>
            </form>
        </li>
    @endforeach
    </ul>

@endsection
@endauth

@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest