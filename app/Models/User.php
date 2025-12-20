<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Payment; // Ensure Payment model is imported

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',     // ✅ NEW: Added for split name support
        'last_name',      // ✅ NEW
        'middle_initial', // ✅ NEW
        'name',           // Kept for backward compatibility if needed
        'email',
        'password',
        'gender',
        'address',
        'contact',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * ✅ NEW ACCESSOR: Full Name
     * Automatically combines First, Middle, and Last name when you access $user->name
     */
    public function getNameAttribute($value)
    {
        // If the new columns are populated, return the combined string
        if (!empty($this->first_name) || !empty($this->last_name)) {
            $mi = $this->middle_initial ? $this->middle_initial . '.' : '';
            return trim("{$this->first_name} {$mi} {$this->last_name}");
        }

        // Fallback to the old 'name' column if separate fields are empty
        return $value;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get all bookings of the user
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the approved room via booking
     */
    public function approvedRoom()
    {
        return $this->hasOneThrough(
            Room::class,        // The final model
            Booking::class,     // The intermediate model
            'user_id',          // Foreign key on bookings table
            'id',               // Foreign key on rooms table (primary key of rooms)
            'id',               // Local key on users table
            'room_id'           // Local key on bookings table
        )->where('bookings.status', 'approved');
    }

    public function latestRoom()
    {
        return $this->bookings()->with('room')->latest()->first()?->room;
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && file_exists(storage_path('app/public/avatars/' . $this->avatar))) {
            return asset('storage/avatars/' . $this->avatar);
        }

        // Generate initials avatar dynamically using the Accessor we just created
        $name = urlencode($this->name ?? 'User');
        return "https://ui-avatars.com/api/?name={$name}&background=random&color=fff";
    }
}