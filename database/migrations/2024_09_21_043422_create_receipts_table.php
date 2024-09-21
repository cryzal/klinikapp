<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id(); // ID primary key auto increment
            $table->unsignedBigInteger('examination_id'); // Foreign key to examinations table
            $table->string('medicine_id'); // Medicine ID as varchar
            $table->integer('qty'); // Quantity as int
            $table->string('dosage'); // Dosage as string
            $table->timestamps();

            // Add foreign key constraint to examination_id
            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}