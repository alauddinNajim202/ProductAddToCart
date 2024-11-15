<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',    // Name of the customer making the payment
        'card_number',      // Encrypted card number
        'cvc',              // Encrypted CVC
        'expiry_month',     // Encrypted expiration month
        'expiry_year',      // Encrypted expiration year
        'amount',           // Payment amount
        'status',           // Payment status (pending, success, rejected, failed)
    ];
}
