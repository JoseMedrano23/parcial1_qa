<?php namespace App\Entities\Interfaces;

interface DocenteRepositoryInterface
{
    public function save(DocenteInterface $docente): DocenteInterface;
    public function getById(string $id): ?DocenteInterface;
    public function getBySubject(string $subject): array;
    public function getByDepartment(string $department): array;
    public function update(DocenteInterface $docente): void;
    public function delete(DocenteInterface $docente): void;
    public function getAll(): array;
}