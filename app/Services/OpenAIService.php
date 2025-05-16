<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = 'io-v2-eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJvd25lciI6ImEyNWY5ZTVmLWFlNGQtNGVlNi04Y2M1LTU3OGQxMjZmMDkwNSIsImV4cCI6NDkwMDQ0OTM5MX0.dNj55xRZwrrf49RTr5_3k8jru9q_6U7-0R4_qZDlTyVxv0mF2Ungt0h8u3BahFx4KuCWo-Ep_qqPoSZ-tXIH1Q'; // Замените на ваш API-ключ
        $this->baseUrl = 'https://api.intelligence.io.solutions/api/v1/';
        $this->client = new Client();
    }

    public function getCompletion($prompt)
    {
        $body = [
            'model' => 'meta-llama/Llama-3.3-70B-Instruct',
            'messages' => [
                ['role' => 'system', 'content' => 'Ты специалист по устройству компьютера'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
            'max_completion_tokens' => 1500,
        ];

        try {
            $response = $this->client->post($this->baseUrl . 'chat/completions', [
            'headers' => [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            ],
            'json' => $body,
            'verify' => false, // Отключение проверки SSL
        ]);

            $responseBody = json_decode($response->getBody(), true);
            return $responseBody['choices'][0]['message']['content'] ?? null;

        } catch (RequestException $e) {
            return 'Ошибка: ' . $e->getMessage();
        }
    }
}
