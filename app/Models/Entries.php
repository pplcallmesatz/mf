<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Carbon\Carbon;

    class Entries extends Model
    {
        protected $fillable = ['stock_name', 'investment', 'nav_value', 'total_nav', 'purchase_date'];
        // Accessor for formatted purchase_date
        public function getFormattedPurchaseDateAttribute()
        {
            return Carbon::parse($this->attributes['purchase_date'])->format('d/m/Y');
        }
        // Mutator for purchase_date attribute
        public function setPurchaseDateAttribute($value)
        {
            // Convert the input format (11/12/2024) to a valid database format (Y-m-d)
            $this->attributes['purchase_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }
