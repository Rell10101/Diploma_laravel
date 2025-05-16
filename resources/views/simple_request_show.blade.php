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
            <th>Клиент</th>
            <th>Срок выполнения</th>
            <th>Приоритет</th>
            <th>Исполнитель</th>
            <th>Статус выполнения</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $r)
            <tr>
                <td>{{ $r->id }}</td>
                <td>{{ $r->title }}</td>
                <td>{{ $r->client_id }}</td>
                <td>{{ $r->deadline }}</td>
                <td>{{ $r->priority }}</td>
                <td>{{ $r->executor_id ? $r->executor->name : '-' }}</td>
                <td>{{ $r->status }}</td>
                @if(Auth::user()->role_id == 2)
                    <td>
                        <form action="{{ route('simple_requests.updateExecutor', $r->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <select name="executor_id">
                                <option value="">Выберите исполнителя</option>
                                @foreach($executors as $executor)
                                    <option value="{{ $executor->id }}" {{ $r->executor_id == $executor->id ? 'selected' : '' }}>
                                        {{ $executor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit">Изменить исполнителя</button>
                        </form>
                    </td>
                @endif
                @if(Auth::user()->role_id == 4)
                    <td>
                        @if($r->executor_id == NULL) <!-- Исполнитель еще не назначен -->
                            <form action="{{ route('simple_requests_accept', $r->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Принять</button>
                            </form>
                        @endif
                    </td>
                @endif
                @if($r->client_id == Auth::user()->id) 
                <td>
                    @if($r->status != 'выполнено') 
                    <form action="{{ route('simple_requests_complete', $r->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Выполнено</button>
                    </form>
                    
                    <form action="{{ route('simple_requests_destroy', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Вы уверены, что хотите удалить эту запись?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Отозвать заявку</button>
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