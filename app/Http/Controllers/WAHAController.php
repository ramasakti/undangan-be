<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendWhatsappMessage;

class WAHAController extends Controller
{
    private function formatNomor($number)
    {
        $number = (string) $number;
        $number = preg_replace('/[^0-9+]/', '', $number);
        $number = preg_replace('/^(\+?62|0|)/', '62', $number);
        return $number;
    }

    public function broadcast(Request $request)
    {
        $request->validate([
            'nomor' => 'required|array',
            'text' => 'required'
        ]);

        $delay = 0;

        foreach ($request->nomor as $nomor) {
            $formattedNomor = $this->formatNomor($nomor);
            $delay += rand(10, 20);
            SendWhatsappMessage::dispatch($formattedNomor, $request->text)->delay(now()->addSeconds($delay));
        }

        return response()->json([
            'success' => true,
            'message' => 'Broadcast sedang diproses'
        ]);
    }
}
