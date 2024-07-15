<?php

namespace App\Service;

use GuzzleHttp\Client;

class TranslationService {

    private $client;
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $text
     * @param string $targetLanguage
     * @param string $sourceLanguage
     * @return string
     */
    public function translate(string $text, string $targetLanguage, string $sourceLanguage = 'en' ): string
    {
        $response = $this->client->post('https://translation.googleapis.com/language/translate/v2', [
            'json' => [
                'q' => $text,
                'target' => $targetLanguage,
                'source' => $sourceLanguage,
                'format' => 'text'
            ],
            'query' => [
                'key' => $this->apiKey
            ]
        ]);

        $body = json_decode((string) $response->getBody(), true);

        return $body['data']['translations'][0]['translatedText'];
        
    }
    
}