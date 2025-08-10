<?php namespace App\Entities\Interfaces;

interface InscripcionInterface
{
    public function setId(string $id): void;
    public function getId(): string;
    public function setStudent(EstudianteInterface $student): void;
    public function getStudent(): EstudianteInterface;
    public function setTeacher(DocenteInterface $teacher): void;
    public function getTeacher(): DocenteInterface;
}