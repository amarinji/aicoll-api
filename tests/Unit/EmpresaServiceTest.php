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

        $dto = new EmpresaDTO(
            nit: '123456789',
            nombre: 'Mi Empresa',
            direccion: 'Cra xx',
            telefono: '27237236',
        );

        $empresaMock = new Empresa(
            $dto->nit,
            $dto->nombre,
            $dto->direccion,
            $dto->telefono
        );

        $this->empresaRepository
            ->shouldReceive('crear')
            ->once()
            ->with(Mockery::on(function ($arg) use ($dto) {
                return $arg->nit === $dto->nit
                    && $arg->nombre === $dto->nombre
                    && $arg->direccion === $dto->direccion
                    && $arg->telefono === $dto->telefono;
            }))
            ->andReturn($empresaMock);

        // Ejecutar el método real
        $resultado = $this->crearEmpresaService->handle($dto);

        // Verificar que se devolvió lo esperado
        $this->assertInstanceOf(Empresa::class, $resultado);
        $this->assertEquals($dto->nit, $resultado->nit);
        $this->assertEquals($dto->nombre, $resultado->nombre);
        $this->assertEquals($dto->direccion, $resultado->direccion);
        $this->assertEquals($dto->telefono, $resultado->telefono);
    }

    public function test_crear_empresa_lanza_excepcion_si_repositorio_falla()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error al crear empresa');

        
        $dto = new EmpresaDTO(
            nit: '123456789',
            nombre: 'Mi Empresa',
            direccion: 'Cra xx',
            telefono: '27237236',
        );

        $this->empresaRepository
            ->shouldReceive('crear')
            ->once()
            ->andThrow(new \Exception('Error al crear empresa'));

        $this->crearEmpresaService->handle($dto);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
