<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Enums\CarStatus;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Активные клиенты без дилера
        |--------------------------------------------------------------------------
        */

        $clients = Client::whereNull('dealer_id')
            ->where(function ($query) {
                $query->whereDoesntHave('cars')
                    ->orWhereHas('cars', function ($q) {
                        $q->whereNotIn('status', [
                            CarStatus::COMPLETED,
                            CarStatus::CANCELLED,
                        ]);
                    });
            })
            ->with([
                'cars' => function ($query) {
                    $query->whereNotIn('status', [
                        CarStatus::COMPLETED,
                        CarStatus::CANCELLED,
                    ])->orderByDesc('updated_at');
                }
            ])
            ->orderByDesc('updated_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Активные дилеры
        |--------------------------------------------------------------------------
        |
        | Дилер попадёт сюда только если у него есть хотя бы один
        | клиент с хотя бы одним активным заказом.
        |
        */

        $dealers = Dealer::whereHas('clients.cars', function ($query) {
                $query->whereNotIn('status', [
                    CarStatus::COMPLETED,
                    CarStatus::CANCELLED,
                ]);
            })
            ->with([
                'clients' => function ($query) {
                    $query->whereHas('cars', function ($cars) {
                        $cars->whereNotIn('status', [
                            CarStatus::COMPLETED,
                            CarStatus::CANCELLED,
                        ]);
                    })
                    ->orderByDesc('updated_at');
                },

                'clients.cars' => function ($query) {
                    $query->whereNotIn('status', [
                        CarStatus::COMPLETED,
                        CarStatus::CANCELLED,
                    ])->orderByDesc('updated_at');
                },
            ])
            ->orderBy('full_name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Архивные клиенты без дилера
        |--------------------------------------------------------------------------
        */

        $archiveClients = Client::whereNull('dealer_id')
            ->whereDoesntHave('cars', function ($query) {
                $query->whereNotIn('status', [
                    CarStatus::COMPLETED,
                    CarStatus::CANCELLED,
                ]);
            })
            ->whereHas('cars')
            ->with('cars')
            ->orderByDesc('updated_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Архивные дилеры
        |--------------------------------------------------------------------------
        |
        | Дилер попадёт сюда только если у него есть клиенты,
        | но ни у одного из них нет активных заказов.
        |
        */

        $archiveDealers = Dealer::whereHas('clients', function ($query) {
                $query->whereHas('cars')
                    ->whereDoesntHave('cars', function ($cars) {
                        $cars->whereNotIn('status', [
                            CarStatus::COMPLETED,
                            CarStatus::CANCELLED,
                        ]);
                    });
            })
            ->with([
                'clients' => function ($query) {
                    $query->whereHas('cars')
                        ->whereDoesntHave('cars', function ($cars) {
                            $cars->whereNotIn('status', [
                                CarStatus::COMPLETED,
                                CarStatus::CANCELLED,
                            ]);
                        })
                        ->orderByDesc('updated_at');
                },

                'clients.cars',
            ])
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

    public function edit(string $type, int $id)
    {
        if ($type === 'client') {
            $contact = Client::findOrFail($id);
            $dealers = Dealer::orderBy('full_name')->get();
        } else {
            $contact = Dealer::findOrFail($id);
            $dealers = collect();
        }

        return view('clients.edit', compact(
            'contact',
            'type',
            'dealers'
        ));
    }

    public function update(Request $request, string $type, int $id)
    {
        if ($type === 'client') {

            $client = Client::findOrFail($id);

            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'dealer_id' => 'nullable|exists:dealers,id',
                'notes' => 'nullable|string',
            ]);

            $client->update($validated);

        } else {

            $dealer = Dealer::findOrFail($id);

            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'notes' => 'nullable|string',
            ]);

            $dealer->update($validated);
        }

        return redirect()
            ->route('clients.show', [
                'type' => $type,
                'id' => $id,
            ])
            ->with('success', 'Данные успешно обновлены.');
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

    public function destroyDealer(Dealer $dealer)
    {
        $dealer->load('clients');

        DB::transaction(function () use ($dealer) {

            foreach ($dealer->clients as $client) {

                $note = sprintf(
                    "[%s] Был клиентом перекупа: %s.",
                    now()->format('d.m.Y H:i'),
                    $dealer->full_name
                );

                $client->update([
                    'dealer_id' => null,
                    'notes' => $client->notes
                        ? $client->notes . PHP_EOL . PHP_EOL . $note
                        : $note,
                ]);
            }

            $dealer->delete();

        });


        return redirect()
            ->route('clients.index')
            ->with('success', 'Перекуп удалён. Клиенты отвязаны.');
    }
}
