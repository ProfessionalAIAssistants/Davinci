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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('active_until')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('plan_id')->unsigned();
            $table->string('status')->nullable();
            $table->string('gateway')->nullable();
            $table->string('plan_name')->nullable();
            $table->text('model')->nullable();
            $table->string('frequency')->nullable();
            $table->string('subscription_id');            
            $table->integer('images')->nullable()->default(0);
            $table->integer('characters')->nullable()->default(0);
            $table->integer('minutes')->nullable()->default(0);
            $table->integer('max_tokens')->nullable();
            $table->string('paystack_customer_code')->nullable();
            $table->string('paystack_authorization_code')->nullable();
            $table->string('paystack_email_token')->nullable();
            $table->string('paddle_cancel_url')->nullable();            
            $table->integer('tokens')->nullable()->default(0);
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
        Schema::dropIfExists('subscribers');
    }
};
