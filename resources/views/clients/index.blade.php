@extends('layouts.app')

@section('title', 'Клиенты')


@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Клиенты
    </h1>


    <a href="{{ route('clients.create.type') }}"
        class="px-4 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
            Добавить
    </a>

</div>


<div class="bg-white rounded-lg shadow overflow-hidden"
     x-data="{ openDealer: null }">


    <table class="w-full">

        <thead class="bg-gray-900 text-white">

            <tr>
                <th class="px-6 py-3 text-left">
                    Имя
                </th>

                <th class="px-6 py-3 text-left">
                    Телефон
                </th>

                <th class="px-6 py-3 text-left">
                    Количество активных заказов
                </th>

                <th class="px-6 py-3 text-left">
                    Последнее изменение
                </th>

            </tr>

        </thead>



        <tbody>


{{-- Дилеры --}}

@foreach($dealers as $dealer)

<tr class="bg-gray-200 border-b cursor-pointer hover:bg-gray-300 transition"
    @click="openDealer === {{ $dealer->id }} ? openDealer = null : openDealer = {{ $dealer->id }}">

    <td colspan="4"
        class="px-6 py-3 font-bold text-gray-800">

        <span
            class="inline-flex items-center justify-center w-6 h-6 mr-2 rounded-full bg-gray-300 relative top-[2px] transition-transform duration-200"
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

        {{ $dealer->full_name }}

        <span class="text-sm text-gray-500 ml-2">
            ({{ $dealer->clients->count() }} клиентов)
        </span>

    </td>

</tr>


@foreach($dealer->clients as $client)

<tr x-show="openDealer === {{ $dealer->id }}"
    x-transition
    class="border-b hover:bg-gray-100 transition">


    <td class="px-6 py-4 pl-12 font-medium">

        {{ $client->full_name }}

    </td>


    <td class="px-6 py-4">

        {{ $client->phone ?? '—' }}

    </td>


    <td class="px-6 py-4">

        {{ $client->cars->count() }}

    </td>


    <td class="px-6 py-4">

        {{ $client->updated_at->format('d.m.Y H:i') }}

    </td>


</tr>

@endforeach


@endforeach


{{-- Обычные клиенты --}}

@foreach($clients as $client)


<tr class="border-b hover:bg-gray-100 transition">


    <td class="px-6 py-4 font-medium">

        {{ $client->full_name }}

    </td>


    <td class="px-6 py-4">

        {{ $client->phone ?? '—' }}

    </td>


    <td class="px-6 py-4">

        {{ $client->cars->count() }}

    </td>


    <td class="px-6 py-4">

        {{ $client->updated_at->format('d.m.Y H:i') }}

    </td>


</tr>


@endforeach


@if($clients->isEmpty() && $dealers->isEmpty())

<tr>

<td colspan="4"
    class="px-6 py-6 text-center text-gray-500">

    Клиентов пока нет

</td>

</tr>

@endif


</tbody>


    </table>


</div>


@endsection