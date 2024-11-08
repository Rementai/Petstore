<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\PetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PetControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testIndexDisplaysAvailablePets()
    {
        Http::fake([
            '*/pet/findByStatus*' => Http::response([
                ['id' => 1, 'name' => 'Dog', 'status' => 'available'],
            ], 200),
        ]);

        $response = $this->get(route('pets.index'));

        $response->assertStatus(200);
        $response->assertSee('Dog');
    }

    public function testShowDisplaysPetDetails()
    {
        $petId = 1;
        Http::fake([
            "*/pet/{$petId}" => Http::response(['id' => $petId, 'name' => 'Cat'], 200),
        ]);

        $response = $this->get(route('pets.show', $petId));

        $response->assertStatus(200);
        $response->assertSee('Cat');
    }

    public function testStoreCreatesNewPet()
    {
        $this->withoutMiddleware();

        Http::fake([
            '*/pet' => Http::response(['id' => 2, 'name' => 'Bird', 'status' => 'available'], 201),
        ]);

        $response = $this->post(route('pets.store'), [
            'name' => 'Bird',
            'status' => 'available',
        ]);

        $response->assertRedirect(route('pets.index'));
        $response->assertSessionHas('success', 'Pet created successfully!');
    }

    public function testUpdateModifiesPet()
    {
        $this->withoutMiddleware();

        $petId = 1;
        Http::fake([
            '*/pet' => Http::response(['id' => $petId, 'name' => 'Dog', 'status' => 'sold'], 200),
        ]);

        $response = $this->put(route('pets.update', $petId), [
            'name' => 'Dog',
            'status' => 'sold',
        ]);

        $response->assertRedirect(route('pets.index'));
        $response->assertSessionHas('success', 'Pet updated successfully!');
    }

    public function testDestroyDeletesPet()
    {
        $this->withoutMiddleware();
    
        $petId = 1;
        Http::fake([
            "*/pet/{$petId}" => Http::response(null, 204),
        ]);
    
        $response = $this->delete(route('pets.destroy', $petId));
    
        $response->assertRedirect(route('pets.index'));
        $response->assertSessionHas('success', 'Pet deleted successfully!');
    }
    
}
