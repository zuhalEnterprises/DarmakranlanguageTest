<?php

namespace App\Services;

use GuzzleHttp\Client;

class GoogleTranslateService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 5,
            'connect_timeout' => 3,
        ]);
        $this->apiKey = trim((string) env('GOOGLE_TRANSLATE_API_KEY'));
    }

    public function translate($source, $target, $text)
    {
        $text = trim((string) $text);
        if ($text === '' || $this->apiKey === '') {
            return null;
        }

        try {
            $response = $this->client->post('https://translation.googleapis.com/language/translate/v2', [
                'query' => [
                    'key' => $this->apiKey,
                    'q' => $text,
                    'source' => $source,
                    'target' => $target,
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            return $result['data']['translations'][0]['translatedText'] ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}