@extends('layouts.app')

@section('title', 'Клиенты')


@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Клиенты
    </h1>


    <a href="{{ route('clients.create') }}"
       class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
        Добавить клиента
    </a>

</div>



<div class="bg-white rounded-lg shadow overflow-hidden">


    <table class="w-full">

        <thead class="bg-gray-900 text-white">

            <tr>
                <th class="px-6 py-3 text-left">
                    ФИО
                </th>

                <th class="px-6 py-3 text-left">
                    Телефон
                </th>

                <th class="px-6 py-3 text-left">
                    Автомобили
                </th>

                <th class="px-6 py-3 text-left">
                    Последнее изменение
                </th>

            </tr>

        </thead>



        <tbody>


        @forelse($clients as $client)


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


        @empty


            <tr>

                <td colspan="5"
                    class="px-6 py-6 text-center text-gray-500">
                    Клиентов пока нет
                </td>

            </tr>


        @endforelse


        </tbody>


    </table>


</div>


@endsection