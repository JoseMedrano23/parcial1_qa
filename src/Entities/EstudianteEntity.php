<?php namespace App\Entities;

use App\Entities\Interfaces\EstudianteInterface;
use DateTime;

class EstudianteEntity extends PersonaEntity implements EstudianteInterface
{
    private string $grade;
    private DateTime $enrollmentDate;

    public function __construct(string $id, string $name, string $email, string $grade)
    {
        parent::__construct($id, $name, $email);
        $this->grade = $grade;
        $this->enrollmentDate = new DateTime();
    }

    public function setGrade(string $grade): void
    {
        $this->grade = $grade;
    }

    public function getGrade(): string
    {
        return $this->grade;
    }

    public function getEnrollmentDate(): DateTime
    {
        return $this->enrollmentDate;
    }

    public function setEnrollmentDate(DateTime $date): void
    {
        $this->enrollmentDate = $date;
    }

    public function getRole(): string
    {
        return "Estudiante";
    }

    public function getDetails(): string
    {
        return "{$this->name} - Grado: {$this->grade}";
    }
}