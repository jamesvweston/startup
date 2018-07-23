<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last4', 4);
            $table->string('exp_month', 2);
            $table->smallInteger('exp_year')->unsigned();
            $table->string('brand', 100);
            $table->string('funding', 100);

            $table->boolean('is_default')->default(FALSE);
            $table->string('address_zip', 20);

            $table->tinyInteger('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('accounts');

            $table->string('stripe_id', 100)->unique();

            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
