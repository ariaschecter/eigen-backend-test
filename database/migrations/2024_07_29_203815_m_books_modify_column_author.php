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
        Schema::table('m_books', function (Blueprint $table) {
            $table->dropColumn('author');
            $table->foreignUuid('m_author_id')->nullable()->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('m_books', function (Blueprint $table) {
            $table->string('author')->nullable();
            $table->dropColumn('m_author_id');
        });

    }
};
