<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new fields to mahasiswa_profiles
        Schema::table('mahasiswa_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa_profiles', 'semester')) {
                $table->unsignedTinyInteger('semester')->nullable()->after('student_id');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'city')) {
                $table->string('city', 100)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'skills')) {
                $table->string('skills', 500)->nullable()->after('city');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'interest_fields')) {
                $table->string('interest_fields', 500)->nullable()->after('skills');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'organization_experience')) {
                $table->text('organization_experience')->nullable()->after('interest_fields');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'project_experience')) {
                $table->text('project_experience')->nullable()->after('organization_experience');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'work_experience')) {
                $table->text('work_experience')->nullable()->after('project_experience');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'certificates')) {
                $table->text('certificates')->nullable()->after('work_experience');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'instagram_url')) {
                $table->string('instagram_url', 255)->nullable()->after('portfolio_url');
            }
            if (!Schema::hasColumn('mahasiswa_profiles', 'cv_path')) {
                $table->string('cv_path', 255)->nullable()->after('instagram_url');
            }
        });

        // Add submission_link to mission_progresses
        Schema::table('mission_progresses', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_progresses', 'submission_link')) {
                $table->string('submission_link', 500)->nullable()->after('progress_note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa_profiles', function (Blueprint $table) {
            $table->dropColumnIfExists(['semester', 'city', 'skills', 'interest_fields',
                'organization_experience', 'project_experience', 'work_experience',
                'certificates', 'instagram_url', 'cv_path']);
        });
        Schema::table('mission_progresses', function (Blueprint $table) {
            $table->dropColumnIfExists('submission_link');
        });
    }
};
