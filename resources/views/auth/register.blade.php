<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: stretch; 
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }
        .input-group {
            margin-bottom: 1rem;
        }
        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }
        .input-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        .input-group input:focus {
            border-color: #6a11cb;
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 0.5rem;
            background:rgb(11, 125, 38);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2575fc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-group">
                <label>Имя</label>
                <input type="text" name="name" required>
            </div>
            <div class="input-group">
                <label>Эл. почта</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
            <div class="input-group">
                <label>Подтверждение пароля</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <div>
                <button type="submit" class="btn">Зарегистрироваться</button>
            </div>
            <br>
            <br>
            <label>Уже есть аккаунт?</label>
            <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Вход</a>
        </form>
    </div>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>

