<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('message');
            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('user_agent_short', 255)->nullable();
            $table->enum('status', ['new', 'read', 'responded', 'archived'])->default('new');
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
