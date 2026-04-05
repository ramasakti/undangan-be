<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TamuModel as Tamu;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TamuImport;
use App\Models\TamuModel;

class TamuController extends Controller
{
    public function index()
    {
        $title = "Daftar Tamu";
        $tamu = Tamu::with('uploader')->latest()->get();
        return view('tamu.index', compact('title', 'tamu'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_tamu' => 'required',
                'no_wa' => 'required'
            ]);

            Tamu::create([
                'kode_tamu' => Str::random(6),
                'nama_tamu' => $request->nama_tamu,
                'no_wa' => $request->no_wa
            ]);

            return back()->with('success', 'Tamu berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menambahkan tamu');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tamu = Tamu::findOrFail($id);

            $request->validate([
                'nama_tamu' => 'required',
                'no_wa' => 'required'
            ]);

            $tamu->update([
                'nama_tamu' => $request->nama_tamu,
                'no_wa' => $request->no_wa
            ]);

            return back()->with('success', 'Tamu berhasil diupdate');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal update tamu');
        }
    }

    public function destroy($id)
    {
        try {
            $tamu = Tamu::findOrFail($id);
            $tamu->delete();

            return back()->with('success', 'Tamu berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus tamu');
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xls,xlsx'
            ]);

            Excel::import(new TamuImport, $request->file('file'));

            return back()->with('success', 'Import Excel berhasil');
        } catch (\Exception $e) {
            return back()->with('failed', 'Import Excel gagal');
        }
    }

    public function show($kode_tamu)
    {
        try {
            $tamu = Tamu::where('kode_tamu', $kode_tamu)->first();

            return response()->json([
                'success' => true,
                'data' => $tamu
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error!'
            ], 500);
        }
    }

    public function massdel(Request $request)
    {
        $request->validate([
            "id_tamu" => "required|string"
        ]);

        $ids = explode(",", $request->id_tamu);
        $tamu = TamuModel::whereIn("id", $ids)->get();
        $jumlah = $tamu->count();
        TamuModel::destroy($ids);

        return back()->with("success", "Berhasil hapus {$jumlah} tamu");
    }
}
