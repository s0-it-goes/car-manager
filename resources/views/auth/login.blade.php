<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Вход
            </h1>
        </div>


        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-100 border border-red-300 px-4 py-3 text-red-700">
                {{ $errors->first() }}
            </div>
        @endif


        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf


            <div>
                <label for="login" class="block text-sm font-medium text-gray-700 mb-2">
                    Логин
                </label>

                <input
                    type="text"
                    name="login"
                    id="login"
                    value="{{ old('login') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-transparent"
                    placeholder="Введите ваш логин"
                >
            </div>


            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Пароль
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-transparent"
                    placeholder="Введите ваш пароль"
                >
            </div>


            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg
                       font-semibold
                       hover:bg-blue-700
                       transition duration-200
                       shadow-md"
            >
                Войти
            </button>

        </form>

    </div>

</body>
</html>
<!--
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login page</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="bg-primary">
        <header>
            <h1 style="font-size: 24px; text-align: center; margin-top: 50px">Login page</h1>
        </header>
        <form method="POST" action="/login">
            @csrf
            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 50px">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" required>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 20px">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 20px; cursor: pointer">
                <button type="submit">Login</button>
            </div>
        </form>
    </body>
</html>
-->