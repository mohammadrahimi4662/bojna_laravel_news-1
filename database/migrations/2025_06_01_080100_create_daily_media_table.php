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
        Schema::create('daily_media', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('lead')->nullable();
            $table->string('media_path');
            $table->enum('media_type', ['image', 'video']);
            $table->boolean('status')->default(true); // true: فعال
            $table->timestamp('published_at')->nullable(); // برای زمان‌بندی انتشار
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_media');
    }
};
