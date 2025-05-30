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
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $r)
            <tr>
                <td>{{ $r->id }}</td>
                <td>{{ $r->title }}</td>
                <td>{{ $r->description }}</td>
                <td>{{ $r->client }}</td>
                <td>
                    @if($r->deadline)
                        {{ $r->deadline }}
                    @else @if(Auth::user()->role_id == 2)
                    <!-- Форма для изменения исполнителя -->
                        <form action="{{ route('requests_updateDeadline', $r->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <!-- <select name="deadline">
                                <option value="">Выберите срок выполнения</option>
                                @foreach($executors as $executor)
                                    <option value="{{ $executor->id }}" {{ $r->executor_id == $executor->id ? 'selected' : '' }}>
                                        {{ $executor->name }}
                                    </option>
                                @endforeach
                            </select> -->
                            <input type="datetime-local" id="deadline" name="deadline" class="form-control">
                            <br>
                            <br>
                            <button type="submit">Установить срок</button>
                        </form>
                        @endif
                    @endif
                </td>

                <td>@if($r->priority)
                        {{ $r->priority }}
                    @else 
                        @if(Auth::user()->role_id == 2)
                        <form action="{{ route('requests_updatePriority', $r->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <label>Укажите приоритет задачи</label>
                            <br>
                            <select id="priority" name="priority" class="form-control">
                                <option>Малый</option>
                                <option>Средний</option>
                                <option>Высокий</option>
                            </select>
                            <br>
                            <button type="submit">Установить приоритет</button>
                        </form>
                        @endif
                    @endif
                </td>

                <td>{{ $r->executor ? $r->executor->name : '-' }}</td>
                <td>{{ $r->status }}</td>
                <td>{{ $r->manager }}</td>
                <td>{{ $r->equipment->title }}</td>
                @if(Auth::user()->role_id == 4)
                    <td>
                        @if($r->executor_id == NULL) <!-- Исполнитель еще не назначен -->
                            <form action="{{ route('requests.accept', $r->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Принять</button>
                            </form>
                        @elseif($r->executor_id == Auth::user()->id) <!-- Текущий пользователь является исполнителем -->
                            @if($r->status == 'В работе') <!-- Если работа в процессе -->
                                <form action="{{ route('requests.complete', $r->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit">Выполнено</button>
                                </form>
                                <br>
                                <br>
                                <form action="{{ route('requests.decline', $r->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit">Не могу выполнить</button>
                                </form>
                            @elseif($r->status == 'Выполнено')
                                <form action="{{ route('requests.markAsNotCompleted', $r->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit">Не выполнено</button>
                                </form>
                            @endif

                            @if($r->status == 'Не удаётся выполнить') <!-- Если работа в процессе -->
                                <form action="{{ route('requests.accept', $r->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit">Продолжить выполнение</button>
                                </form>
                                <br>
                                <br>
                            @endif
                            
                        @endif
                    </td>
                @endif
                @if(Auth::user()->role_id == 2)
                    <td>
                        <!-- Форма для изменения исполнителя -->
                        <form action="{{ route('requests.updateExecutor', $r->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <select name="executor_id">
                                <option value="">Выберите исполнителя</option>
                                @foreach($executors as $executor)
                                    <option value="{{ $executor->id }}" {{ $r->executor_id == $executor->id ? 'selected' : '' }}>
                                        {{ $executor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- <input type="datetime-local" id="deadline" name="deadline" class="form-control">
                             -->
                            <br>
                            <br>
                            <button type="submit">Изменить исполнителя</button>
                        </form>
                    </td>
                @endif
                @if($r->client == Auth::user()->name) 
                <td>
                    <form action="{{ route('requests.destroy', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Вы уверены, что хотите удалить эту запись?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Отозвать заявку</button>
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