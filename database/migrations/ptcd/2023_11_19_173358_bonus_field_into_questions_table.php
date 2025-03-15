<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            //
            $table->double('version', 10, 1)->default(1.0)->after('rank');
            $table->boolean('is_current_version')->default(true)->after('version');
            $table->unsignedBigInteger('base_id')->nullable()->after('is_current_version');
            $table->foreignId('created_by')->nullable()->after('base_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            //
            $table->dropColumn([
                'version',
                'is_current_version',
                'base_id',
                'created_by',
            ]);
        });
    }
};
