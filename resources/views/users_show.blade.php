@auth


@extends('layout') 

@section('title')
    Просмотр пользователей
@endsection

@section('main_content')
    <h1>Просмотр пользователей</h1>

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
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Изменить роль</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role_id }}</td>
                    <td>
                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                            @csrf
                            <select name="role_id" required>
                                <option value="2">Менеджер</option>
                                <option value="3">Клиент</option>
                                <option value="4">Исполнитель</option>
                                <!-- Добавьте другие роли, если необходимо -->
                            </select>
                            <button type="submit">Изменить</button>
                        </form>
                    </td>
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