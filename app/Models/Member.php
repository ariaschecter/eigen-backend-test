<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = "m_members";
    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $orderBy = ["code" => "asc"];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['code', 'name'];

    public function tBooks() : HasMany
    {
        return $this->hasMany(TBook::class, 'm_member_id');
    }
}
