<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();
    $this->artisan('passport:install');
  }

  public function test_store_book_with_valid_data()
  {
    $user = \App\Models\User::factory()->create();
    $token = $user->createToken('TestToken')->accessToken;

    $this->actingAs($user);

    $bookData = [
      'titulo' => 'Clean Architecture',
      'indices' => [
        [
          'titulo' => 'Alfa',
          'pagina' => 2,
          'subindices' => [
            [
              'titulo' => 'Beta',
              'pagina' => 3,
              'subindices' => [
                [
                  'titulo' => 'Gama',
                  'pagina' => 3,
                  'subindices' => [],
                ],
              ],
            ],
          ],
        ],
      ],
    ];

    $response = $this->withHeaders([
      'Accept' => 'application/json',
      'Authorization' => 'Bearer ' . $token,
    ])->json('POST', '/api/v1/books', $bookData);

    $response->assertStatus(201);

    $response->assertJson([
      'titulo' => $bookData['titulo'],
      'usuario_publicador_id' => $user->id,
    ]);

    $this->assertDatabaseHas('books', [
      'titulo' => $bookData['titulo'],
      'usuario_publicador_id' => $user->id,
    ]);

    $this->assertDatabaseHas('indices', [
      'titulo' => 'Alfa',
      'pagina' => 2,
      'indice_pai_id' => null,
    ]);

    $this->assertDatabaseHas('indices', [
      'titulo' => 'Beta',
      'pagina' => 3,
      'indice_pai_id' => 1,
    ]);

    $this->assertDatabaseHas('indices', [
      'titulo' => 'Gama',
      'pagina' => 3,
      'indice_pai_id' => 2,
    ]);
  }

  public function test_store_book_with_invalid_data()
  {
    $user = \App\Models\User::factory()->create();
    $token = $user->createToken('TestToken')->accessToken;

    $this->actingAs($user);

    $bookData = [];

    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $token,
      'Accept' => 'application/json',
    ])->json('POST', '/api/v1/books', $bookData);

    $response->assertStatus(422);
  }
}