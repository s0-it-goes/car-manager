<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Enums\CarStatus;

class ClientController extends Controller
{

    public function index()
    {
        // Активные клиенты без дилера
        $clients = Client::whereNull('dealer_id')
            ->where(function ($query) {

                $query->whereDoesntHave('cars') // нет машин вообще

                ->orWhereHas('cars', function ($q) {
                    // есть активные машины
                    $q->whereNotIn('status', [
                        CarStatus::COMPLETED,
                        CarStatus::CANCELLED
                    ]);
                });

            })
            ->with([
                'cars' => function ($query) {
                    $query->whereNotIn('status', [
                        CarStatus::COMPLETED,
                        CarStatus::CANCELLED
                    ])
                    ->orderByDesc('updated_at');
                }
            ])
            ->orderByDesc('updated_at')
            ->get();



        // Активные клиенты дилеров
        $dealers = Dealer::with([
            'clients' => function ($query) {

                $query->where(function ($q) {

                    $q->whereDoesntHave('cars')

                    ->orWhereHas('cars', function ($cars) {
                        $cars->whereNotIn('status', [
                            CarStatus::COMPLETED,
                            CarStatus::CANCELLED
                        ]);
                    });

                });

            },

            'clients.cars' => function ($query) {

                $query->whereNotIn('status', [
                    CarStatus::COMPLETED,
                    CarStatus::CANCELLED
                ]);

            }

        ])
        ->whereHas('clients')
        ->orderBy('full_name')
        ->get();




        // Архивные клиенты без дилера
        $archiveClients = Client::whereNull('dealer_id')
            ->whereDoesntHave('cars', function ($query) {

                $query->whereNotIn('status', [
                    CarStatus::COMPLETED,
                    CarStatus::CANCELLED
                ]);

            })
            ->whereHas('cars')
            ->with('cars')
            ->orderByDesc('updated_at')
            ->get();




        // Архивные клиенты дилеров
        $archiveDealers = Dealer::with([
            'clients' => function ($query) {

                $query->whereDoesntHave('cars', function ($q) {

                    $q->whereNotIn('status', [
                        CarStatus::COMPLETED,
                        CarStatus::CANCELLED
                    ]);

                })
                ->whereHas('cars');

            },

            'clients.cars'

        ])
        ->whereHas('clients', function ($query) {

            $query->whereDoesntHave('cars', function ($q) {

                $q->whereNotIn('status', [
                    CarStatus::COMPLETED,
                    CarStatus::CANCELLED
                ]);

            })
            ->whereHas('cars');

        })
        ->orderByDesc('updated_at')
        ->get();



        return view('clients.index', compact(
            'clients',
            'dealers',
            'archiveClients',
            'archiveDealers'
        ));
    }

    public function show(string $type, int $id)
    {
        $contact = match ($type) {
            'client' => Client::with(['dealer', 'cars'])->findOrFail($id),
            'dealer' => Dealer::with(['clients.cars'])->findOrFail($id),
            default => abort(404),
        };

        return view('clients.show', compact('contact', 'type'));
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

    public function destroy(Client $client)
    {
        foreach ($client->cars as $car) {
            /*
            $car->photos()->delete();
            $car->documents()->delete();
            $car->tasks()->delete();
        */
            $car->delete();
        }

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Клиент удалён.');
    }
}
