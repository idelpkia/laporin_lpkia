<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports');
            $table->foreignId('appellant_id')->constrained('users');
            $table->text('appeal_reason')->nullable();
            $table->date('appeal_date')->nullable();
            $table->enum('appeal_status', ['submitted', 'under_review', 'approved', 'rejected']);
            $table->text('review_result')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->date('review_date')->nullable();
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
        Schema::dropIfExists('appeals');
    }
}
