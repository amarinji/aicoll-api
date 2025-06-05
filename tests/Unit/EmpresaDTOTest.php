<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Application\DTOs\EmpresaDTO;
use InvalidArgumentException;

class EmpresaDTOTest extends TestCase
{
    public function test_crea_empresa_dto_correctamente()
    {
        $dto = new EmpresaDTO('123456789', 'Mi Empresa', 'Cra xx', '272327666');

        $this->assertEquals('123456789', $dto->nit);
        $this->assertEquals('Mi Empresa', $dto->nombre);
        $this->assertEquals('Cra xx', $dto->getDireccion());
        $this->assertEquals('272327666', $dto->getTelefono());

        $this->assertIsString($dto->nit);
        $this->assertIsString($dto->nombre);
    }

    public function test_error_si_falta_nit()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("El NIT debe ser un número válido.");

        new EmpresaDTO('', 'Empresa Demo', 'Calle 123', '(123) 456-7890');
    }

    public function test_error_si_falta_nombre()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("El nombre es obligatorio.");

        new EmpresaDTO('123456789', '', 'Calle 123', '(123) 456-7890');
    }

}
