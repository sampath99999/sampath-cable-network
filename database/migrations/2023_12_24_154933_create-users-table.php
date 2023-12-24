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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("username");
            $table->string("password");
            $table->string("email")->nullable();
            $table->string("phone");
            $table->unsignedBigInteger("role_id");
            $table->unsignedBigInteger("network_id");
            $table->boolean("status")->default(false);
            $table->timestamps();
        });

        Schema::table('users', function ($table) {
            $table->foreign('role_id')->references('id')->on('user_roles');
            $table->foreign('network_id')->references('id')->on('networks');
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
