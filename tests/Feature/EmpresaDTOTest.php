<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Application\DTOs\EmpresaDTO;
use InvalidArgumentException;

class EmpresaDTOTest extends TestCase
{
    public function test_crea_empresa_dto_correctamente()
    {
        $data = [
            'nit' => '123456789',
            'nombre' => 'Empresa Demo',
            'direccion' => 'Calle 123',
            'telefono' => '(123) 456-7890'
        ];

        $dto = new EmpresaDTO($data);

        $this->assertEquals('123456789', $dto->nit);
        $this->assertEquals('Empresa Demo', $dto->nombre);
        $this->assertEquals('Calle 123', $dto->getDireccion());
        $this->assertEquals('(123) 456-7890', $dto->getTelefono());
        $this->assertEquals('1234567890', $dto->telefonoFormateado());

        $this->assertIsString($dto->nit);
        $this->assertIsString($dto->nombre);
    }

    public function test_error_si_falta_nit()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("El NIT debe ser un número válido.");

        new EmpresaDTO(['nombre' => 'Empresa Demo']);
    }

    public function test_error_si_falta_nombre()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("El nombre es obligatorio.");

        new EmpresaDTO(['nit' => '123456789']);
    }
}
