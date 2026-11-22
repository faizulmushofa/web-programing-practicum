<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model ini sudah LENGKAP - tidak perlu diubah.
// Gunakan sebagai referensi format penulisan Model + relationship.

/**
 * @property int $id
 * @property string $title
 * @property string $author
 * @property bool $is_available
 * @property int|null $member_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member|null $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    protected $fillable = ['title', 'author', 'is_available', 'member_id'];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * Relasi: satu Book dimiliki oleh satu Member (belongsTo)
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
