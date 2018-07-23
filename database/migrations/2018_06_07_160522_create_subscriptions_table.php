<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_id')->index();
            $table->unsignedInteger('plan_id')->index();
            $table->string('stripe_id');
            $table->integer('quantity');

            $table->timestamp('trial_ends_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable()->index();
            $table->timestamp('cancelled_at')->nullable()->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->index();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
