<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dealer;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        // Клиенты без дилера
        $clients = Client::whereNull('dealer_id')
            ->with('cars')
            ->orderByDesc('updated_at')
            ->get();


        // Дилеры с их клиентами
        $dealers = Dealer::with([
            'clients.cars'
        ])
        ->orderByDesc('updated_at')
        ->get();


        return view('clients.index', compact(
            'clients',
            'dealers'
        ));
    }

    public function storeClient(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $client = new \App\Models\Client();
        $client->full_name = $validatedData['full_name'];
        $client->phone = $validatedData['phone'];
        $client->notes = $validatedData['notes'];
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Клиент успешно создан.');
    }

    public function storeDealer(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $dealer = new \App\Models\Dealer();
        $dealer->full_name = $validatedData['full_name'];
        $dealer->notes = $validatedData['notes'];
        $dealer->save();

        return redirect()->route('clients.index')->with('success', 'Дилер успешно создан.');
    }
}
