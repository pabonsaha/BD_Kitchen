<?php

use App\Models\User;
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
            $table->string('name');
            $table->tinyInteger("role_id")->default(0);
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->unsignedBigInteger('designer_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar', 256)->nullable();
            $table->string('address', 256)->nullable();
            $table->tinyInteger('active_status')->default(1)->comment('0=pause, 1=active, 2=suspend');
            $table->tinyInteger('is_subscribed')->default(0)->comment('0=no, 1=yes');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
