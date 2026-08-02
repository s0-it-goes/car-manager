<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

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

    public function show($type, $id)
    {
        
        if ($type === 'client') {

            $contact = Client::with([
                'dealer',
                'cars'
            ])->findOrFail($id);


        } elseif ($type === 'dealer') {

            $contact = Dealer::with([
                'clients.cars'
            ])->findOrFail($id);


        } else {

            abort(404);

        }


        return view('clients.show', compact(
            'contact',
            'type'
        ));
    }

    public function create(Request $request)
    {

        return match($request->route()->getName()) {
            'clients.create.client' => view('clients.create.client', ['dealers' => Dealer::orderBy('full_name')->get()]),
            'clients.create.dealer' => view('clients.create.dealer'),
            default => abort(404),
        };
        
    }

    public function storeClient(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'dealer_id' => 'nullable|exists:dealers,id',
            'notes' => 'nullable|string',
        ]);

        Client::create([
            'full_name' => $validatedData['full_name'],
            'phone' => $validatedData['phone'] ?? null,
            'dealer_id' => $validatedData['dealer_id'] ?? null,
            'notes' => $validatedData['notes'] ?? null,
        ]);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Клиент успешно создан.');
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
