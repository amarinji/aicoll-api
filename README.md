# AICOLL - Desafío Técnico PHP (Laravel)

Este proyecto fue desarrollado como solución al desafío técnico propuesto por **AICOLL**, utilizando **Laravel** y una arquitectura basada en principios de **hexagonal/clean architecture**.

## 🧩 Descripción del problema

Se requiere gestionar la información de empresas mediante Web Services (API REST), permitiendo:
- Crear empresas
- Consultar todas las empresas o por NIT
- Actualizar datos
- Eliminar empresas con estado "inactivo"

## 🚀 Tecnologías utilizadas

- PHP 8.1+
- Laravel 10
- MySQL o SQLite (configurable)
- PHPUnit
- Composer
- Arquitectura Hexagonal

## 🗂️ Estructura del proyecto (Hexagonal)

```
app/
├── Application/
│   ├── DTOs/
│   └── UseCases/
├── Domain/
│   ├── Entities/
│   └── Repositories/
├── Infrastructure/
│   └── Persistence/
├── Interfaces/
│   └── Http/
│       ├── Controllers/
│       └── Requests/
tests/
├── Feature/
└── Unit/
```

## 📦 Instalación y ejecución

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/aicoll-api.git
cd aicoll-api
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar archivo `.env`

```bash
cp .env.example .env
```

Edita el archivo `.env` y configura tu base de datos. Puedes usar SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=${PATH_ABSOLUTO}/database/database.sqlite
```

Luego crea el archivo SQLite vacío:

```bash
touch database/database.sqlite
```

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Ejecutar migraciones

```bash
php artisan migrate
```

### 6. Iniciar servidor local

```bash
php artisan serve
```

## 🧪 Ejecutar pruebas

```bash
php artisan test
```

O directamente con PHPUnit:

```bash
vendor/bin/phpunit
```

Incluye:
- ✅ Tests unitarios para DTOs y servicios (con mocks)
- ✅ Tests de integración para endpoints reales

## 📌 Endpoints principales

| Método | Ruta                  | Descripción                             |
|--------|-----------------------|-----------------------------------------|
| POST   | /api/empresas         | Crear empresa                           |
| GET    | /api/empresas         | Listar todas                            |
| GET    | /api/empresas/{nit}   | Buscar por NIT                          |
| PUT    | /api/empresas/{nit}   | Actualizar empresa                      |
| DELETE | /api/empresas/inactivas | Eliminar empresas con estado inactivo |

## ✅ Requisitos cumplidos

| Requisito                             | Estado     |
|--------------------------------------|------------|
| Crear, listar, buscar, actualizar, eliminar empresas | ✅ Cumplido |
| Validaciones de entrada y NIT único  | ✅ Cumplido |
| Estado activo por defecto al crear   | ✅ Cumplido |
| Excepciones personalizadas           | ✅ Implementadas |
| Arquitectura y diseño limpio         | ✅ Hexagonal |
| Pruebas unitarias y de integración   | ✅ Implementadas |
| Proyecto público en GitHub           | ✅ Sí |

## 📬 Contacto

Desarrollado por [Alejandro Marin Jimenez]  
Correo: [amarinji98@gmail.com]  
GitHub: [https://github.com/amarinji]
