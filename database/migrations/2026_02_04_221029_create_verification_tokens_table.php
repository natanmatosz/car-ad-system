<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const int TOKEN_LENGTH = 6;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('verification_tokens', function (Blueprint $table): void {
            $table->id();
            $table->string('verification_token', self::TOKEN_LENGTH)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->string('verification_type');
            $table->timestamp('expire_at')->nullable();
            $table->uuid('user_uuid');

            $table->foreign('user_uuid')->references('uuid')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Nette\Utils\Random::generate(self::TOKEN_LENGTH);
        Schema::dropIfExists('verification_tokens');
    }
};
