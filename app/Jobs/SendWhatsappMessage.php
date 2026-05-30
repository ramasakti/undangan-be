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

    private function formatNomor($nomor): string
    {
        // Hapus karakter selain angka
        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        // 08xxxx -> 628xxxx
        if (substr($nomor, 0, 2) === '08') {
            return '62' . substr($nomor, 1);
        }

        // 8xxxx -> 628xxxx
        if (substr($nomor, 0, 1) === '8') {
            return '62' . $nomor;
        }

        // 628xxxx
        if (substr($nomor, 0, 2) === '62') {
            return $nomor;
        }

        return $nomor;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = env("WAHA_API_URL") . "/api/sendText";
        $apiKey = env("WAHA_API_KEY");

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'accept' => 'application/json',
                    'X-Api-Key' => $apiKey,
                    'x-session-id' => 'ramasakti',
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    "chatId" => $this->formatNomor($this->nomor) . '@c.us',
                    "text" => $this->text,
                    "session" => "default",
                    "linkPreview" => true,
                    "linkPreviewHighQuality" => true,
                ]);

            Log::info('WAHA RESPONSE', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        } catch (\Exception $e) {
            Log::error("WAHA error ke {$this->nomor} : " . $e->getMessage());
        }
    }
}
