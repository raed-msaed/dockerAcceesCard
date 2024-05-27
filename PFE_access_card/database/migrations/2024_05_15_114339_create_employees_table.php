<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('sort')->nullable(); //الصنف عسكري أو مدني
            $table->string('matricule')->nullable(); // رقم التجنيد
            $table->string('armee')->nullable(); // جيش الإنتماء
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete(); // الصنف
            $table->foreignId('grade_id')->nullable()->constrained()->cascadeOnDelete(); // الرتبة
            $table->foreignId('organisation_id')->nullable()->constrained()->cascadeOnDelete(); // مكان العمل

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
