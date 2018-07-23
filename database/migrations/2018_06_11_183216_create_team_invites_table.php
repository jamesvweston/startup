<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_invites', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email', 100)->index();
            $table->string('role');

            $table->unsignedInteger('account_id')->index();
            $table->unsignedInteger('created_by_id')->index();

            $table->timestamp('joined_at')->nullable()->default(null)->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->index();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('created_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_invites');
    }
}
