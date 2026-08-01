@extends('layouts.app')

@section('title', 'Новый клиент')

@section('content')

<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center">

    <div class="w-full max-w-xl">

        <div class="bg-white rounded-lg shadow p-8">

            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                Новый клиент
            </h1>


            <div class="flex flex-col gap-4">


                <a href="{{ route('clients.create.client') }}"
                   class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition text-center">

                    Добавить клиента

                </a>


                <a href="{{ route('clients.create.dealer') }}"
                   class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition text-center">

                    Добавить перекупа

                </a>


            </div>


        </div>

    </div>

</div>


@endsection