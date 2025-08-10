<?php namespace App\Entities\Interfaces;

interface PersonInterface
{
    public function setName(string $name): void;
    public function getName(): string;
    public function setId(string $id): void;
    public function getId(): string;
}