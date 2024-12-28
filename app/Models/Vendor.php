<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "business_name",
        "category",
        "address",
        "reg_number",
        "govt_id",
        "business_license",
        "bg_check_authorization"
    ];
}
