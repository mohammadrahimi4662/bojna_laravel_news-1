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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('logo_type', ['text', 'image'])->default('text');
            $table->string('logo_text')->nullable();
            $table->string('logo_image')->nullable();
            $table->boolean('show_date_info')->default(true);
            $table->text('footer_about')->nullable(); // درباره ما
            $table->text('footer_social_links')->nullable(); // JSON شبکه‌های اجتماعی
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
