<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WAHAService
{
    public function checkSessionOrchestrator($session)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-Api-Key' => env("WAHA_ORCHESTRATOR_API_KEY"),
            'x-session-id' => $session,
            'Content-Type' => 'application/json',
        ])->get(env("WAHA_ORCHESTRATOR_API_URL") . "/sessions/" . $session);

        return $response;
    }

    public function createSessionOrchestrator($session)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-Api-Key' => env("WAHA_ORCHESTRATOR_API_KEY"),
            'x-session-id' => $session,
            'Content-Type' => 'application/json',
        ])->post(env("WAHA_ORCHESTRATOR_API_URL") . "/sessions", [
            "sessionId" => $session
        ]);

        return $response;
    }

    public function deleteSessionOrchestrator($session)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-Api-Key' => env("WAHA_ORCHESTRATOR_API_KEY"),
            'x-session-id' => $session,
            'Content-Type' => 'application/json',
        ])->delete(env("WAHA_ORCHESTRATOR_API_URL") . "/sessions/" . $session);

        return $response;
    }

    /**
     * WAHA session info
     */
    public function sessionInfo($session)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-Api-Key' => env("WAHA_API_KEY"),
            'x-session-id' => $session,
            'Content-Type' => 'application/json',
        ])->get(env("WAHA_API_URL") . "/api/sessions/default");

        return $response->json();
    }

    /** 
     * WAHA restart session 
     */
    public function restartSession($session)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-Api-Key' => env("WAHA_API_KEY"),
            'x-session-id' => $session,
            'Content-Type' => 'application/json',
        ])->post(env("WAHA_API_URL") . "/api/sessions/default/restart");

        if ($response->failed()) {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'X-Api-Key' => env("WAHA_API_KEY"),
                'x-session-id' => $session,
                'Content-Type' => 'application/json',
            ])->post(env("WAHA_API_URL") . "/api/sessions/default/restart");
        }

        return $response;
    }

    /**
     * Send a message through the WAHA orchestrator
     */
    public function sendMessage($session, $number, $message)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-Api-Key' => env("WAHA_ORCHESTRATOR_API_KEY"),
            'x-session-id' => $session,
            'Content-Type' => 'application/json',
        ])->post(env("WAHA_ORCHESTRATOR_API_URL") . "/messages/send", [
            'to' => $number,
            'message' => $message,
        ]);

        return $response->json();
    }
}
