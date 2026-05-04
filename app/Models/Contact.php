<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $table = 'contacts';

    protected $fillable  = [
        'name',
        'email_address',
        'contact',
    ];

    /*protected $appends = [
        'formatted_contact',
    ];*/

    public function getFormattedContactAttribute(): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})/', '$1 $2 $3', $this->contact);
    }

}
