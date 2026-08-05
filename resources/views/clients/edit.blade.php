@extends('layouts.app')

@section('title', 'Редактирование')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Редактирование
    </h1>

    <form action="{{ route('clients.update', ['type'=>$type,'id'=>$contact->id]) }}"
          method="POST"
          class="bg-white rounded-lg shadow p-6">

        @csrf
        @method('PUT')

        <div class="mb-5">

            <label class="block text-sm font-medium mb-2">
                ФИО
            </label>

            <input
                type="text"
                name="full_name"
                value="{{ old('full_name', $contact->full_name) }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2">

        </div>

        @if($type === 'client')

            <div class="mb-5">

                <label class="block text-sm font-medium mb-2">
                    Телефон
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $contact->phone) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2">

            </div>

            <div class="mb-5">

                <label class="block text-sm font-medium mb-2">
                    Перекуп
                </label>

                <select
                    name="dealer_id"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    <option value="">
                        Нет
                    </option>

                    @foreach($dealers as $dealer)

                        <option
                            value="{{ $dealer->id }}"
                            @selected(old('dealer_id', $contact->dealer_id) == $dealer->id)>

                            {{ $dealer->full_name }}

                        </option>

                    @endforeach

                </select>

            </div>

        @endif

        <div class="mb-6">

            <label class="block text-sm font-medium mb-2">
                Заметки
            </label>

            <textarea
                name="notes"
                rows="5"
                class="w-full rounded-lg border border-gray-300 px-4 py-2">{{ old('notes', $contact->notes) }}</textarea>

        </div>

        <div class="flex justify-center gap-4">

            <button
                type="submit"
                class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-700 cursor-pointer">

                Сохранить

            </button>

            <a
                href="{{ route('clients.show', ['type'=>$type,'id'=>$contact->id]) }}"
                class="px-6 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">

                Отмена

            </a>

        </div>
        

    </form>

    @if($type === 'client')

        <div class="bg-white rounded-lg shadow p-6 mt-6 text-center">

            <h3 class="text-lg font-semibold text-red-600 mb-4">
                Опасная зона
            </h3>


            <form action="{{ route('clients.destroy', $contact->id) }}"
                method="POST"
                onsubmit="return confirm('Удалить клиента и все его заказы? Это действие нельзя отменить.')">

                @csrf
                @method('DELETE')


                <button
                    type="submit"
                    class="inline-flex mb-3 mt-3 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition cursor-pointer">

                    Удалить клиента и все его заказы

                </button>


            </form>


        </div>


    @elseif($type === 'dealer')


        <div class="bg-white rounded-lg shadow p-6 mt-6 text-center">

            <h3 class="text-lg font-semibold text-red-600 mb-4">
                Опасная зона
            </h3>


            <form action="{{ route('dealers.destroy', $contact->id) }}"
                method="POST"
                onsubmit="return confirm('Удалить перекупа? Клиенты останутся, но будут отвязаны от него.')">

                @csrf
                @method('DELETE')


                <button
                    type="submit"
                    class="inline-flex mb-3 mt-3 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition cursor-pointer">

                    Удалить перекупа

                </button>


            </form>


        </div>


    @endif

</div>

@endsection