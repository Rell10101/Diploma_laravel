@auth

@extends('layout') 

@section('title')
    Отчёт
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

    


        <h2>Отчёт</h2>
        <br>
        @if($prTitle)
            <p>Самая частая проблема: {{ $prTitle }} ({{ $pr }} раз)</p>
        @endif

        @if($eq)
            <p>Оборудование с наибольшим количеством проблем: {{ $eq->title }} ({{ $eqCount }} раз)</p>
        @endif

        @if($otherCount)
            <p>Количество нестандартных проблем (Другое): {{ $otherCount }} раз</p>
        @endif
        
        


@endsection
@endauth


@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest