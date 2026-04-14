<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Cek dulu apakah kolom amount belum ada sebelum dibuat
            if (!Schema::hasColumn('payments', 'amount')) {
                $table->decimal('amount', 15, 2)->after('order_id')->default(0);
            }

            // Cek dulu apakah kolom payment_proof belum ada sebelum dibuat
            if (!Schema::hasColumn('payments', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('payment_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['amount', 'payment_proof']);
        });
    }
};
