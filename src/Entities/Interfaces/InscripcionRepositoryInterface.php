<?php namespace App\Entities\Interfaces;

interface InscripcionRepositoryInterface
{
    public function save(InscripcionInterface $inscripcion): InscripcionInterface;
    public function getByStudent(string $studentId): array;
    public function getByTeacher(string $teacherId): array;
    public function delete(InscripcionInterface $inscripcion): void;
    public function getAll(): array;
}