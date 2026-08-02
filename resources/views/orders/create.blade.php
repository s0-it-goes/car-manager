@extends('layouts.app')

@section('title', 'Новый заказ')

@section('content')

<div x-data="{ newClient: false }" x-cloak>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Новый заказ
    </h1>

    <div class="flex justify-center items-center min-h-[80vh]">

        <div class="w-full max-w-2xl">

            <div class="bg-white rounded-lg shadow p-6">

                @if ($errors->any())

                    <div class="mb-6 rounded-lg bg-red-100 border border-red-300 p-4 text-red-700">

                        <ul class="list-disc list-inside">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('orders.store') }}" method="POST">

                    @csrf

                    <!-- Клиент -->

                    <div class="mb-5">

                        <div class="flex justify-between items-center mb-2">

                            <label for="client_id"
                                   class="block text-sm font-medium text-gray-700">
                                Клиент
                            </label>

                            <button type="button"
                                    @click="
                                        newClient = !newClient;
                                        if(newClient) {
                                            document.getElementById('client_id').value = '';
                                        }
                                    "
                                    class="text-sm text-blue-600 hover:underline cursor-pointer">
                                + Новый клиент
                            </button>

                        </div>

                        <select
                            id="client_id"
                            name="client_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none">

                            <option value="">
                                Выберите клиента
                            </option>

                            @foreach($clients as $client)

                                <option value="{{ $client->id }}"
                                    {{ old('client_id') == $client->id ? 'selected' : '' }}>

                                    {{ $client->full_name }}

                                    @if($client->dealer)
                                        (перекуп: {{ $client->dealer->full_name }})
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Новый клиент -->

                    <div x-show="newClient"
                         x-transition
                         class="mb-6 p-4 bg-gray-100 rounded-lg">

                        <h2 class="font-medium text-gray-800 mb-4">
                            Данные нового клиента
                        </h2>

                        <div class="mb-4">

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                ФИО
                            </label>

                            <input
                                type="text"
                                name="client_name"
                                value="{{ old('client_name') }}"
                                placeholder="Введите ФИО"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:outline-none">

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Телефон
                            </label>

                            <input
                                type="text"
                                name="client_phone"
                                value="{{ old('client_phone') }}"
                                placeholder="+7 (999) 999-99-99"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:outline-none">

                        </div>

                    </div>

                    <!-- Страна -->

                    <div class="mb-5">

                        <label for="country"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Страна
                        </label>

                        <select
                            id="country"
                            name="country"
                            required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none">


                            <option value="">
                                Выберите страну
                            </option>

                            @foreach($countries as $country)
                                
                                <option value="{{ $country->value }}"
                                    {{ old('country') == $country->value ? 'selected' : '' }}>

                                    {{ $country->label() }}

                                </option>
                            @endforeach

                        </select>


                    </div>

                    <!-- Марка -->

                    <div class="mb-5">

                        <label for="brand"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Марка
                        </label>

                        <input
                            id="brand"
                            name="brand"
                            type="text"
                            value="{{ old('brand') }}"
                            placeholder="Toyota"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none">


                    </div>

                    <!-- Модель -->

                    <div class="mb-5">


                        <label for="model"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Модель
                        </label>


                        <input
                            id="model"
                            name="model"
                            type="text"
                            value="{{ old('model') }}"
                            placeholder="Camry"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none">

                    </div>

                    <!-- Год -->

                    <div class="mb-5">


                        <label for="year"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Год выпуска
                        </label>


                        <input
                            id="year"
                            name="year"
                            type="number"
                            value="{{ old('year') }}"
                            placeholder="2020"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none">


                    </div>

                    <!-- Номер кузова -->

                    <div class="mb-5">


                        <label for="chassis_number"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Номер кузова
                        </label>


                        <input
                            id="chassis_number"
                            name="chassis_number"
                            type="text"
                            value="{{ old('chassis_number') }}"
                            placeholder="ABC123456"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none">

                    </div>

                    <!-- Цена -->

                    <div class="mb-5">


                        <label for="buy_price"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Цена покупки
                        </label>

                        <input
                            id="buy_price"
                            name="buy_price"
                            type="number"
                            step="0.01"
                            value="{{ old('buy_price') }}"
                            placeholder="1000000"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none">

                    </div>

                    <!-- Статус -->

                    <div class="mb-5">

                        <label for="status"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Статус
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                            @foreach($statuses as $status)

                                <option value="{{ $status->value }}"
                                    {{ old('status') == $status->value ? 'selected' : '' }}>

                                    {{ $status->label() }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <!-- Заметки -->

                    <div class="mb-6">

                        <label for="notes"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Заметки
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="4"
                            placeholder="Дополнительная информация..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none">{{ old('notes') }}</textarea>

                    </div>

                    <!-- Кнопки -->

                    <div class="flex justify-center gap-4">

                        <button
                            type="submit"
                            class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition cursor-pointer">
                            Сохранить
                        </button>

                        <a href="{{ route('orders.index') }}"
                           class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition cursor-pointer">
                            Отмена
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection