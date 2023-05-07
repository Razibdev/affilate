<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher_payment_method extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_type', 'card_no', 'payment_details', 'expiry_date', 'isbn_no', 'publisher_id','is_primary'
    ];
    protected $table = 'publisher_payment_method';

    public function paymentmethod()
    {
        return $this->belongsTo(Payment_method::class, 'payment_type','name');
    }

}
