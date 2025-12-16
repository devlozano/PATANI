<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // ✅ Required for date calculations

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'bed_number', 
        'booking_date',
        'status',
    ];

    /* -------------------------------------------------------------------------- */
    /* Relationships                               */
    /* -------------------------------------------------------------------------- */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    // Alias for user
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }

    /* -------------------------------------------------------------------------- */
    /* Custom Logic                                */
    /* -------------------------------------------------------------------------- */

    /**
     * Determine if the tenant is overdue.
     * Usage: $booking->is_overdue (returns true/false)
     */
    public function getIsOverdueAttribute()
    {
        // We only check overdue status for tenants who are currently Approved
        if (strtolower($this->status) !== 'approved') {
            return false;
        }

        // 1. Get the date of the latest APPROVED payment
        $lastPayment = $this->payments()
            ->where('status', 'approved') // Ensure we only count valid payments
            ->latest() // Get the most recent one
            ->first();

        // 2. Determine the reference date
        // If they have paid before, the clock starts from their last payment date.
        // If they have NEVER paid, the clock starts from their booking/move-in date (created_at).
        $lastPaidDate = $lastPayment ? $lastPayment->created_at : $this->created_at;

        // 3. Calculate Due Date (Last Payment + 1 Month)
        $dueDate = Carbon::parse($lastPaidDate)->addMonth();

        // 4. Check if current time is greater than the due date
        return Carbon::now()->gt($dueDate);
    }
}