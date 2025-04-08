<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FacePPAPIService
{

    public function compareImageByBase64($comparingImage, $referenceImage)
    {
        $response = Http::asForm()->post(config('services.facepp.base_url'), [ // asForm method is required
            'api_key' => config('services.facepp.api_key'),
            'api_secret' => config('services.facepp.api_secret'),
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
