<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// TODO: Lengkapi Model ini agar Member terhubung dengan Book.

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Member extends Model
{
    // TODO 2: Isi fillable dengan kolom yang boleh diisi melalui mass assignment
    // Contoh format: protected $fillable = ['kolom1', 'kolom2'];
    protected $fillable = ['name'];

    /**
     * TODO 3: Definisikan relasi hasMany ke Model Book.
     * Ingat: satu Member dapat meminjam banyak Book.
     *
     * Contoh format:
     * public function namaRelasi()
     * {
     *     return $this->hasMany(NamaModel::class);
     * }
     */
    public function books()
    {
       return  $this->hasMany(Book::class);
    }
}
