@auth

@extends('layout') 

@section('title')
    Чат-бот
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

    <script>
        async function sendMessage() {
            const userInput = document.getElementById('userInput').value;
            const responseContainer = document.getElementById('responseContainer');

            const response = await fetch('/openai/response', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ prompt: userInput }),
            });

            const data = await response.json();
            responseContainer.innerText = data.response;
        }
    </script>

    <h1>Чат с нейросетью</h1>
    <input type="text" id="userInput" placeholder="Введите ваше сообщение" />
    <button onclick="sendMessage()">Отправить</button>
    <div id="responseContainer" style="margin-top: 20px; border: 1px solid #ccc; padding: 10px;"></div>

@endsection
@endauth


@guest
    <p>Пожалуйста, войдите в систему, чтобы получить доступ к этому контенту.</p>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Авторизация</a>
    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Регистрация</a>
@endguest