<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        // Stores the file path (e.g., 'contracts/booking_123.pdf')
        $table->string('contract_file')->nullable()->after('status'); 
        
        // Optional: Date when it was signed
        $table->timestamp('signed_at')->nullable(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
