@extends('layouts.app')

@section('title', 'Новый клиент')

@section('content')

<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Новый перекуп
    </h1>
</div>

<div class="flex justify-center items-center min-h-[80vh]">

    <div class="w-full max-w-2xl">

        <div class="bg-white rounded-lg shadow p-6">

            @if ($errors->any())

                <div class="mb-6 rounded-lg bg-red-100 border border-red-300 p-4 text-red-700">

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('clients.store.dealer') }}" method="POST">

                @csrf

                <div class="mb-5">

                    <label for="full_name"
                           class="block text-sm font-medium text-gray-700 mb-2">
                        Имя
                    </label>

                    <input
                        id="full_name"
                        name="full_name"
                        type="text"
                        value="{{ old('full_name') }}"
                        placeholder="Введите имя"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none"
                        required
                    >

                </div>

                <div class="mb-6">


                    <label for="notes"
                           class="block text-sm font-medium text-gray-700 mb-2">
                        Заметки
                    </label>
                    
                    <textarea id="notes"
                        name="notes"
                        type="text"
                        placeholder="..."
                        rows=3
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none"
                        >{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-center gap-4">

                    <button
                        type="submit"
                        class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
                        Сохранить
                    </button>

                    <a href="{{ route('clients.index') }}"
                       class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                        Отмена
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


@endsection