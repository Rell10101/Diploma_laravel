@auth

@extends('layout') 

@section('title')
    Просмотр заявок
@endsection

@section('main_content')
    <h1>Просмотр заявок</h1>

    <!-- <script>
$(document).ready(function() {
    $('#search-form').on('submit', function(e) {
        e.preventDefault(); // Отменяем стандартное поведение формы

        $.ajax({
            url: $(this).attr('action'),
            method: 'GET',
            data: $(this).serialize(),
            success: function(data) {
                $('.card-container').html(data); // Обновляем карточки
            },
            error: function(xhr) {
                alert('Произошла ошибка при загрузке данных. Пожалуйста, попробуйте еще раз.');
                console.error(xhr.responseText); // Логирование ошибки в консоль
            }
        });
    });
});
</script> -->

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
</style>

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


   <div>
    <input type="text" id="client" placeholder="Поиск по клиенту">
    <select id="status">
        <option value="">Все статусы</option>
        <option value="completed">Завершено</option>
        <option value="in_progress">В процессе</option>
        <option value="В ожидании исполнителя">В ожидании исполнителя</option>
    </select>
    <select id="sort_by">
        <option value="title">По названию</option>
        <option value="deadline">По сроку выполнения</option>
    </select>
    <select id="sort_order">
        <option value="asc">По возрастанию</option>
        <option value="desc">По убыванию</option>
    </select>
    <button id="filter-button">Фильтровать</button>
</div>

<div class="card-container" id="request-list">
    @foreach ($requests as $r)
        <div class="card">
            <div class="card-header">
                <h2><a href="{{ route('request_full', ['id' => $r->id]) }}">{{ $r->title }}</a></h2>
            </div>
            <div class="card-body">
                <p><strong>Клиент:</strong> {{ $r->client }}</p>
                <p><strong>Срок выполнения:</strong> {{ $r->deadline }}</p>
                <p><strong>Приоритет:</strong> {{ $r->priority }}</p>
                <p><strong>Исполнитель:</strong> {{ $r->executor ? $r->executor->name : '-' }}</p>
                <p><strong>Статус выполнения:</strong> {{ $r->status }}</p>
                <p><strong>Аппаратура:</strong> {{ $r->equipment->title }}</p>
            </div>
        </div>
    @endforeach
</div>


<script>
    $(document).ready(function() {
        $('#filter-button').click(function() {
            var client = $('#client').val();
            var status = $('#status').val();
            var sort_by = $('#sort_by').val();
            var sort_order = $('#sort_order').val();

            $.ajax({
    url: '{{ route('request_filter') }}',
    method: 'GET',
    data: {
        client: client,
        status: status,
        sort_by: sort_by,
        sort_order: sort_order
    },
    success: function(data, textStatus, xhr) {
        $('#request-list').empty(); // Очистите текущий список
        if (xhr.status === 204) {
            $('#request-list').append('<p>Нет заявок, соответствующих критериям фильтрации.</p>');
            return;
        }
        $.each(data, function(index, r) {
            $('#request-list').append(`
                <div class="card">
                    <div class="card-header">
                        <h2><a href="/request_full/${r.id}">${r.title}</a></h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Клиент:</strong> ${r.client}</p>
                        <p><strong>Срок выполнения:</strong> ${r.deadline ? r.deadline : 'Не указано'}</p>
                        <p><strong>Приоритет:</strong> ${r.priority ? r.priority : 'Не указан'}</p>
                        <p><strong>Исполнитель:</strong> ${r.executor ? r.executor.name : '-'}</p>
                        <p><strong>Статус выполнения:</strong> ${r.status}</p>
                        <p><strong>Аппаратура:</strong> ${r.equipment.title}</p>
                    </div>
                </div>
            `);
        });
    },
    error: function(xhr) {
        console.error('Ошибка при загрузке данных:', xhr);
        $('#request-list').empty().append('<p>Произошла ошибка при загрузке данных.</p>');
    }
});

        });
    });
</script>

    

    


    



    <!-- <table>
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
                        <form action="{{ route('requests_updateDeadline', $r->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <select name="deadline">
                                <option value="">Выберите срок выполнения</option>
                                @foreach($executors as $executor)
                                    <option value="{{ $executor->id }}" {{ $r->executor_id == $executor->id ? 'selected' : '' }}>
                                        {{ $executor->name }}
                                    </option>
                                @endforeach
                            </select> 
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
                        @if($r->executor_id == NULL) 
                            <form action="{{ route('requests.accept', $r->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Принять</button>
                            </form>
                        @elseif($r->executor_id == Auth::user()->id) 
                            @if($r->status == 'В работе') 
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

                            @if($r->status == 'Не удаётся выполнить') 
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
                            <input type="datetime-local" id="deadline" name="deadline" class="form-control">
                    
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
</table> -->








    

@endsection
@endauth

@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest