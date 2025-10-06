<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dataset extends Model
{
    use HasFactory;

    protected $table = 'dataset';

    protected $fillable = ['text', 'embedding'];

    
}
