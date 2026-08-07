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



<div x-data="{ tab: 'active', openDealer: null, openArchiveDealer: null }">


    {{-- Вкладки --}}

    <div class="flex gap-3 mb-5">

        <button
            @click="tab='active'"
            class="px-5 py-2 rounded-lg transition cursor-pointer"
            :class="tab === 'active'
                ? 'bg-gray-900 text-white'
                : 'bg-gray-200 text-gray-800'">

            Активные

        </button>


        <button
            @click="tab='archive'"
            class="px-5 py-2 rounded-lg transition cursor-pointer"
            :class="tab === 'archive'
                ? 'bg-gray-900 text-white'
                : 'bg-gray-200 text-gray-800'">

            Архив

        </button>


    </div>





{{-- ================= АКТИВНЫЕ ================= --}}


    <div x-show="tab === 'active'"
        class="bg-white rounded-lg shadow overflow-hidden">


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
                        Активные заказы
                    </th>


                    <th class="px-6 py-3 text-left">
                        Последнее изменение
                    </th>


                </tr>

            </thead>


            <tbody>

                {{-- ================= КЛИЕНТЫ БЕЗ ДИЛЕРА ================= --}}

                @if($clients->isNotEmpty())

                    <tr class="bg-gray-200 border-b">

                        <td colspan="4"
                            class="px-6 py-3 font-bold text-gray-800">

                            Мои клиенты

                        </td>

                    </tr>


                    @foreach($clients as $client)

                        <tr
                        onclick="window.location='{{ route('clients.show',
                        ['type'=>'client','id'=>$client->id]) }}'"
                        class="border-b hover:bg-gray-100 cursor-pointer ">


                            <td class="px-6 py-4 font-medium pl-10">

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

                @endif



                {{-- ================= КЛИЕНТЫ ДИЛЕРОВ ================= --}}

                @if($dealers->isNotEmpty())

                    @foreach($dealers as $dealer)


                        <tr
                        class="bg-gray-100 border-b cursor-pointer hover:bg-gray-200 transition"

                        @click="openDealer === {{ $dealer->id }}
                            ? openDealer = null
                            : openDealer = {{ $dealer->id }}">


                            <td colspan="4"
                                class="px-6 py-3 font-bold">

                                <span
                                class="inline-flex items-center justify-center w-6 h-6 mr-2 rounded-full bg-gray-300 transition-transform"
                                :class="openDealer === {{ $dealer->id }} ? 'rotate-90' : ''">

                                    <svg class="w-4 h-4"
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


                            </td>


                        </tr>

                        @foreach($dealer->clients as $client)

                            <tr
                            x-show="openDealer === {{ $dealer->id }}"
                            x-transition
                            onclick="window.location='{{ route('clients.show',
                            ['type'=>'client','id'=>$client->id]) }}'"
                            class="border-b hover:bg-gray-100 cursor-pointer">


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

                @endif

            </tbody>

        </table>

    </div>


    {{-- ================= АРХИВ ================= --}}

    <div x-show="tab === 'archive'"
        class="bg-white rounded-lg shadow overflow-hidden">

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
                        Всего заказов
                    </th>


                    <th class="px-6 py-3 text-left">
                        Последнее изменение
                    </th>

                </tr>

            </thead>


            <tbody>


                @if($archiveDealers->isNotEmpty())


                {{-- Клиенты дилеров в архиве --}}

                    @foreach($archiveDealers as $dealer)


                        <tr
                        class="bg-gray-200 border-b cursor-pointer hover:bg-gray-300 transition"

                        @click="openArchiveDealer === {{ $dealer->id }}
                            ? openArchiveDealer = null
                            : openArchiveDealer = {{ $dealer->id }}">


                            <td colspan="4"
                                class="px-6 py-3 font-bold text-gray-800">

                                <span
                                class="inline-flex items-center justify-center w-6 h-6 mr-2 rounded-full bg-gray-300 transition-transform"

                                :class="openArchiveDealer === {{ $dealer->id }} ? 'rotate-90' : ''">

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

                            </td>


                        </tr>


                        @foreach($dealer->clients as $client)

                            <tr

                            x-show="openArchiveDealer === {{ $dealer->id }}"

                            x-transition

                            onclick="window.location='{{ route('clients.show',
                            ['type'=>'client','id'=>$client->id]) }}'"

                            class="border-b hover:bg-gray-100 cursor-pointer">


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


                @endif


                {{-- Клиенты без дилера --}}


                @if($archiveClients->isNotEmpty())


                    <tr class="bg-gray-200 border-b">

                        <td colspan="4"
                            class="px-6 py-3 font-bold text-gray-800">

                            Мои клиенты

                        </td>

                    </tr>

                    @foreach($archiveClients as $client)


                        <tr
                        onclick="window.location='{{ route('clients.show',
                        ['type'=>'client','id'=>$client->id]) }}'"
                        class="border-b hover:bg-gray-100 cursor-pointer">


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

                @endif


                @if($archiveClients->isEmpty() && $archiveDealers->isEmpty())


                    <tr>

                        <td colspan="4"
                            class="px-6 py-6 text-center text-gray-500">

                            Архив пуст

                        </td>

                    </tr>


                @endif



            </tbody>


        </table>


    </div>



</div>


@endsection