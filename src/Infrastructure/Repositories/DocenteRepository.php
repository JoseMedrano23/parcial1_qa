<?php namespace App\Infrastructure\Repositories;

use App\Entities\Interfaces\DocenteRepositoryInterface;
use App\Entities\Interfaces\DocenteInterface;
use Exception;

class DocenteRepository implements DocenteRepositoryInterface
{
    private array $docentes = [];

    public function save(DocenteInterface $docente): DocenteInterface
    {
        $existingDocente = $this->getById($docente->getId());
        if ($existingDocente) {
            throw new Exception("Ya existe un docente con el ID: " . $docente->getId());
        }
        
        $this->docentes[] = $docente;
        return $docente;
    }

    public function getById(string $id): ?DocenteInterface
    {
        foreach ($this->docentes as $docente) {
            if ($docente->getId() === $id) {
                return $docente;
            }
        }
        return null;
    }

    public function getBySubject(string $subject): array
    {
        return array_filter($this->docentes, function($docente) use ($subject) {
            return stripos($docente->getSubject(), $subject) !== false;
        });
    }

    public function getByDepartment(string $department): array
    {
        return array_filter($this->docentes, function($docente) use ($department) {
            if (method_exists($docente, 'getDepartment')) {
                return stripos($docente->getDepartment(), $department) !== false;
            }
            return false;
        });
    }

    public function update(DocenteInterface $docente): void
    {
        foreach ($this->docentes as $index => $existingDocente) {
            if ($existingDocente->getId() === $docente->getId()) {
                $this->docentes[$index] = $docente;
                return;
            }
        }
        throw new Exception("No se encontró el docente con ID: " . $docente->getId());
    }

    public function delete(DocenteInterface $docente): void
    {
        foreach ($this->docentes as $index => $existingDocente) {
            if ($existingDocente->getId() === $docente->getId()) {
                array_splice($this->docentes, $index, 1);
                return;
            }
        }
        throw new Exception("No se encontró el docente con ID: " . $docente->getId());
    }

    public function getAll(): array
    {
        return $this->docentes;
    }

    public function countByDepartment(): array
    {
        $departmentCount = [];
        
        foreach ($this->docentes as $docente) {
            if (method_exists($docente, 'getDepartment')) {
                $department = $docente->getDepartment();
                $departmentCount[$department] = ($departmentCount[$department] ?? 0) + 1;
            }
        }
        
        return $departmentCount;
    }

    public function searchByName(string $name): array
    {
        return array_filter($this->docentes, function($docente) use ($name) {
            return stripos($docente->getName(), $name) !== false;
        });
    }
}