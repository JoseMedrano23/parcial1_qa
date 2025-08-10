<?php namespace App\Entities;

use App\Entities\Interfaces\DocenteInterface;

class DocenteEntity extends PersonaEntity implements DocenteInterface
{
    private string $subject;
    private string $department;

    public function __construct(string $id, string $name, string $email, string $subject, string $department)
    {
        parent::__construct($id, $name, $email);
        $this->subject = $subject;
        $this->department = $department;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    public function getRole(): string
    {
        return "Docente";
    }

    public function getDetails(): string
    {
        return "{$this->name} - {$this->subject} ({$this->department})";
    }
}