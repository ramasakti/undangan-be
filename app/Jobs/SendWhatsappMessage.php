<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsappMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $nomor, $text;

    /**
     * Create a new job instance.
     */
    public function __construct($nomor, $text)
    {
        $this->nomor = $nomor;
        $this->text = $text;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = env("WAHA_API_URL") . "/api/sendText";
        $apiKey = env("WAHA_API_KEY");

        try {
            Http::withHeaders([
                'accept' => 'application/json',
                'X-Api-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post($url, [
                "chatId" => $this->nomor . "@c.us",
                "reply_to" => null,
                "text" => $this->text,
                "linkPreview" => true,
                "linkPreviewHighQuality" => true,
                "session" => "default"
            ]);
        } catch (\Exception $e) {
            Log::error("WAHA error ke {$this->nomor} : ".$e->getMessage());
        }
    }
}
