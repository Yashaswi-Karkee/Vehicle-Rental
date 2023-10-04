<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('agencies', function (Blueprint $table) {

            $table->string('PAN_no');
            $table->string('register_number');
            $table->string('PAN_pic');
            $table->string('company_register_pic');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('PAN_no');
            $table->dropColumn('register_number');
            $table->dropColumn('PAN_pic');
            $table->dropColumn('company_register_pic');
        });
    }
};