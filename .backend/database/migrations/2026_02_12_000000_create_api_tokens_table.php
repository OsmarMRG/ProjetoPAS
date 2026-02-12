<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('token', 128)->index();
            $table->timestamp('created_at')->nullable();

            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_tokens');
    }
};
