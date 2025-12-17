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
        Schema::create('mail_setting', function (Blueprint $table) {
            $table->id();
            $table->string('smtp_host');
            $table->string('smtp_port', 6);
            $table->string('mail_from');
            $table->string('mail_password');
            $table->string('mail_to');
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
        Schema::dropIfExists('mail_setting');
    }
};
