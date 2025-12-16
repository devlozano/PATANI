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
    Schema::table('payments', function (Blueprint $table) {
        // This adds the missing column
        $table->unsignedBigInteger('booking_id')->nullable()->after('user_id');
        
        // This connects it to the bookings table (optional but recommended)
        $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropForeign(['booking_id']);
        $table->dropColumn('booking_id');
    });
}
};
