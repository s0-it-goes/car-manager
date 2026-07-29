<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Car Manager')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-gray-100 min-h-screen">


    <div class="flex min-h-screen">

        <aside class="w-36 bg-gray-900 text-white flex flex-col">

            <nav class="flex-1 px-4 py-6 space-y-3">

                <a href="{{ route('home') }}"
                class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition text-center
                {{ request()->routeIs('home') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    Главная
                </a>

                <a href="{{ route('clients.index') }}"
                class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition text-center
                {{ request()->routeIs('clients.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    Клиенты
                </a>

                <a href="{{ route('orders.index') }}"
                class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition text-center
                {{ request()->routeIs('orders.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    Заказы
                </a>

                <a href="{{ route('archive.index') }}"
                class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition text-center
                {{ request()->routeIs('archive.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    Архив
                </a>

            </nav>

            <div class="p-4 border-t border-gray-700">

                <a href="{{ route('profile.index') }}"
                class="block px-4 py-3 rounded-lg bg-gray-800 hover:bg-gray-700 transition text-center
                {{ request()->routeIs('profile.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    Профиль
                </a>

            </div>


        </aside>

        <main class="flex-1 p-8">

            @yield('content')

        </main>

        </div>

    </body>
</html>