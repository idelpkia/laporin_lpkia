<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenaltiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports');
            $table->foreignId('penalty_level_id')->constrained('penalty_levels');
            $table->string('penalty_type');
            $table->text('description')->nullable();
            $table->date('recommendation_date')->nullable();
            $table->foreignId('decided_by')->constrained('users');
            $table->string('sk_number')->nullable();
            $table->date('sk_date')->nullable();
            $table->enum('status', ['recommended', 'approved', 'executed']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penalties');
    }
}
