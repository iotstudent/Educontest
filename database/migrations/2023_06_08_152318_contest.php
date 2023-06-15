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
        //

        Schema::create('contest', function (Blueprint $table) {
            $table->id();
            $table->string('contest_name');
            $table->bigInteger('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('gender');
            $table->integer('age_limit');
            $table->string('contest_photo');
            $table->string('category');
            $table->string('contest_description');
            $table->string('sponsor_name');
            $table->string('daily_limit');
            $table->string('number_entries');
            $table->string('login_options');
            $table->string('criteria');
            $table->string('voting_platform');
            $table->string('selection_method');
            $table->string('limits_per_vote');
            $table->string('show_total_votes');
            $table->string('document_to_upload');
            $table->string('document_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
