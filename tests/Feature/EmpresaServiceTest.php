<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Application\UseCases\CrearEmpresaService;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Entities\Empresa;
use App\Application\DTOs\EmpresaDTO;
use Mockery;
use Mockery\MockInterface;

class EmpresaServiceTest extends TestCase
{
    protected MockInterface $empresaRepository;
    protected CrearEmpresaService $crearEmpresaService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->empresaRepository = Mockery::mock(EmpresaRepositoryInterface::class);
        $this->crearEmpresaService = new CrearEmpresaService($this->empresaRepository);
    }

    public function test_crear_empresa_llama_al_repositorio_con_datos_correctos()
    {
        // Datos de entrada simulados
        $data = [
            'nit' => '123456789',
            'nombre' => 'Mi Empresa',
            'direccion' => 'Cra xx',
            'telefono' => '272327666'
        ];

        // DTO con esos datos
        $empresaDTO = new EmpresaDTO($data);

        // Objeto simulado de Empresa que el repositorio devolvería
        $empresaMock = new Empresa($data);

        // Esperamos que el repositorio reciba los datos y devuelva la Empresa
        $this->empresaRepository
            ->shouldReceive('crear')
            ->once()
            ->with(Mockery::on(function ($arg) use ($data) {
                return $arg['nit'] === $data['nit']
                    && $arg['nombre'] === $data['nombre']
                    && $arg['direccion'] === $data['direccion']
                    && $arg['telefono'] === $data['telefono'];
            }))
            ->andReturn($empresaMock);

        // Ejecutar el método real
        $resultado = $this->crearEmpresaService->crearEmpresa($empresaDTO);

        // Verificar que se devolvió lo esperado
        $this->assertInstanceOf(Empresa::class, $resultado);
        $this->assertEquals($data['nit'], $resultado->nit);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
