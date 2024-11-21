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
            $table->integer('category_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('produits', function (Blueprint $table) {
        //     if (Schema::hasColumn('produits', 'category_id')) {
        //         $table->dropForeign(['category_id']); // Supprime la contrainte si elle existe
        //         $table->dropColumn('category_id');   // Supprime la colonne
        //     }
        // });

        Schema::dropIfExists('produits');
    }
};
