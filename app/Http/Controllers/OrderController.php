<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $clients = Client::with([
            'cars' => function ($query) {
                $query->orderByDesc('updated_at');
            }
        ])
        ->whereHas('cars')
        ->orderByDesc('updated_at')
        ->get();


        return view('orders.index', compact('clients'));
    }

    public function create()
    {
        $clients = Client::orderByDesc('full_name')->get();

        return view('orders.create', array_merge(compact('clients'),
            [
                'countries' => \App\Enums\Country::cases(),
                'statuses' => \App\Enums\CarStatus::cases(),
        ]));
    }



    public function store(Request $request)
    {
        // Валидация полей заказа
        $validated = $request->validate([

            'client_id' => 'nullable|exists:clients,id',

            'country' => 'required|in:Japan,Korea,China',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'year' => 'nullable|integer',
            'chassis_number' => 'nullable|string|max:100|unique:cars,chassis_number',
            'buy_price' => 'nullable|numeric',
            'status' => 'required|in:searching,purchased,waiting_departure,in_transit,arrived,on_truck,completed,cancelled',
            'notes' => 'nullable|string',

        ]);


        // Если клиент выбран из списка
        if ($request->filled('client_id')) {

            $validated['client_id'] = $request->client_id;

        } else {

            // Валидация нового клиента
            $clientData = $request->validate([

                'client_name' => 'required|string|max:255',
                'client_phone' => 'nullable|string|max:20',

            ]);

            // Создание клиента
            $client = Client::create([

                'full_name' => $clientData['client_name'],
                'phone' => $clientData['client_phone'],

            ]);

            $validated['client_id'] = $client->id;
        }


        // Создание заказа
        Car::create($validated);


        return redirect()
            ->route('orders.index')
            ->with('success', 'Заказ успешно создан.');
    }

}