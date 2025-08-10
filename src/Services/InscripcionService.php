<?php namespace App\Services;

use App\Entities\Interfaces\InscripcionRepositoryInterface;
use App\Entities\Interfaces\InscripcionInterface;
use App\Entities\Interfaces\EstudianteInterface;
use App\Entities\Interfaces\DocenteInterface;
use App\Entities\InscripcionEntity;
use Exception;

class InscripcionService
{
    private InscripcionRepositoryInterface $repository;

    public function __construct(InscripcionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function inscribirEstudiante(EstudianteInterface $student, DocenteInterface $teacher): InscripcionInterface
    {
        $existingInscripciones = $this->repository->getByStudent($student->getId());
        
        foreach ($existingInscripciones as $inscripcion) {
            if ($inscripcion->getTeacher()->getId() === $teacher->getId()) {
                throw new Exception("El estudiante {$student->getName()} ya está inscrito con el docente {$teacher->getName()}");
            }
        }

        // Crear nueva inscripción
        $id = 'INS-' . time() . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 9);
        $inscripcion = new InscripcionEntity($id, $student, $teacher);
        
        return $this->repository->save($inscripcion);
    }

    public function obtenerInscripcionesPorEstudiante(string $studentId): array
    {
        return $this->repository->getByStudent($studentId);
    }

    public function obtenerInscripcionesPorDocente(string $teacherId): array
    {
        return $this->repository->getByTeacher($teacherId);
    }

    public function cancelarInscripcion(string $inscripcionId): void
    {
        $inscripcion = null;
        foreach ($this->repository->getAll() as $i) {
            if ($i->getId() === $inscripcionId) {
                $inscripcion = $i;
                break;
            }
        }
        
        if ($inscripcion) {
            $this->repository->delete($inscripcion);
        } else {
            throw new Exception("No se encontró la inscripción con ID: $inscripcionId");
        }
    }
}

?>