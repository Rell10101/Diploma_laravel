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
            @if(Auth::user()->role_id == 4)
                <th>Действия</th>
            @endif
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
                @if(Auth::user()->role_id == 4)
                    <td>
                        @if($r->executor == '-') <!-- Исполнитель еще не назначен -->
                            <form action="{{ route('requests.accept', $r->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Принять</button>
                            </form>
                        @elseif($r->executor == Auth::user()->name) <!-- Текущий пользователь является исполнителем -->
                            @if($r->status == 'в работе') <!-- Если работа в процессе -->
                                <form action="{{ route('requests.complete', $r->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit">Выполнено</button>
                                </form>
                                <form action="{{ route('requests.decline', $r->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit">Отказаться</button>
                                </form>
                            @elseif($r->status == 'выполнено') <!-- Если работа выполнена -->
                                <form action="{{ route('requests.markAsNotCompleted', $r->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit">Не выполнено</button>
                                </form>
                            @endif
                        @endif
                    </td>
                @endif
                @if($r->client == Auth::user()->name) 
                <td>
                <form action="{{ route('requests.destroy', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Вы уверены, что хотите удалить эту запись?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
                </td>
                @endif
                @if(Auth::user()->role_id == 2)
                    <td>
                        @if($r->status == 'выполнено')
                            <form action="{{ route('requests.check', $r->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Проверить</button>
                            </form>
                        @elseif($r->status == 'проверка')
                            <form action="{{ route('requests.markChecked', $r->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Проверено</button>
                            </form>
                        @endif
                    </td>
                @endif
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