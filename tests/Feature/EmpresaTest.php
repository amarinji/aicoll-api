<?php 

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Infrastructure\Persistence\Eloquent\EmpresaModel;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_una_empresa_correctamente()
    {
        $response = $this->postJson('/api/empresa', [
            'nombre' => 'Mi Empresa S.A.S.',
            'nit' => '123456789',
            'direccion' => 'Cra xx',
            'telefono' => '27237236',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'empresa' => ['nit', 'nombre', 'direccion', 'telefono']
                 ]);

        $this->assertDatabaseHas('empresas', ['nit' => '123456789']);
    }

    public function test_no_crea_empresa_con_nit_duplicado()
    {
        EmpresaModel::create([
            'nombre' => 'Empresa Inicial',
            'nit' => '987654321',
            'direccion' => 'Cra xx',
            'telefono' => '27237236',
        ]);

        $response = $this->postJson('/api/empresa', [
            'nit' => '987654321',
            'nombre' => 'Empresa Duplicada',
            'direccion' => 'Cra xx',
            'telefono' => '27237236',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nit']);
    }

    public function test_no_crea_empresa_si_falta_el_nombre()
    {
        $response = $this->postJson('/api/empresa', [
            'nit' => '123123123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }
}
