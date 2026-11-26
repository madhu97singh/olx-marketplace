<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('country_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('state_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('city_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('listing_type', ['product', 'service']);

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('detail');

            $table->decimal('price', 12, 2)->nullable();

            $table->enum('status', ['active', 'inactive', 'sold'])
                ->default('active');

            $table->timestamps();

            $table->index(['city_id', 'category_id']);
            $table->index(['category_id', 'subcategory_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};