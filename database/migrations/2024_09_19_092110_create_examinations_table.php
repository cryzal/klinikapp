<?php

// database/migrations/timestamp_create_examinations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminationsTable extends Migration
{
    public function up()
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('patient_name');
            $table->dateTime('examination_time');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->integer('systole')->nullable();
            $table->integer('diastole')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('respiration_rate')->nullable();
            $table->float('temperature')->nullable();
            $table->text('notes')->nullable();
            $table->string('file')->nullable();
            $table->tinyInteger('status')->default(0); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examinations');
    }
}
