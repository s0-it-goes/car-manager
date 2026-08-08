<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    public function updateServerPayment(Request $request)
    {
        $validated = $request->validate([
            'server_paid_until' => ['required', 'date'],
        ]);

        $request->user()->update([
            'server_paid_until' => $validated['server_paid_until'],
        ]);

        return back()->with(
            'success',
            'Срок оплаты сервера обновлён.'
        );
    }
}