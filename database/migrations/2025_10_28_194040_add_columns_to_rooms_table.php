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
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'room_floor')) {
                $table->string('room_floor')->after('room_number');
            }

            if (!Schema::hasColumn('rooms', 'bedspace')) {
                $table->integer('bedspace')->after('room_floor');
            }

            if (!Schema::hasColumn('rooms', 'status')) {
                $table->string('status')->default('available')->after('bedspace');
            }

            if (!Schema::hasColumn('rooms', 'rent_fee')) {
                $table->decimal('rent_fee', 8, 2)->after('status');
            }

            if (!Schema::hasColumn('rooms', 'description')) {
                $table->text('description')->nullable()->after('rent_fee');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['room_floor', 'bedspace', 'status', 'rent_fee', 'description']);
        });
    }
};
