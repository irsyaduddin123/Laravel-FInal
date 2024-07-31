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
        Schema::table('orders', function (Blueprint $table) {
            // Mengubah kolom status
            $table->enum('status', ['Unpaid', 'Paid', 'Expire'])
                ->default('Unpaid')
                ->change()
                ->after('total_price');
            $table->longText('data')->nullable()->after('snaptoken');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->change();
            $table->dropColumn('data');
        });
    }
};
