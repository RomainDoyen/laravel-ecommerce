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
        if (Schema::hasColumn('produits', 'category_id')) {
            return;
        }

        Schema::table('produits', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // category_id est déjà définie dans create_produits_table ; ne pas la retirer ici
        // quand up() a été ignorée, sinon migrate:rollback casse le schéma attendu.
    }
};
