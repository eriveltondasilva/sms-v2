<?php

declare(strict_types=1);

namespace App\Enums;

enum Page: string
{
    // Geral
    case Dashboard = 'Dashboard';

    // Admin — Escolas
    case AdminSchoolsIndex = 'Admin/Schools/Index';
    case AdminSchoolsForm = 'Admin/Schools/Form';
    case AdminSchoolsShow = 'Admin/Schools/Show';

    // Admin — Usuários
    case AdminUsersIndex = 'Admin/Users/Index';
    case AdminUsersForm = 'Admin/Users/Form';

    // Professores
    case TeachersIndex = 'Teachers/Index';
    case TeachersShow = 'Teachers/Show';
    case TeachersForm = 'Teachers/Form';

    // Alunos
    case StudentsIndex = 'Students/Index';
    case StudentsShow = 'Students/Show';
    case StudentsForm = 'Students/Form';

    // Responsáveis
    case GuardiansIndex = 'Guardians/Index';
    case GuardiansForm = 'Guardians/Form';

    // Turmas
    case ClassroomsIndex = 'Classrooms/Index';
    case ClassroomsShow = 'Classrooms/Show';
    case ClassroomsForm = 'Classrooms/Form';

    // Disciplinas
    case SubjectsIndex = 'Subjects/Index';
    case SubjectsForm = 'Subjects/Form';

    // Atribuições de ensino
    case TeachingAssignmentsIndex = 'TeachingAssignments/Index';
    case TeachingAssignmentsForm = 'TeachingAssignments/Form';

    // Horários
    case ClassSchedulesIndex = 'ClassSchedules/Index';
    case ClassSchedulesForm = 'ClassSchedules/Form';

    // Matrículas
    case EnrollmentsIndex = 'Enrollments/Index';
    case EnrollmentsShow = 'Enrollments/Show';
    case EnrollmentsForm = 'Enrollments/Form';

    // Ano letivo
    case SchoolYearsIndex = 'SchoolYears/Index';
    case SchoolYearsForm = 'SchoolYears/Form';

    // Períodos acadêmicos
    case AcademicPeriodsIndex = 'AcademicPeriods/Index';
    case AcademicPeriodsForm = 'AcademicPeriods/Form';

    // Aulas
    case LessonsIndex = 'Lessons/Index';
    case LessonsShow = 'Lessons/Show';
    case LessonsForm = 'Lessons/Form';

    // Diário
    case LessonRecordsForm = 'LessonRecords/Form';

    // Planos de aula
    case LessonPlansIndex = 'LessonPlans/Index';
    case LessonPlansForm = 'LessonPlans/Form';

    // Frequência
    case AttendanceRecord = 'Attendance/Record';

    // Templates de avaliação
    case AssessmentTemplatesIndex = 'AssessmentTemplates/Index';
    case AssessmentTemplatesForm = 'AssessmentTemplates/Form';

    // Avaliações
    case AssessmentsIndex = 'Assessments/Index';
    case AssessmentsForm = 'Assessments/Form';

    // Notas
    case GradesIndex = 'Grades/Index';

    // Resultados por período
    case PeriodResultsShow = 'PeriodResults/Show';

    // Eventos escolares
    case SchoolEventsIndex = 'SchoolEvents/Index';
    case SchoolEventsForm = 'SchoolEvents/Form';

    // Relatórios
    case ReportsIndex = 'Reports/Index';
    case ReportsShow = 'Reports/Show';

    // Configurações
    case Settings = 'Settings';
}
