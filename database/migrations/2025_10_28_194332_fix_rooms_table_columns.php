<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'room_number')) {
                $table->integer('room_number')->after('id');
            }
            if (!Schema::hasColumn('rooms', 'room_floor')) {
                $table->string('room_floor')->after('room_number');
            }
            if (!Schema::hasColumn('rooms', 'gender')) {
                $table->string('gender')->after('room_floor');
            }
            if (!Schema::hasColumn('rooms', 'bedspace')) {
                $table->integer('bedspace')->after('gender');
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
            if (!Schema::hasColumn('rooms', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'room_number')) $table->dropColumn('room_number');
            if (Schema::hasColumn('rooms', 'room_floor')) $table->dropColumn('room_floor');
            if (Schema::hasColumn('rooms', 'gender')) $table->dropColumn('gender');
            if (Schema::hasColumn('rooms', 'bedspace')) $table->dropColumn('bedspace');
            if (Schema::hasColumn('rooms', 'status')) $table->dropColumn('status');
            if (Schema::hasColumn('rooms', 'rent_fee')) $table->dropColumn('rent_fee');
            if (Schema::hasColumn('rooms', 'description')) $table->dropColumn('description');
            if (Schema::hasColumn('rooms', 'image')) $table->dropColumn('image');
        });
    }
};
