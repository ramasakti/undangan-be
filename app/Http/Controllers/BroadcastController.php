<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendWhatsappMessage;
use App\Models\TamuModel;
use Illuminate\Support\Facades\Log;

class BroadcastController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'pesan' => 'required',
            'tamu_ids' => 'required|array'
        ]);

        $template = $request->pesan;

        $tamu = TamuModel::whereIn('id', $request->tamu_ids)->get();

        foreach ($tamu as $index => $item) {
            $pesan = str_replace(
                ['{nama}', '{kode_tamu}'],
                [$item->nama_tamu, $item->kode_tamu],
                $template
            );

            SendWhatsappMessage::dispatch(
                $item->no_wa,
                $pesan
            )->delay(
                now()->addSeconds($index * 20)
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Broadcast berhasil dimasukkan ke queue'
        ]);
    }
}
