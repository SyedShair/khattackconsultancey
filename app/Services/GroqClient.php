<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqClient
{
    protected string $endpoint = 'https://api.groq.com/openai/v1/chat/completions';

    /**
     * Send a freeform visitor message to Groq and get back a short,
     * on-brand assistant reply. Never throws — on any failure (missing
     * key, network error, bad response) it returns a graceful fallback
     * string instead, so the chat widget never breaks for the visitor.
     */
    public function reply(string $userMessage, array $history = []): string
    {
        $apiKey = config('services.groq.key');

        if (! $apiKey) {
            return $this->fallback();
        }

        try {
            $setting = Setting::first();
            $companyName = $setting->app_name ?? config('app.name');

            $systemPrompt = "You are a friendly, concise virtual assistant for {$companyName}, a business "
                . "consultancy. Keep replies short (2-4 sentences), professional, and helpful. "
                . "If the visitor seems interested in speaking to someone or booking time, "
                . "suggest they use the \"Book a Consultation\" or \"Talk to Our Team\" options "
                . "in this chat widget rather than trying to book anything yourself. "
                . "Do not invent pricing, guarantees, or specific availability — you don't have that information.";

            $messages = array_merge(
                [['role' => 'system', 'content' => $systemPrompt]],
                $history,
                [['role' => 'user', 'content' => $userMessage]]
            );

            $response = Http::withToken($apiKey)
                ->timeout(12)
                ->post($this->endpoint, [
                    'model'       => config('services.groq.model', 'llama-3.3-70b-versatile'),
                    'messages'    => $messages,
                    'temperature' => 0.6,
                    'max_tokens'  => 220,
                ]);

            if (! $response->successful()) {
                Log::warning('Groq API non-success response', ['status' => $response->status(), 'body' => $response->body()]);

                return $this->fallback();
            }

            $text = $response->json('choices.0.message.content');

            return $text ? trim($text) : $this->fallback();
        } catch (\Throwable $e) {
            Log::error('Groq API request failed: ' . $e->getMessage());

            return $this->fallback();
        }
    }

    protected function fallback(): string
    {
        return "Sorry, I'm having a little trouble connecting right now. "
            . "You can still book a consultation or talk to our team using the options below, "
            . "and a real person will get back to you.";
    }
}
