<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'category',
        'cover_image',
        'total_copies',
        'available_copies',
        'publication_year',
        'publisher',
    ];

    /**
     * Get the borrow records for the book.
     */
    public function borrowRecords()
    {
        return $this->hasMany(BorrowRecord::class);
    }

    /**
     * Get the active borrow records for the book.
     */
    public function activeBorrows()
    {
        return $this->hasMany(BorrowRecord::class)->where('status', 'borrowed');
    }

    /**
     * Check if the book is available for borrowing.
     */
    public function isAvailable()
    {
        return $this->available_copies > 0;
    }
}
