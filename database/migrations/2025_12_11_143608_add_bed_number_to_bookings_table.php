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
        // ✅ Add this line
        $table->string('bed_number')->nullable()->after('room_id'); 
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        // ✅ Add this line (to undo changes if needed)
        $table->dropColumn('bed_number');
    });
}
};
