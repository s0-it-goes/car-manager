<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('updated_at', 'desc')->get();
        return view('clients.index', compact('clients'));
    }

    public function showCreate()
    {
        return view('clients.create');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $client = new \App\Models\Client();
        $client->full_name = $validatedData['full_name'];
        $client->phone = $validatedData['phone'];
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Клиент успешно создан.');
    }
}
