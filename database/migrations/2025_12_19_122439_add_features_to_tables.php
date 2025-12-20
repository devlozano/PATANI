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
    // 1. For "Separate Full Name"
    Schema::table('users', function (Blueprint $table) {
        // We assume you currently have a 'name' column. We will keep it or drop it, 
        // but for safety, let's add the new ones.
        $table->string('last_name')->after('id')->nullable();
        $table->string('first_name')->after('last_name')->nullable();
        $table->string('middle_initial')->after('first_name')->nullable();
    });

    // 2. For "Reject Reason"
    Schema::table('bookings', function (Blueprint $table) {
        $table->text('rejection_reason')->nullable()->after('status');
    });

    // 3. For "Payment Image Upload"
    Schema::table('payments', function (Blueprint $table) {
        $table->string('proof_image')->nullable()->after('amount');
    });
}

public function down()
{
    // Reverse logic...
}
};
