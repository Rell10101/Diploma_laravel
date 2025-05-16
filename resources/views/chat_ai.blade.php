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

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        #userInput {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4cae4c;
        }

        #responseContainer {
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            min-height: 200px; /* Установите минимальную высоту */
            overflow-y: auto; /* Добавьте прокрутку, если содержимое превышает высоту */
        }
    </style>

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