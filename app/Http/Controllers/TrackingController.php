<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking');
    }

    public function search(Request $request)
    {
        $request->validate([
            'passport_number' => 'required|string|min:3',
            'unique_code'     => 'required|string|min:3',
        ], [
            'passport_number.required' => 'Nomor passport wajib diisi.',
            'unique_code.required'     => 'Kode unik wajib diisi.',
        ]);

        $order = Order::with('customer')
            ->whereHas('customer', function ($query) use ($request) {
                $query->where('passport_number', strtoupper(trim($request->passport_number)));
            })
            ->where('unique_code', strtoupper(trim($request->unique_code)))
            ->first();

        if (!$order) {
            return back()
                ->withInput()
                ->with('error', 'Data tidak ditemukan. Periksa kembali nomor passport dan kode unik Anda.');
        }

        return view('tracking', compact('order'));
    }
}
