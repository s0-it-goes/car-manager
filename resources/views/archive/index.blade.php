@extends('layouts.app')

@section('title', 'Архив')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Архив заказов
    </h1>

</div>


<div class="bg-white rounded-lg shadow overflow-hidden"
     x-data="{ openDealer: null }">


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


        {{-- ================= КЛИЕНТЫ ДИЛЕРОВ ================= --}}


        @foreach($dealers as $dealer)


            <tr
                class="bg-gray-200 border-b cursor-pointer hover:bg-gray-300 transition"

                @click="openDealer === {{ $dealer->id }}
                    ? openDealer = null
                    : openDealer = {{ $dealer->id }}">


                <td colspan="6"
                    class="px-6 py-3 font-bold text-gray-800">


                    <span
                        class="inline-flex items-center justify-center w-6 h-6 mr-2 rounded-full bg-gray-300 transition-transform"

                        :class="openDealer === {{ $dealer->id }} ? 'rotate-90' : ''">


                        <svg
                            class="w-4 h-4 text-gray-700"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">


                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"/>


                        </svg>


                    </span>
                    
                    Перекуп: {{ $dealer->full_name }}

                </td>


            </tr>




            @foreach($dealer->clients as $client)


                @foreach($client->cars as $order)


                <tr

                    x-show="openDealer === {{ $dealer->id }}"

                    x-transition


                    onclick="window.location='{{ route('orders.show', $order) }}'"


                    class="border-b hover:bg-gray-100 transition cursor-pointer">


                    <td class="px-6 py-4 pl-12 font-medium">

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

                            : '—'

                        }}


                    </td>


                    <td class="px-6 py-4 whitespace-nowrap">

                        {{ $order->updated_at->format('d.m.Y H:i') }}

                    </td>


                </tr>


                @endforeach


            @endforeach


        @endforeach





        {{-- ================= МОИ КЛИЕНТЫ ================= --}}


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

                            : '—'

                        }}


                    </td>



                    <td class="px-6 py-4 whitespace-nowrap">

                        {{ $order->updated_at->format('d.m.Y H:i') }}

                    </td>


                </tr>


                @endforeach


            @endforeach


        @endif





        @if($clients->isEmpty() && $dealers->isEmpty())


            <tr>

                <td colspan="6"
                    class="px-6 py-6 text-center text-gray-500">

                    Архив пуст

                </td>

            </tr>


        @endif



        </tbody>


    </table>


</div>


@endsection