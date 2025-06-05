<?php

namespace Tests\Unit;

use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use App\Application\UseCases\CrearEmpresaService;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Entities\Empresa;
use App\Application\DTOs\EmpresaDTO;

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
        $data = [
                    'nit' => '123456789', 
                    'nombre' => 'Mi Empresa', 
                    'direccion' => 'Cra xx', 
                    'telefono' => '272327666'
        ];

        // Objeto simulado de Empresa que el repositorio devolvería
        $empresaMock = new Empresa(
            $data ['nit'],
            $data ['nombre'],
            $data ['direccion'],
            $data ['telefono']
        );

        // Esperamos que el repositorio reciba los datos y devuelva la Empresa
        $this->empresaRepository
            ->shouldReceive('crear')
            ->once()
            ->with(Mockery::on(function ($arg) use ($data) {
                return $arg->nit === $data['nit']
                    && $arg->nombre === $data['nombre']
                    && $arg->direccion === $data['direccion']
                    && $arg->telefono === $data['telefono'];
            }))
            ->andReturn($empresaMock);

        // Ejecutar el método real
        $resultado = $this->crearEmpresaService->handle($data);

        // Verificar que se devolvió lo esperado
        $this->assertInstanceOf(Empresa::class, $resultado);
        $this->assertEquals($data['nit'], $resultado->nit);
        $this->assertEquals($data['nombre'], $resultado->nombre);
        $this->assertEquals($data['direccion'], $resultado->direccion);
        $this->assertEquals($data['telefono'], $resultado->telefono);
    }

    public function test_crear_empresa_lanza_excepcion_si_repositorio_falla()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error al crear empresa');

        $data = [
                            'nit' => '123456789', 
                            'nombre' => 'Mi Empresa', 
                            'direccion' => 'Cra xx', 
                            'telefono' => '272327666'
                ];

        $this->empresaRepository
            ->shouldReceive('crear')
            ->once()
            ->andThrow(new \Exception('Error al crear empresa'));

        $this->crearEmpresaService->handle($data);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
