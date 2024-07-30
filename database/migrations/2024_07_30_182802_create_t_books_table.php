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
        Schema::create('t_books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('borrow_date')->nullable();
            $table->date('return_date')->nullable();
            $table->foreignUuid('m_member_id')->nullable();
            $table->foreignUuid('m_book_id')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('t_books');
    }
};
