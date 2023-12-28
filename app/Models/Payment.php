<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function paymentStatus():BelongsTo {
        return $this->belongsTo(PaymentStatus::class);
    }

    public function merchant():BelongsTo {
        return $this->belongsTo(Merchant::class);
    }
}
