<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TBook extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = "t_books";
    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $orderBy = ["title" => "asc"];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['code', 'borrow_date', 'return_date', 'm_book_id', 'm_member_id'];

    public function book() : BelongsTo
    {
        return $this->belongsTo(Book::class, 'm_book_id');
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(Member::class, 'm_member_id');
    }
}
