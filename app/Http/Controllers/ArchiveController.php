<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dealer;
use App\Enums\CarStatus;

class ArchiveController extends Controller
{
    public function index()
    {
        $clients = Client::with([
            'cars' => function ($query) {
                $query->whereIn('status', [
                    CarStatus::COMPLETED,
                    CarStatus::CANCELLED,
                ])
                ->orderByDesc('updated_at');
            }
        ])
        ->whereHas('cars', function ($query) {
            $query->whereIn('status', [
                CarStatus::COMPLETED,
                CarStatus::CANCELLED,
            ]);
        })
        ->whereNull('dealer_id')
        ->get();


        $dealers = Dealer::with([
            'clients.cars' => function ($query) {
                $query->whereIn('status', [
                    CarStatus::COMPLETED,
                    CarStatus::CANCELLED,
                ])
                ->orderByDesc('updated_at');
            }
        ])
        ->whereHas('clients.cars', function ($query) {
            $query->whereIn('status', [
                CarStatus::COMPLETED,
                CarStatus::CANCELLED,
            ]);
        })
        ->get();


        return view('archive.index', compact(
            'clients',
            'dealers'
        ));
    }
}