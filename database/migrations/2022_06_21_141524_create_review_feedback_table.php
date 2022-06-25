<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_request_id')->references('id')->on('review_requests')->constrained();
            $table->text('feedback');
            $table->unsignedInteger('rating')->default(0);
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
        Schema::dropIfExists('review_feedback');
    }
}