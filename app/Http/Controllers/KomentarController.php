<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomentarModel as Komentar;
use App\Models\TamuModel as Tamu;

class KomentarController extends Controller
{
    public function data()
    {
        $title = 'Komentar';
        $komentar = Komentar::with('tamu')->latest()->get();
        return view('komentar.index', compact('title', 'komentar'));
    }

    public function index()
    {
        $data = Komentar::with('tamu')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = Komentar::with('tamu')->find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Komentar tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tamu' => 'required|exists:tamu,kode_tamu',
            'komentar' => 'required'
        ]);

        $data = Komentar::create([
            'kode_tamu' => $request->kode_tamu,
            'komentar' => $request->komentar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dibuat',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $komentar = Komentar::find($id);

        if (!$komentar) {
            return response()->json([
                'success' => false,
                'message' => 'Komentar tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'komentar' => 'required'
        ]);

        $komentar->update([
            'komentar' => $request->komentar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil diupdate',
            'data' => $komentar
        ]);
    }

    public function destroy($id)
    {
        $komentar = Komentar::find($id);

        if (!$komentar) {
            return response()->json([
                'success' => false,
                'message' => 'Komentar tidak ditemukan'
            ], 404);
        }

        $komentar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dihapus'
        ]);
    }
}
