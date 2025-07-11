<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestigationToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investigation_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investigation_id')->constrained('investigations');
            $table->enum('tool_name', ['turnitin', 'grammarly', 'codequiry', 'jplag', 'lms_audit', 'git_audit']);
            $table->string('result_file_path')->nullable();
            $table->float('result_percentage')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('investigation_tools');
    }
}
