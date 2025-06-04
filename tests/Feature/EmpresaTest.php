<?php 

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Domain\Entities\Empresa;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_una_empresa_correctamente()
    {
        $response = $this->postJson('/api/empresa', [
            'nit' => '123456789',
            'nombre' => 'Mi Empresa S.A.S.',
            'direccion' => 'Cra xx',
            'telefono' => '272327666'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'empresa' => ['nit', 'nombre', 'direccion', 'telefono', 'created_at', 'updated_at']
                 ]);

        $this->assertDatabaseHas('empresas', ['nit' => '123456789']);
    }

    public function test_no_crea_empresa_con_nit_duplicado()
    {
        Empresa::create([
            'nit' => '987654321',
            'nombre' => 'Empresa Inicial',
            'direccion' => 'Cra xx',
            'telefono' => '272327666'
        ]);

        $response = $this->postJson('/api/empresa', [
            'nombre' => 'Empresa Duplicada',
            'nit' => '987654321',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nit']);
    }

    #[Test]
    public function no_crea_empresa_si_falta_el_nombre()
    {
        $response = $this->postJson('/api/empresa', [
            'nit' => '123123123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }
}
