@auth

@extends('layout') 

@section('title')
    Просмотр заявок
@endsection

@section('main_content')
    <h1>Просмотр заявок</h1>

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

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Заявка</th>
                <th>Описание</th>
                <th>Клиент</th>
                <th>Срок выполнения</th>
                <th>Приоритет</th>
                <th>Исполнитель</th>
                <th>Статус выполнения</th>
                <th>Менеджер</th>
                <th>Аппаратура</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->title }}</td>
                    <td>{{ $r->description }}</td>
                    <td>{{ $r->client }}</td>
                    <td>{{ $r->deadline }}</td>
                    <td>{{ $r->priority }}</td>
                    <td>{{ $r->executor }}</td>
                    <td>{{ $r->status }}</td>
                    <td>{{ $r->manager }}</td>
                    <td>{{ $r->equipment_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    

@endsection
@endauth

@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest