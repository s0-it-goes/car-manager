<?php

namespace App\Http\Controllers;

use App\Enums\CarStatus;
use App\Enums\Country;
use App\Models\Car;
use App\Models\Client;
use App\Models\Dealer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $clients = Client::with([
            'dealer',
            'cars' => function ($query) {
                $query->orderByDesc('updated_at');
            }
        ])
        ->whereHas('cars')
        ->whereNull('dealer_id')
        ->orderByDesc('updated_at')
        ->get();


        $dealers = Dealer::with([
            'clients' => function($query){

                $query->orderBy('full_name');

            },

            'clients.cars' => function ($query) {

                $query->orderByDesc('updated_at');

            }

        ])
        ->whereHas('clients.cars')
        ->orderBy('full_name')
        ->get();


        return view('orders.index', compact('clients', 'dealers'));
    }

    public function create()
    {
        $clients = Client::with('dealer')
        ->orderBy('full_name')
        ->get();
        $dealers = Dealer::orderBy('full_name')->get();

        return view('orders.create', array_merge(compact('clients', 'dealers'),
            [
                'countries' => Country::cases(),
                'statuses' => CarStatus::cases(),
        ]));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([

            'client_id' => 'nullable|exists:clients,id',

            // Новый клиент
            'client_name' => 'nullable|required_without:client_id|string|max:255',
            'client_phone' => 'nullable|string|max:20',
            'dealer_id' => 'nullable|exists:dealers,id',

            // Заказ
            'country' => 'required|in:Japan,Korea,China',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'year' => 'nullable|integer',
            'chassis_number' => 'nullable|string|max:100|unique:cars,chassis_number',
            'buy_price' => 'nullable|numeric',
            'status' => 'required',
            'notes' => 'nullable|string',

        ]);


        if ($request->filled('client_id')) {

            $clientId = $request->client_id;

        } else {

            if (!$request->filled('client_name')) {

                return back()
                    ->withErrors([
                        'client_name' => 'Введите имя нового клиента.'
                    ])
                    ->withInput();

            }


            $client = Client::create([

                'full_name' => $request->client_name,
                'phone' => $request->client_phone,
                'dealer_id' => $request->dealer_id,

            ]);


            $clientId = $client->id;

        }


        $validated['client_id'] = $clientId;

        unset(
            $validated['client_name'],
            $validated['client_phone'],
            $validated['dealer_id']
        );

        Car::create([
            'client_id' => $clientId,
            'country' => $validated['country'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'chassis_number' => $validated['chassis_number'],
            'buy_price' => $validated['buy_price'],
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);


        return redirect()
            ->route('orders.index')
            ->with('success', 'Заказ успешно создан.');
    }

    public function show(Car $car)
    {
        $car->load('client.dealer');
        
        return view('orders.show', [
            'car' => $car,
            'countries' => Country::cases(),
            'statuses' => CarStatus::cases(),
        ]);
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([

            'country' => ['required'],
            'brand' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'year' => ['nullable', 'integer'],
            'chassis_number' => [
                'nullable',
                'string',
                'max:100',
                'unique:cars,chassis_number,' . $car->id,
            ],

            'buy_price' => ['nullable', 'numeric'],

            'status' => ['required'],

            'notes' => ['nullable', 'string'],

            'purchased_at' => ['nullable', 'date'],

            'arrived_at' => ['nullable', 'date'],

            'completed_at' => ['nullable', 'date'],

        ]);

        $car->update($validated);

        return redirect()
            ->route('orders.show', $car)
            ->with('success', 'Заказ успешно обновлен.');
    }

}