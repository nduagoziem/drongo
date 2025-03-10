<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FacePPAPIService
{
    private $base_url;
    private $api_key;
    private $api_secret;

    public function __construct($base_url, $api_key, $api_secret)
    {
        $this->base_url = $base_url;
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }

    public function compareImageByBase64($comparingImage, $referenceImage)
    {
        $response = Http::asForm()->post($this->base_url, [ // asForm method is required
            'api_key' => $this->api_key,
            'api_secret' => $this->api_secret,
            'image_base64_1' => $comparingImage,
            'image_base64_2' => $referenceImage,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'confidence' => $data['confidence'] ?? null,
                'thresholds' => $data['thresholds'] ?? null,
                'error_message' => $data['error_message'] ?? null,
            ];
        } else {
            return [
                'error_message' => $response->body()
            ];
        }
    }
}
