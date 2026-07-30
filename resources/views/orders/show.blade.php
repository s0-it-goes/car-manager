@extends('layouts.app')

@section('title', 'Заказ #' . $car->id)

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Заказ #{{ $car->id }}
        </h1>

        <p class="text-gray-500 mt-1">
            Создан {{ $car->created_at->format('d.m.Y H:i') }}
        </p>

    </div>

    <a href="{{ route('orders.index') }}"
       class="px-5 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">
        Назад
    </a>

</div>

@if(session('success'))

    <div class="mb-6 rounded-lg border border-green-300 bg-green-100 p-4 text-green-700">

        {{ session('success') }}

    </div>

@endif

@if($errors->any())

    <div class="mb-6 rounded-lg border border-red-300 bg-red-100 p-4 text-red-700">

        <ul class="list-disc list-inside">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<div class="flex justify-center">
    <div class="w-full max-w-3xl">
        <form
            action="{{ route('orders.update', $car) }}"
            method="POST">

            @csrf
            @method('PUT')
                <div class="bg-white rounded-lg shadow mb-6">

                <div class="border-b px-6 py-4">

                    <h2 class="text-xl font-semibold">
                        Клиент
                    </h2>

                </div>

                <div class="p-6 grid grid-cols-2 gap-6">

                    <div>

                        <label class="block text-sm text-gray-500 mb-1">
                            ФИО
                        </label>

                        <div class="font-medium">

                            {{ $car->client->full_name }}

                        </div>

                    </div>

                    <div>

                        <label class="block text-sm text-gray-500 mb-1">
                            Телефон
                        </label>

                        <div>

                            {{ $car->client->phone ?? '—' }}

                        </div>

                    </div>

                </div>

            </div>
                <div class="bg-white rounded-lg shadow mb-6">

                <div class="border-b px-6 py-4">

                    <h2 class="text-xl font-semibold">

                        Автомобиль

                    </h2>

                </div>

                <div class="p-6 grid grid-cols-2 gap-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">

                            Страна

                        </label>

                        <select
                            name="country"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                            @foreach($countries as $country)

                                <option
                                    value="{{ $country->value }}"
                                    @selected(old('country', $car->country->value) == $country->value)>

                                    {{ $country->label() }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">

                            Марка

                        </label>

                        <input
                            type="text"
                            name="brand"
                            value="{{ old('brand', $car->brand) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">

                            Модель

                        </label>

                        <input
                            type="text"
                            name="model"
                            value="{{ old('model', $car->model) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">

                            Год

                        </label>

                        <input
                            type="number"
                            name="year"
                            value="{{ old('year', $car->year) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    </div>

                    <div class="col-span-2">

                        <label class="block text-sm font-medium mb-2">

                            Номер кузова

                        </label>

                        <input
                            type="text"
                            name="chassis_number"
                            value="{{ old('chassis_number', $car->chassis_number) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    </div>

                </div>

            </div>
                {{-- Финансы --}}

            <div class="bg-white rounded-lg shadow mb-6">

                <div class="border-b px-6 py-4">

                    <h2 class="text-xl font-semibold">
                        Финансы
                    </h2>

                </div>


                <div class="p-6">


                    <label class="block text-sm font-medium mb-2">

                        Цена покупки

                    </label>


                    <input
                        type="number"
                        name="buy_price"
                        value="{{ old('buy_price', $car->buy_price) }}"
                        placeholder="Введите стоимость"
                        class="w-full rounded-lg border 
                        border-gray-300 px-4 py-2 [&::-webkit-outer-spin-button]:appearance-none 
                        [&::-webkit-inner-spin-button]:appearance-none [-moz-appearance:textfield]">


                </div>


            </div>



            {{-- Логистика --}}


            <div class="bg-white rounded-lg shadow mb-6">


                <div class="border-b px-6 py-4">


                    <h2 class="text-xl font-semibold">

                        Логистика

                    </h2>


                </div>



                <div class="p-6 grid grid-cols-2 gap-6">


                    <div>


                        <label class="block text-sm font-medium mb-2">

                            Статус

                        </label>



                        <select
                            name="status"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">


                            @foreach($statuses as $status)


                                <option
                                    value="{{ $status->value }}"
                                    @selected(old('status', $car->status->value) == $status->value)>


                                    {{ $status->label() }}


                                </option>


                            @endforeach


                        </select>


                    </div>


                    <div>


                        <label class="block text-sm font-medium mb-2">

                            Дата покупки

                        </label>


                        <input
                            type="datetime-local"
                            name="purchased_at"
                            value="{{ old('purchased_at', $car->purchased_at?->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">


                    </div>


                    <div>


                        <label class="block text-sm font-medium mb-2">

                            Дата прибытия

                        </label>



                        <input
                            type="datetime-local"
                            name="arrived_at"
                            value="{{ old('arrived_at', $car->arrived_at?->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">


                    </div>





                    <div>


                        <label class="block text-sm font-medium mb-2">

                            Дата завершения

                        </label>



                        <input
                            type="datetime-local"
                            name="completed_at"
                            value="{{ old('completed_at', $car->completed_at?->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">


                    </div>



                </div>


            </div>







            {{-- Заметки --}}



            <div class="bg-white rounded-lg shadow mb-6">


                <div class="border-b px-6 py-4">


                    <h2 class="text-xl font-semibold">

                        Заметки

                    </h2>


                </div>




                <div class="p-6">


                    <textarea
                        name="notes"
                        rows="5"
                        placeholder="Дополнительная информация..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-2">{{ old('notes', $car->notes) }}</textarea>



                </div>


            </div>








            {{-- Кнопки --}}



            <div class="flex justify-center gap-4 mb-10">



                <button
                    type="submit"
                    class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">


                    Сохранить


                </button>




                <a href="{{ route('orders.index') }}"
                class="px-6 py-3 bg-gray-300 rounded-lg hover:bg-gray-400 transition">


                    Отмена


                </a>



            </div>



        </form>
    </div>
</div>

@endsection