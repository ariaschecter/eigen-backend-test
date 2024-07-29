<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = "m_authors";
    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $orderBy = ["code" => "asc"];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['code', 'name'];
}
