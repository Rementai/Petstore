<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class PetService
{
    protected string $baseUri;

    /*
    * Pet Service constructor.
    */
    public function __construct()
    {
        $this->baseUri = config('services.petstore.base_uri');
    }

    /**
     * Get available pets.
     *
     * @return array
     * @throws Exception
     */
    public function getPets(): array
    {
        return Http::get("{$this->baseUri}/pet/findByStatus", [
            'status' => 'available',
        ])->json();
    }

    /**
     * Get pet by ID.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function getPet(int $id): array
    {
        return Http::get("{$this->baseUri}/pet/{$id}")->json();
    }

    /**
     * Create new pet.
     *
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function createPet(array $data): array
    {
        return Http::post("{$this->baseUri}/pet", $data)->json();
    }

    /**
     * Update pet by ID.
     *
     * @param int $id
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function updatePet(int $id, array $data): array
    {
        return Http::put("{$this->baseUri}/pet", $data)->json();
    }

    /**
     * Delete pet by ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deletePet(int $id): bool
    {
        $response = Http::delete("{$this->baseUri}/pet/{$id}");
    
        if ($response->successful() || $response->status() === 204) {
            // Jeżeli odpowiedź jest sukcesem lub status to 204, zwróć true
            return true;
        }
    
        // Jeśli status to inny kod, zwróć false
        return false;
    }
}
