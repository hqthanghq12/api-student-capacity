<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_request_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_request_note_id');
            $table->foreignId('student_poetry_id');
            $table->text('note')->nullable();
            $table->foreignId('confirmed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_request_details');
    }
};
