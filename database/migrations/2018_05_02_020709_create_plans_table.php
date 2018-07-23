<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount')->unsigned()->index();
            $table->string('currency', 3);
            $table->string('stripe_id', 100)->unique();
            $table->string('nickname')->nullable()->default(null);
            $table->string('stripe_product_id', 100)->index();
            $table->string('billing_scheme')->nullable()->default(null);
            $table->string('interval')->nullable()->default(null);
            $table->integer('interval_count')->unsigned()->index()->nullable()->default(null);
            $table->string('usage_type')->nullable()->default(null);
            $table->boolean('is_active')->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
