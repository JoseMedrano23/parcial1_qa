<?php namespace App\Infrastructure\Repositories;

use App\Entities\Interfaces\InscripcionRepositoryInterface;
use App\Entities\Interfaces\InscripcionInterface;

class InscripcionRepository implements InscripcionRepositoryInterface
{
    private array $inscripciones = [];

    public function save(InscripcionInterface $inscripcion): InscripcionInterface
    {
        $this->inscripciones[] = $inscripcion;
        return $inscripcion;
    }

    public function getByStudent(string $studentId): array
    {
        return array_filter($this->inscripciones, function($inscripcion) use ($studentId) {
            return $inscripcion->getStudent()->getId() === $studentId;
        });
    }

    public function getByTeacher(string $teacherId): array
    {
        return array_filter($this->inscripciones, function($inscripcion) use ($teacherId) {
            return $inscripcion->getTeacher()->getId() === $teacherId;
        });
    }

    public function delete(InscripcionInterface $inscripcion): void
    {
        foreach ($this->inscripciones as $index => $existingInscripcion) {
            if ($existingInscripcion->getId() === $inscripcion->getId()) {
                array_splice($this->inscripciones, $index, 1);
                return;
            }
        }
    }

    public function getAll(): array
    {
        return $this->inscripciones;
    }
}