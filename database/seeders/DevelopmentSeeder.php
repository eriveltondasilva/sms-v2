<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AnnualFormulaType;
use App\Enums\ClassroomShift;
use App\Enums\GradeLevelCode;
use App\Enums\PeriodFormulaType;
use App\Enums\ProgressStatus;
use App\Enums\RecoveryMethod;
use App\Enums\Role as RoleEnum;
use App\Enums\RoundingMode;
use App\Models\AcademicPeriod;
use App\Models\Classroom;
use App\Models\ClassSchedule;
use App\Models\GradeLevel;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingAssignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
{
    private School $school;

    private SchoolYear $schoolYear;

    private Classroom $classroomEf1;

    private Classroom $classroomEf2;

    /** @var Collection<int, Teacher> */
    private Collection $teachers;

    public function run(): void
    {
        $this->createSchool();
        $this->createAdmin();
        $this->createTeachers();
        $this->createSchoolYear();
        $this->createAcademicPeriods();
        $this->createClassrooms();
        $this->createSubjectsWithAssignments();
    }

    private function createSchool(): void
    {
        $this->school = School::factory()->create([
            'full_name'  => 'Escola Municipal Exemplo',
            'short_name' => 'EME',
            'slug'       => 'eme',
        ]);
    }

    private function createAdmin(): void
    {
        $admin = User::factory()->create([
            'name'     => 'Admin Teste',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole(RoleEnum::Admin->value);
        $admin->schools()->attach($this->school->id, ['is_active' => true]);
    }

    private function createTeachers(): void
    {
        $this->teachers = Teacher::factory(3)->create();

        foreach ($this->teachers as $teacher) {
            $teacher->schools()->attach($this->school->id, [
                'is_active' => true,
                'hire_date' => now()->subMonths(6)->toDateString(),
            ]);
        }
    }

    private function createSchoolYear(): void
    {
        $this->schoolYear = SchoolYear::factory()->create([
            'school_id' => $this->school->id,

            'year' => now()->year,

            'status' => ProgressStatus::InProgress,

            'period_formula_type' => PeriodFormulaType::WeightedAvg,
            'annual_formula_type' => AnnualFormulaType::Sum,

            'period_recovery_method' => RecoveryMethod::BestScore,
            'annual_recovery_method' => RecoveryMethod::BestScore,

            'rounding_mode'        => RoundingMode::HalfUp,
            'grade_decimal_places' => 1,

            'start_date' => now()->startOfYear(),
            'end_date'   => now()->endOfYear(),

            'min_attendance_percentage' => 75.00,
            'min_passing_score'         => 24.00,
            'min_period_score'          => 6.00,

            'allows_final_exam' => true,
        ]);
    }

    private function createAcademicPeriods(): void
    {
        for ($i = 1; $i <= 4; $i++) {
            AcademicPeriod::factory()->create([
                'school_year_id' => $this->schoolYear->id,

                'name'  => "{$i}º Bimestre",
                'order' => $i,

                'status' => $i === 1 ? ProgressStatus::InProgress : ProgressStatus::Planned,

                'start_date' => now()->startOfYear()->addMonths(($i - 1) * 3),
                'end_date'   => now()->startOfYear()->addMonths($i * 3)->subDay(),
            ]);
        }
    }

    private function createClassrooms(): void
    {
        $ef1 = GradeLevel::query()->where('code', GradeLevelCode::EF_1A)->firstOrFail();
        $ef2 = GradeLevel::query()->where('code', GradeLevelCode::EF_6A)->firstOrFail();

        $this->classroomEf1 = Classroom::factory()->create([
            'school_id'      => $this->school->id,
            'school_year_id' => $this->schoolYear->id,
            'grade_level_id' => $ef1->id,

            'name'        => '1A',
            'shift'       => ClassroomShift::Morning,
            'student_max' => 30,

            'is_active' => true,
        ]);

        $this->classroomEf2 = Classroom::factory()->create([
            'school_id'      => $this->school->id,
            'school_year_id' => $this->schoolYear->id,
            'grade_level_id' => $ef2->id,

            'name'        => '6A',
            'shift'       => ClassroomShift::Afternoon,
            'student_max' => 30,

            'is_active' => true,
        ]);
    }

    private function createSubjectsWithAssignments(): void
    {
        $subjects = [
            ['name' => 'Matemática', 'code' => 'MAT', 'week_hours' => 5],
            ['name' => 'Português',  'code' => 'POR', 'week_hours' => 5],
            ['name' => 'Ciências',   'code' => 'CIE', 'week_hours' => 3],
        ];

        foreach ($subjects as $index => $subjectData) {
            $subject = Subject::factory()->create([
                ...$subjectData,
                'school_id' => $this->school->id,
                'is_active' => true,
            ]);

            $teacher = $this->teachers[$index % 3];

            foreach ([$this->classroomEf1, $this->classroomEf2] as $classroom) {
                $assignment = $this->createTeachingAssignment($classroom, $subject, $teacher);
                $this->createClassSchedules($assignment);
            }
        }
    }

    private function createTeachingAssignment(
        Classroom $classroom,
        Subject $subject,
        Teacher $teacher,
    ): TeachingAssignment {
        return TeachingAssignment::factory()->create([
            'classroom_id' => $classroom->id,
            'subject_id'   => $subject->id,
            'teacher_id'   => $teacher->id,
            'school_id'    => $this->school->id,
            'is_active'    => true,
            'start_date'   => $this->schoolYear->start_date,
        ]);
    }

    private function createClassSchedules(TeachingAssignment $assignment): void
    {
        foreach ([1, 3] as $weekday) {
            ClassSchedule::factory()->create([
                'teaching_assignment_id' => $assignment->id,
                'school_id'              => $this->school->id,
                'weekday'                => $weekday,
                'start_time'             => '08:00:00',
                'valid_from'             => $this->schoolYear->start_date,
            ]);
        }
    }
}
