<?php

namespace App\Models;

use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detail() {
        return $this->hasMany(TransactionDetail::class, 'document_number', 'document_number');
    }
}
