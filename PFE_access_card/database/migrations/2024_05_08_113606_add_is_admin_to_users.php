<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function GuzzleHttp\default_ca_bundle;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email');
        });*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
