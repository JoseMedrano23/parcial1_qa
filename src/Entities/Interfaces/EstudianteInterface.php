<?php namespace App\Entities\Interfaces;

interface EstudianteInterface extends PersonInterface
{
    public function setGrade(string $grade): void;
    public function getGrade(): string;
}
