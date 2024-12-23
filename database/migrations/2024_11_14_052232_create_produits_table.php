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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('description')->nullable();
            $table->decimal('prix')->default(0);
            $table->decimal('prix_promotionnel')->nullable();
            $table->string('image')->default('assets/images/no-image.jpg');
            $table->integer('quantity')->default(0);
            $table->boolean('promotion')->default(false);
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->timestamps();
        });

        if (!Schema::hasColumn('produits', 'category_id')) {
            Schema::table('produits', function (Blueprint $table) {
                $table->integer('category_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');

        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
