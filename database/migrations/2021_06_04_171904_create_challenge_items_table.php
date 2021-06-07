<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_items', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('name');
            $table->string('address');
            $table->boolean('checked');
            $table->text('description');
            $table->dateTime('date_of_birth')->nullable();
            $table->string('interest')->nullable();
            $table->string('email');
            $table->string('account');
            $table->string('credit_card_type');
            $table->string('credit_card_number');
            $table->string('credit_card_name');
            $table->string('credit_card_expiration_date');
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
        Schema::dropIfExists('challenge_items');
    }
}
