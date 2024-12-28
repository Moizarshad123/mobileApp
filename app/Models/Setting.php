<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ["privacy_policy", "terms_and_conditions", "logo", 'united_capitalism', 'pdf_file'];
}
