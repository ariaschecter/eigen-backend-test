<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('m_books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->nullable();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->integer('stock')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('m_books');
    }
};
