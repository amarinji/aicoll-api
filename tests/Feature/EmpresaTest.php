<?php 

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Empresa;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function crea_una_empresa_correctamente()
    {
        $response = $this->postJson('/api/empresas', [
            'nombre' => 'Mi Empresa S.A.S.',
            'nit' => '123456789',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'empresa' => ['id', 'nombre', 'nit', 'created_at', 'updated_at']
                 ]);

        $this->assertDatabaseHas('empresas', ['nit' => '123456789']);
    }

    #[Test]
    public function no_crea_empresa_con_nit_duplicado()
    {
        Empresa::create([
            'nombre' => 'Empresa Inicial',
            'nit' => '987654321',
        ]);

        $response = $this->postJson('/api/empresas', [
            'nombre' => 'Empresa Duplicada',
            'nit' => '987654321',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nit']);
    }

    #[Test]
    public function no_crea_empresa_si_falta_el_nombre()
    {
        $response = $this->postJson('/api/empresas', [
            'nit' => '123123123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }
}
