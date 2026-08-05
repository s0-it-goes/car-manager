@extends('layouts.app')

@section('title', $contact->full_name)

@section('content')


<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">

            @if($type === 'dealer')
                Перекуп
            @else
                Клиент
            @endif

        </h1>


        <p class="text-gray-500 mt-1">
            {{ $contact->full_name }}
        </p>

    </div>


    <a href="{{ route('clients.index') }}"
       class="px-5 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">

        Назад

    </a>

</div>



<div class="bg-white rounded-lg shadow p-6 mb-6">


    <h2 class="text-xl font-bold text-gray-800 mb-5">

        Информация

    </h2>



    <div class="space-y-3">


        <div>

            <span class="font-semibold">
                Имя:
            </span>

            {{ $contact->full_name }}

        </div>



        @if($type === 'client')


            <div>

                <span class="font-semibold">
                    Телефон:
                </span>

                {{ $contact->phone ?? '—' }}

            </div>



            @if($contact->dealer)

                <div>

                    <span class="font-semibold">
                        Перекуп:
                    </span>


                    <a href="{{ route('clients.show', ['type'=>'dealer', 'id'=>$contact->dealer->id]) }}"
                       class="text-blue-600 hover:underline">

                        {{ $contact->dealer->full_name }}

                    </a>


                </div>

            @else

                <div>

                    <span class="font-semibold">
                        Перекуп:
                    </span>

                    Нет

                </div>


            @endif



        @else


            <div>

                <span class="font-semibold">
                    Количество клиентов:
                </span>

                {{ $contact->clients->count() }}

            </div>


        @endif



        @if($contact->notes)

            <div>

                <span class="font-semibold">
                    Заметки:
                </span>


                <p class="mt-1 text-gray-600">

                    {{ $contact->notes }}

                </p>


            </div>

        @endif
        
        <div class="mt-5">
            <a href="{{ route('clients.edit', ['type' => $type, 'id' => $contact->id]) }}"
                class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">

                Изменить

            </a>
        </div>
    </div>


</div>


@if($type === 'dealer')


<div class="bg-white rounded-lg shadow overflow-hidden">


    <div class="px-6 py-4 bg-gray-900 text-white">

        <h2 class="text-xl font-bold">
            Клиенты
        </h2>

    </div>



    <table class="w-full">


        <thead class="bg-gray-100">

            <tr>

                <th class="px-6 py-3 text-left">
                    Имя
                </th>


                <th class="px-6 py-3 text-left">
                    Телефон
                </th>


                <th class="px-6 py-3 text-left">
                    Заказы
                </th>


            </tr>

        </thead>



        <tbody>


        @forelse($contact->clients as $client)


            <tr
            onclick="window.location='{{ route('clients.show', ['type' => 'client', 'id' => $client->id]) }}'"
            class="border-b hover:bg-gray-100 transition cursor-pointer">


                <td class="px-6 py-4 font-medium">

                    {{ $client->full_name }}

                </td>


                <td class="px-6 py-4">

                    {{ $client->phone ?? '—' }}

                </td>


                <td class="px-6 py-4">

                    {{ $client->cars->count() }}

                </td>


            </tr>


        @empty


            <tr>

                <td colspan="3"
                    class="px-6 py-6 text-center text-gray-500">

                    Клиентов нет

                </td>

            </tr>


        @endforelse


        </tbody>


    </table>


</div>



@else



<div class="bg-white rounded-lg shadow overflow-hidden">


    <div class="px-6 py-4 bg-gray-900 text-white">

        <h2 class="text-xl font-bold">
            Заказы
        </h2>

    </div>



    <table class="w-full">


        <thead class="bg-gray-100">

            <tr>

                <th class="px-6 py-3 text-left">
                    Автомобиль
                </th>


                <th class="px-6 py-3 text-left">
                    Страна
                </th>


                <th class="px-6 py-3 text-left">
                    Статус
                </th>


            </tr>

        </thead>



        <tbody>


        @forelse($contact->cars as $car)


            <tr
                onclick="window.location='{{ route('orders.show', $car) }}'"
                class="border-b hover:bg-gray-100 transition cursor-pointer">


                <td class="px-6 py-4 font-medium">

                    {{ $car->brand ?? '—' }}

                    {{ $car->model ?? '' }}


                    @if($car->year)

                        ({{ $car->year }})

                    @endif


                </td>


                <td class="px-6 py-4">

                    {{ $car->country->label() }}

                </td>


                <td class="px-6 py-4">

                    {{ $car->status->label() }}

                </td>


            </tr>


        @empty


            <tr>

                <td colspan="3"
                    class="px-6 py-6 text-center text-gray-500">

                    Заказов нет

                </td>

            </tr>


        @endforelse


        </tbody>


    </table>


</div>


@endif



@endsection