<?php namespace App\Entities\Interfaces;

interface DocenteInterface extends PersonInterface
{
    public function setSubject(string $subject): void;
    public function getSubject(): string;
}