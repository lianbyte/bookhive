<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
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
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the borrow records for the user.
     */
    public function borrowRecords()
    {
        return $this->hasMany(BorrowRecord::class);
    }

    /**
     * Get the active borrow records for the user.
     */
    public function activeBorrows()
    {
        return $this->hasMany(BorrowRecord::class)->where('status', 'borrowed');
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is librarian.
     */
    public function isLibrarian()
    {
        return $this->role === 'librarian';
    }

    /**
     * Check if user is member.
     */
    public function isMember()
    {
        return $this->role === 'member';
    }

    /**
     * Check if user has staff privileges (admin or librarian).
     */
    public function isStaff()
    {
        return in_array($this->role, ['admin', 'librarian']);
    }
}
