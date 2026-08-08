@extends('layouts.app')

@section('title', 'Профиль')

@section('content')

<div class="max-w-3xl mx-auto">


    {{-- Заголовок --}}

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Профиль
        </h1>

        <p class="text-gray-500 mt-1">
            Управление профилем и настройками сервера
        </p>

    </div>


    {{-- Уведомление --}}

    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-300 bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Ошибки --}}

    @if($errors->any())

        <div class="mb-6 rounded-lg border border-red-300 bg-red-100 p-4 text-red-700">

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Информация о профиле --}}

    <div class="bg-white rounded-lg shadow mb-6">

        <div class="border-b px-6 py-4">

            <h2 class="text-xl font-semibold">
                Информация о профиле
            </h2>

        </div>

        <div class="p-6">

            <div>

                <label class="block text-sm text-gray-500 mb-1">
                    Логин
                </label>

                <p class="font-medium text-gray-800">
                    {{ $user->login }}
                </p>

            </div>

        </div>

    </div>


    {{-- Оплата сервера --}}

    <div class="bg-white rounded-lg shadow mb-6">

        <div class="border-b px-6 py-4">

            <h2 class="text-xl font-semibold">
                Оплата сервера
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Укажите дату, до которой оплачен сервер.
            </p>

        </div>


        <div class="p-6">

            @if($user->server_paid_until)

                <div class="mb-6 rounded-lg border p-4
                    {{ $user->server_paid_until->isPast()
                        ? 'border-red-300 bg-red-50'
                        : 'border-green-300 bg-green-50' }}">

                    <p class="text-sm text-gray-500 mb-1">
                        Текущий срок оплаты
                    </p>

                    <p class="text-2xl font-semibold
                        {{ $user->server_paid_until->isPast()
                            ? 'text-red-700'
                            : 'text-green-700' }}">

                        {{ $user->server_paid_until->format('d.m.Y H:i') }}

                    </p>


                    @if ($user->server_paid_until && $user->server_paid_until->isFuture())
                        <p class="mt-2 text-sm text-green-600">
                            Осталось
                            {{ (int) now()->diffInDays($user->server_paid_until) }}
                            дней.
                        </p>
                    @elseif ($user->server_paid_until)
                        <p class="mt-2 text-sm text-red-600">
                            Сервер оплачен до
                            {{ $user->server_paid_until->format('d.m.Y H:i') }},
                            срок оплаты истёк.
                        </p>
                    @else
                        <p class="mt-2 text-sm text-gray-500">
                            Сервер не оплачен.
                        </p>
                    @endif

                </div>

            @else

                <div class="mb-6 rounded-lg border border-yellow-300 bg-yellow-50 p-4">

                    <p class="text-yellow-800">
                        Срок оплаты сервера ещё не установлен.
                    </p>

                </div>

            @endif


            <form
                action="{{ route('profile.server-payment.update') }}"
                method="POST">

                @csrf
                @method('PUT')


                <div class="mb-4">

                    <label
                        for="server_paid_until"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Оплачен до

                    </label>

                    <input
                        type="datetime-local"
                        id="server_paid_until"
                        name="server_paid_until"
                        value="{{ old(
                            'server_paid_until',
                            $user->server_paid_until?->format('Y-m-d\TH:i')
                        ) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2
                            focus:border-gray-500 focus:ring-1 focus:ring-gray-500">

                    @error('server_paid_until')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="px-6 py-3 bg-gray-900 text-white rounded-lg
                        hover:bg-gray-700 transition">

                    Сохранить

                </button>

            </form>

        </div>

    </div>


    {{-- Выход --}}

    <div class="flex justify-center mb-10">

        <form
            action="{{ route('logout') }}"
            method="POST">

            @csrf

            <button
                type="submit"
                class="px-6 py-3 bg-red-600 text-white rounded-lg
                    hover:bg-red-700 transition">

                Выйти из аккаунта

            </button>

        </form>

    </div>

</div>

@endsection
