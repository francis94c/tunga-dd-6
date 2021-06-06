<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'checked',
        'description',
        'date_of_birth',
        'interest',
        'email',
        'account',
        'credit_card_type',
        'credit_card_number',
        'credit_card_name',
        'credit_card_expiration_date'
    ];
}
