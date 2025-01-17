<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = "m_books";
    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $orderBy = ["title" => "asc"];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['code', 'title', 'm_author_id', 'stock'];

    public function author() : BelongsTo
    {
        return $this->belongsTo(Author::class, 'm_author_id');
    }

    public function tBooks() : HasMany
    {
        return $this->hasMany(TBook::class, 'm_book_id');
    }
}
