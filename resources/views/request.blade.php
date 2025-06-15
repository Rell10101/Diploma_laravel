@auth

@extends('layout') 

@section('title')
    Отправка заявки
@endsection

@section('main_content')
    <h1>Форма отправки заявки</h1>

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

<script>
$(document).ready(function() {
    $('#equipment_type').change(function() {
        var selectedType = $(this).val();
        
        // Сброс второго селекта, но оставляем "Другое"
        $('#problem').empty().append('<option value="Другое">Другое</option>');
        $('#equipment_id').empty();

        // Фильтрация проблем по выбранному типу оборудования
        @foreach($problem as $item)
            if (selectedType == "Все" || "{{ $item->equipment_type_id }}" == selectedType) {
                $('#problem').append('<option value="{{ $item->problem }}">{{ $item->problem }}</option>');
            }
        @endforeach

        // Фильтрация оборудования по выбранному типу оборудования
        @foreach($equipment as $item)
            if (selectedType == "Все" || "{{ $item->equipment_type_id }}" == selectedType) {
                $('#equipment_id').append('<option value="{{ $item->id }}">{{ $item->title }}</option>');
            }
        @endforeach
    });

    $('#location').change(function() {
        var selectedLocation = $(this).val();
        
        $('#equipment_id').empty();

        @foreach($equipment as $item)
            if (selectedLocation == "Все" || "{{ $item->location_id }}" == selectedLocation) {
                $('#equipment_id').append('<option value="{{ $item->id }}">{{ $item->title }}</option>');
            }
        @endforeach

    });
});
</script>

    <form method="post" action="/request/send" enctype="multipart/form-data">
        @csrf
        <br>
        <!-- <input type="text" name="title" id="title" placeholder="Введите название заявки" class="form-control"><br>
         -->

         <label for="location">Выбор места нахождения оборудования</label>
            <select id="location" name="location" class="select2 form-control">
                <option value="Все">Все</option>
                @foreach($location as $item)
                    <option value="{{ $item->id }}">{{ $item->title . " " . $item->type}}</option>
                @endforeach
            </select>
        <br>
        <br>

        <label for="equipment_type">Вы можете выбрать тип оборудования</label>
            <select id="equipment_type" name="equipment_type" class="select2 form-control">
            <option value="Все">Все</option>
            @foreach($equipment_type as $item)
                <option value="{{ $item->id }}">{{ $item->type }}</option>
            @endforeach
            </select>
        <br>
        <br>

        <label for="equipment_id">Выберите оборудование:</label>
        <select class="select2 form-control" id="equipment_id" name="equipment_id">
            @foreach($equipment as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
            @endforeach
        </select>
        <br>
        <br>

        <label for="problem">Укажите проблему: <span class="required">*</span></label>
        <select id="problem" name="problem" class="select2 form-control">
            <option value="Другое">{{ "Другое" }}</option>
            @foreach($problem as $item)
                <option value="{{ $item->problem }}">{{ $item->problem }}</option>
            @endforeach
        </select>
        <br>
        <br>
        <br>
        <textarea name="description" id="description" placeholder="Введите подробное описание (необязательное поле)" class="form-control" rows="10" cols="30"></textarea><br>
         <!-- Скрытое поле для логина пользователя 
        <input type="hidden" name="client" id="client" value="{{ Auth::user()->name }}">-->
        @if(Auth::user()->role_id == 2)
        <label>Укажите срок выполнения</label>

        <input type="datetime-local" id="deadline" name="deadline" class="form-control">
        <script>
        const now = new Date();
        now.setDate(now.getDate() + 7);
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); 
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('deadline').value = `${year}-${month}-${day}T${hours}:${minutes}`;
        </script><br>

        <label>Укажите приоритет задачи</label>
        <select id="priority" name="priority" class="form-control">
            <option>Малый</option>
            <option>Средний</option>
            <option>Высокий</option>
        </select>
        <br>
            <label for="executor">Выбор исполнителя:</label>
            <select id="executor" name="executor" class="form-control">
            @foreach($executors as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
            </select>
        @endif
        <br>
        <label for="photos">Загрузите фотографии:</label>
        <input type="file" name="photos[]" id="photos" multiple>
        <br>
        <br>
        <button type="submit" class="btn btn-success">Отправить</button>
    </form>

    <style>
        .required {
            color: red; 
        }
    </style>

@endsection
@endauth


@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest
