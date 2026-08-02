@extends('layouts.app')

@section('title', 'Заказы')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Заказы
    </h1>

    <a href="{{ route('orders.create') }}"
       class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
        Добавить заказ
    </a>

</div>

<div class="bg-white rounded-lg shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-900 text-white">
            <tr>
                <th class="px-6 py-3 text-left">
                    Клиент
                </th>
                <th class="px-6 py-3 text-left">
                    Автомобиль
                </th>

                <th class="px-6 py-3 text-left">
                    Страна
                </th>

                <th class="px-6 py-3 text-left">
                    Статус
                </th>

                <th class="px-6 py-3 text-left">
                    Цена покупки
                </th>

                <th class="px-6 py-3 text-left">
                    Последнее изменение
                </th>

            </tr>
        </thead>

        <tbody>


            {{-- Обычные клиенты --}}

            @if($clients->count())

            <tr class="bg-gray-200 border-b">

                <td colspan="6"
                    class="px-6 py-3 font-bold text-gray-800">

                    Мои клиенты

                </td>

            </tr>


            @foreach($clients as $client)

                @foreach($client->cars as $order)

                    <tr
                        onclick="window.location='{{ route('orders.show', $order) }}'"
                        class="border-b hover:bg-gray-100 transition cursor-pointer">


                        <td class="px-6 py-4 font-medium">

                            {{ $client->full_name }}

                        </td>


                        <td class="px-6 py-4 font-medium">

                            {{ trim(($order->brand ?? '') . ' ' . ($order->model ?? '')) ?: '—' }}

                            @if($order->year)
                                ({{ $order->year }})
                            @endif

                        </td>


                        <td class="px-6 py-4">

                            {{ $order->country?->label() ?? '—' }}

                        </td>


                        <td class="px-6 py-4 whitespace-nowrap">

                            {{ $order->status?->label() ?? '—' }}

                        </td>


                        <td class="px-6 py-4 whitespace-nowrap">

                            {{ $order->buy_price 
                                ? number_format($order->buy_price, 2, ',', ' ') . ' ₽'
                                : '—' }}

                        </td>


                        <td class="px-6 py-4 whitespace-nowrap">

                            {{ $order->updated_at->format('d.m.Y H:i') }}

                        </td>


                    </tr>

                @endforeach

            @endforeach

            @endif

            {{-- Клиенты перекупов --}}

            @foreach($dealers as $dealer)


                <tr class="bg-gray-200 border-b">

                    <td colspan="6"
                        class="px-6 py-3 font-bold text-gray-800">

                        Перекуп: {{ $dealer->full_name }}

                    </td>

                </tr>



                @foreach($dealer->clients as $client)


                    @foreach($client->cars as $order)


                    <tr
                        onclick="window.location='{{ route('orders.show', $order) }}'"
                        class="border-b hover:bg-gray-100 transition cursor-pointer">


                        <td class="px-6 py-4 font-medium pl-10">

                            {{ $client->full_name }}

                        </td>


                        <td class="px-6 py-4 font-medium">

                            {{ trim(($order->brand ?? '') . ' ' . ($order->model ?? '')) ?: '—' }}

                            @if($order->year)
                                ({{ $order->year }})
                            @endif

                        </td>


                        <td class="px-6 py-4">

                            {{ $order->country?->label() ?? '—' }}

                        </td>


                        <td class="px-6 py-4 whitespace-nowrap">

                            {{ $order->status?->label() ?? '—' }}

                        </td>


                        <td class="px-6 py-4 whitespace-nowrap">

                            {{ $order->buy_price 
                                ? number_format($order->buy_price, 2, ',', ' ') . ' ₽'
                                : '—' }}

                        </td>


                        <td class="px-6 py-4 whitespace-nowrap">

                            {{ $order->updated_at->format('d.m.Y H:i') }}

                        </td>


                    </tr>

                    @endforeach

                @endforeach

            @endforeach


            @if($clients->isEmpty() && $dealers->isEmpty())

            <tr>

            <td colspan="6"
                class="px-6 py-6 text-center text-gray-500">

                Заказов пока нет

            </td>

            </tr>

            @endif


        </tbody>

    </table>

</div>

@endsection