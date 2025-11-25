<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('Pending', 'Approved', 'Cancelled', 'CheckedOut') DEFAULT 'Pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('Pending', 'Approved', 'Cancelled') DEFAULT 'Pending'");
    }
};
