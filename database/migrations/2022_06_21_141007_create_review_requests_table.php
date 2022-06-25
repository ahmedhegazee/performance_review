<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')->references('id')->on('users')->constrained();
            $table->foreignId('reviewed_id')->references('id')->on('users')->constrained();
            $table->boolean('is_done')->default(false);
            $table->foreignId('created_by')->references('id')->on('users')->constrained();
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
        Schema::dropIfExists('review_requests');
    }
}