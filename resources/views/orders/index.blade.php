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

            @forelse($clients as $client)

                {{-- Вкладка клиента --}}
                <tr class="bg-gray-200">

                    <td colspan="6" class="px-6 py-3 font-bold text-gray-800 break-words">
                        {{ $client->full_name }}
                    </td>

                </tr>

                {{-- Заказы клиента --}}
                @foreach($client->cars as $order)

                    <tr
                        onclick="window.location='{{ route('orders.show', $order) }}'"
                        class="border-b hover:bg-gray-100 transition cursor-pointer">

                        <td class="px-6 py-4 font-medium">

                            {{ $order->brand ?? '—' }}

                            {{ $order->model ?? '' }}


                            @if($order->year)

                                ({{ $order->year }})

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            {{ $order->country->label() }}

                        </td>

                        <td class="px-6 py-4">
                            {{ $order->status->label() }}
                        </td>

                        <td class="px-6 py-4">

                            @if($order->buy_price)

                                {{ number_format($order->buy_price, 2, ',', ' ') }} ₽

                            @else
                                —
                            @endif

                        </td>

                        <td class="px-6 py-4">

                            {{ $order->updated_at->format('d.m.Y H:i') }}

                        </td>

                    </tr>

                @endforeach

            @empty

            <tr>

                <td colspan="6"
                    class="px-6 py-6 text-center text-gray-500">

                    Заказов пока нет

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection