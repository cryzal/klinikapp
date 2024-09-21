<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    private $baseUrl = 'http://recruitment.rsdeltasurya.com/api/v1/';
    private $token;

    public function authenticate()
    {
        $response = Http::post($this->baseUrl . 'auth', [
            'email' => 'agungariefperdanaputra@gmail.com',
            'password' => '082244409356',
        ]);

        if ($response->successful()) {
            $this->token = $response->json()['access_token'];
        } else {
            throw new \Exception('Authentication failed');
        }
    }

    public function getMedicines()
    {
        $response = Http::withToken($this->token)
                        ->get($this->baseUrl . 'medicines');

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to retrieve medicines');
        }
    }

    public function getMedicinePrice($medicineId)
    {
        $response = Http::withToken($this->token)->get($this->baseUrl ."medicines/{$medicineId}/prices");

        return $response->json();
    }
}
