<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntriesList extends Model
{
    public static function getAllEntries()
    {
        return self::all(); // Fetch all entries
    }
}
