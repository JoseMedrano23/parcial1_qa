<?php namespace App\Entities;

use App\Entities\Interfaces\InscripcionInterface;
use App\Entities\Interfaces\EstudianteInterface;
use App\Entities\Interfaces\DocenteInterface;
use DateTime;

class InscripcionEntity implements InscripcionInterface
{
    private string $id;
    private EstudianteInterface $student;
    private DocenteInterface $teacher;
    private DateTime $enrollmentDate;
    private string $status;

    public function __construct(string $id, EstudianteInterface $student, DocenteInterface $teacher)
    {
        $this->id = $id;
        $this->student = $student;
        $this->teacher = $teacher;
        $this->enrollmentDate = new DateTime();
        $this->status = "Activa";
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setStudent(EstudianteInterface $student): void
    {
        $this->student = $student;
    }

    public function getStudent(): EstudianteInterface
    {
        return $this->student;
    }

    public function setTeacher(DocenteInterface $teacher): void
    {
        $this->teacher = $teacher;
    }

    public function getTeacher(): DocenteInterface
    {
        return $this->teacher;
    }

    public function getEnrollmentDate(): DateTime
    {
        return $this->enrollmentDate;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
