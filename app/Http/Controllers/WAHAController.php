<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendWhatsappMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\WAHAService;

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

    public function connect()
    {
        $status = null;
        $title = "Whatsapp Connector";
        $waha = new WAHAService();

        $session = $waha->checkSessionOrchestrator(Auth::user()->username);

        if ($session->failed()) {
            $regist = $waha->createSessionOrchestrator(Auth::user()->username);

            if (!$regist->failed()) {
                $waha->restartSession(Auth::user()->username);
            }
        }

        $info = $waha->sessionInfo(Auth::user()->username);
        $status = $info['status'] ?? null;
        if ($status === null || $status == "STOPPED" || $status == "FAILED") $waha->restartSession(Auth::user()->username);

        return view("waha.index", [
            "title" => $title,
            "status" => $status
        ]);
    }

    public function connecting(Request $request)
    {
        $request->validate([
            'method' => 'required|in:qr,otp',
            'nomor' => 'required_if:method,otp'
        ]);

        $method = $request->method;

        switch ($method) {
            case 'qr':
                return $this->qr($request);
                break;
            case 'otp':
                return $this->otp($request);
                break;
        }
    }

    public function qr($request)
    {
        try {
            $res = Http::withHeaders([
                'accept' => 'application/json',
                'X-Api-Key' => env("WAHA_API_KEY"),
                'x-session-id' => Auth::user()->username,
                'Content-Type' => 'application/json',
            ])->get(env("WAHA_API_URL") . "/api/default/auth/qr");

            return redirect()->route('waha.connect')->with('qr', $res->json());
        } catch (\Exception $e) {
            Log::error("WAHA error ke {$request->nomor} : " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP, silakan coba lagi'
            ], 500);
        }
    }

    public function otp($request)
    {
        $nomor = $this->formatNomor($request->nomor);
        try {
            $res = Http::withHeaders([
                'accept' => 'application/json',
                'X-Api-Key' => env("WAHA_API_KEY"),
                'x-session-id' => Auth::user()->username,
                'Content-Type' => 'application/json',
            ])->post(env("WAHA_API_URL") . "/api/default/auth/request-code", [
                "phoneNumber" => $nomor,
                "method" => null
            ]);

            return redirect()->route('waha.connect')->with('otp', $res->json())->with('nomor', $nomor);
        } catch (\Exception $e) {
            Log::error("WAHA error ke {$request->nomor} : " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP, silakan coba lagi'
            ], 500);
        }
    }
}
