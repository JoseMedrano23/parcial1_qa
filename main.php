<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\Repositories\DocenteRepository;
use App\Infrastructure\Repositories\InscripcionRepository;
use App\Services\DocenteService;
use App\Services\InscripcionService;
use App\Entities\EstudianteEntity;

try {
    echo "=== Sistema de Inscripciones ===\n";
     $docenteRepository = new DocenteRepository();
    $inscripcionRepository = new InscripcionRepository();
    $docenteService = new DocenteService($docenteRepository);
    $inscripcionService = new InscripcionService($inscripcionRepository);

    
    // Registrar un docente
    $docente = $docenteService->registrarDocente(
        'DOC001',
        'Juan Pérez',
        'juan.perez@universidad.edu',
        'Matemáticas',
        'Ciencias Exactas'
    );
    
    echo "✅ Docente registrado: " . $docente->getDetails() . "\n";
    
    // Crear un estudiante
    $estudiante = new EstudianteEntity('EST001', 'María García', 'maria.garcia@estudiante.edu', 'Segundo Año');
    
    // Inscribir estudiante
    $inscripcion = $inscripcionService->inscribirEstudiante($estudiante, $docente);
    
    echo "✅ Inscripción creada: " . $inscripcion->getId() . "\n";
    echo "   Estudiante: " . $inscripcion->getStudent()->getName() . "\n";
    echo "   Docente: " . $inscripcion->getTeacher()->getName() . "\n";
    
    // Listar todos los docentes
    $docentes = $docenteService->listarTodosLosDocentes();
    echo "📊 Total de docentes: " . count($docentes) . "\n";
    
    // Buscar por materia
    $docentesMatematicas = $docenteService->obtenerDocentesPorMateria('Matemáticas');
    echo "🔍 Docentes de Matemáticas: " . count($docentesMatematicas) . "\n";
    
    echo "\n🎉 ¡Sistema funcionando correctamente!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}