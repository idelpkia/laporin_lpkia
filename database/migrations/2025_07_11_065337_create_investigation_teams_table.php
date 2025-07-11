<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestigationTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investigation_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investigation_id')->constrained('investigations');
            $table->foreignId('member_id')->constrained('users');
            $table->enum('role', ['leader', 'expert_lecturer', 'student_representative', 'it_expert']);
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
        Schema::dropIfExists('investigation_teams');
    }
}
