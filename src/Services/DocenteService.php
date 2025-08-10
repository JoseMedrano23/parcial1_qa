<?php namespace App\Services;

use App\Entities\Interfaces\DocenteRepositoryInterface;
use App\Entities\Interfaces\DocenteInterface;
use App\Entities\DocenteEntity;
use Exception;

class DocenteService
{
    private DocenteRepositoryInterface $repository;

    public function __construct(DocenteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function registrarDocente(
        string $id,
        string $name,
        string $email,
        string $subject,
        string $department
    ): DocenteInterface {
        $this->validateDocenteData($id, $name, $email, $subject, $department);
        
        $existingDocentes = $this->repository->getAll();
        foreach ($existingDocentes as $docente) {
            if (method_exists($docente, 'getEmail') && $docente->getEmail() === $email) {
                throw new Exception("Ya existe un docente con el email: $email");
            }
        }

        $docente = new DocenteEntity($id, $name, $email, $subject, $department);
        return $this->repository->save($docente);
    }

    public function obtenerDocentePorId(string $id): ?DocenteInterface
    {
        return $this->repository->getById($id);
    }

    public function obtenerDocentesPorMateria(string $subject): array
    {
        if (empty(trim($subject))) {
            throw new Exception("La materia no puede estar vacía");
        }
        return $this->repository->getBySubject($subject);
    }

    public function obtenerDocentesPorDepartamento(string $department): array
    {
        if (empty(trim($department))) {
            throw new Exception("El departamento no puede estar vacío");
        }
        return $this->repository->getByDepartment($department);
    }

    public function actualizarDocente(DocenteInterface $docente): void
    {
        $existingDocente = $this->repository->getById($docente->getId());
        if (!$existingDocente) {
            throw new Exception("No se encontró el docente con ID: " . $docente->getId());
        }

        $this->repository->update($docente);
    }

    public function eliminarDocente(string $id): void
    {
        $docente = $this->repository->getById($id);
        if (!$docente) {
            throw new Exception("No se encontró el docente con ID: $id");
        }

        $this->repository->delete($docente);
    }

    public function listarTodosLosDocentes(): array
    {
        return $this->repository->getAll();
    }

    public function buscarDocentesPorNombre(string $name): array
    {
        if (empty(trim($name))) {
            throw new Exception("El nombre no puede estar vacío");
        }

        if (method_exists($this->repository, 'searchByName')) {
            return $this->repository->searchByName($name);
        }

        return array_filter($this->repository->getAll(), function($docente) use ($name) {
            return stripos($docente->getName(), $name) !== false;
        });
    }

    public function obtenerEstadisticasPorDepartamento(): array
    {
        if (method_exists($this->repository, 'countByDepartment')) {
            return $this->repository->countByDepartment();
        }

        $departmentCount = [];
        $docentes = $this->repository->getAll();
        
        foreach ($docentes as $docente) {
            if (method_exists($docente, 'getDepartment')) {
                $department = $docente->getDepartment();
                $departmentCount[$department] = ($departmentCount[$department] ?? 0) + 1;
            }
        }
        
        return $departmentCount;
    }

    public function cambiarMateria(string $docenteId, string $nuevaMateria): void
    {
        $docente = $this->repository->getById($docenteId);
        if (!$docente) {
            throw new Exception("No se encontró el docente con ID: $docenteId");
        }

        if (empty(trim($nuevaMateria))) {
            throw new Exception("La nueva materia no puede estar vacía");
        }

        $docente->setSubject($nuevaMateria);
        $this->repository->update($docente);
    }

    private function validateDocenteData(
        string $id,
        string $name,
        string $email,
        string $subject,
        string $department
    ): void {
        if (empty(trim($id))) {
            throw new Exception("El ID del docente es requerido");
        }

        if (empty(trim($name))) {
            throw new Exception("El nombre del docente es requerido");
        }

        if (empty(trim($email))) {
            throw new Exception("El email del docente es requerido");
        }

        if (!$this->isValidEmail($email)) {
            throw new Exception("El formato del email no es válido");
        }

        if (empty(trim($subject))) {
            throw new Exception("La materia del docente es requerida");
        }

        if (empty(trim($department))) {
            throw new Exception("El departamento del docente es requerido");
        }
    }

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}