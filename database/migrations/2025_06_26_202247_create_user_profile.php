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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_url')->nullable()->after('email')->comment('URL to the user\'s profile picture');
            $table->string('bio')->nullable()->after('avatar_url')->comment('Short biography of the user, displayed on their profile');
            $table->boolean('is_public')->default(true)->after('bio')->comment('Indicates if the user\'s profile is public or private');
            $table->timestamp('last_active_at')->nullable()->after('is_public')->comment('Timestamp of the last time the user was active on the platform');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar_url',
                'bio',
                'is_public',
                'last_active_at'
            ]);
        });
    }
};
