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

                            <a href="{{ route('clients.show', ['type' => 'client', 'id' => $car->client->id]) }}"
                               class="text-blue-600 hover:underline">

                                {{ $car->client->full_name }}

                            </a>

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

                {{-- Автомобиль --}}

                <div class="bg-white rounded-lg shadow mb-6">

                    <div class="border-b px-6 py-4">

                        <h2 class="text-xl font-semibold">
                            Автомобиль
                        </h2>

                    </div>


                    <div class="p-6 space-y-5">


                        {{-- Страна --}}

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



                        {{-- Марка --}}

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



                        {{-- Модель --}}

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



                        {{-- Год --}}

                        <div>

                            <label class="block text-sm font-medium mb-2">
                                Год
                            </label>


                            <input
                                type="text"
                                name="year"
                                value="{{ old('year', $car->year) }}"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        </div>



                        {{-- Номер кузова --}}

                        <div>

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
                        type="text"
                        name="buy_price"
                        value="{{ old('buy_price', $car->buy_price) }}"
                        placeholder="Введите стоимость"
                        inputmode="numeric"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2"
                    >
                        


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
{{-- ВАЖНО: здесь закрылась форма обновления заказа --}}





{{-- Фото --}}

<div id="photos" class="bg-white rounded-lg shadow mb-6">

    <div class="border-b px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold">
            Фотографии
        </h2>

        <span class="text-sm text-gray-500">
            {{ $car->photos->count() }} фото
        </span>
    </div>

    <div class="p-6">

        <form
            action="{{ route('orders.photos.upload', $car) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <label
                class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-500 hover:bg-gray-50 transition">

                <svg class="w-10 h-10 text-gray-400 mb-3"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V4m0 0l-3 3m3-3l3 3"/>
                </svg>

                <span class="text-gray-600">
                    Выберите фотографии
                </span>

                <span class="text-xs text-gray-400 mt-1">
                    JPG, PNG, WEBP • до 10 МБ
                </span>

                <input
                    class="hidden"
                    type="file"
                    name="photos[]"
                    multiple
                    accept="image/*">
            </label>

            <button
                class="mt-4 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">

                Загрузить фотографии

            </button>

        </form>

        @if($car->photos->isNotEmpty())

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8">

                @foreach($car->photos as $photo)

                    <div class="relative group">

                        <a
                            href="{{ asset('storage/'.$photo->path) }}"
                            target="_blank">

                            <img
                                src="{{ asset('storage/'.$photo->path) }}"
                                class="w-full h-44 object-cover rounded-lg border shadow-sm hover:scale-[1.02] transition">

                        </a>

                        <form
                            action="{{ route('photos.delete',$photo) }}"
                            method="POST"
                            class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">

                            @csrf
                            @method('DELETE')

                            <button
                                class="w-8 h-8 rounded-full bg-red-600 text-white hover:bg-red-700">

                                ×

                            </button>

                        </form>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-10 text-gray-500">

                Фотографий пока нет

            </div>

        @endif

    </div>

</div>





{{-- Документы --}}


<div id="documents" class="bg-white rounded-lg shadow mb-6">

    <div class="border-b px-6 py-4 flex justify-between items-center">

        <h2 class="text-xl font-semibold">

            Документы

        </h2>

        <span class="text-sm text-gray-500">

            {{ $car->documents->count() }} документов

        </span>

    </div>

    <div class="p-6">

        <form
            action="{{ route('orders.documents.upload',$car) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <label
                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-green-500 hover:bg-gray-50 transition">

                <svg
                    class="w-10 h-10 text-gray-400 mb-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M7 16V4h8l2 2v10m-5 4h0"/>

                </svg>

                <span>
                    Выберите документы
                </span>

                <span class="text-xs text-gray-400 mt-1">
                    до 20 МБ один файл
                </span>

                <input
                    class="hidden"
                    type="file"
                    name="documents[]"
                    multiple>

            </label>

            <button
                class="mt-4 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">

                Загрузить документы

            </button>

        </form>

        @if($car->documents->isNotEmpty())

            <div class="mt-8 space-y-3">

                @foreach($car->documents as $document)

                    <div class="flex items-center justify-between rounded-lg border p-4">

                        <div class="flex items-center gap-3">

                            <svg
                                class="w-8 h-8 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6M9 8h6m-6 8h6M7 4h10l2 2v14H5V4z"/>

                            </svg>

                            <div>

                                <a
                                    href="{{ asset('storage/'.$document->path) }}"
                                    target="_blank"
                                    class="font-medium text-blue-600 hover:underline">

                                    {{ $document->name }}

                                </a>

                            </div>

                        </div>

                        <form
                            action="{{ route('documents.delete',$document) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                class="text-red-600 hover:text-red-700">

                                Удалить

                            </button>

                        </form>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-10 text-gray-500">

                Документов пока нет

            </div>

        @endif

    </div>

</div>


{{-- Удаление заказа --}}

<div class="flex justify-center mb-10">

    <form action="{{ route('orders.destroy', $car) }}"
          method="POST"
          onsubmit="return confirm('Вы действительно хотите удалить этот заказ? Все данные автомобиля будут удалены.')">

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">

            Удалить заказ

        </button>

    </form>

</div>

@endsection