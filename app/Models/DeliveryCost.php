<?php

namespace App\Models;

use App\Traits\ConvertFormatCurrency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DeliveryCost extends Model
{
    use ConvertFormatCurrency;
    protected $fillable = ['cost'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'cost' => 'decimal:2',
    ];

    /**
     * Get the cost of delivery formatted.
     *
     * @return string
     */
    public function getCostAttribute($value): string
    {
        return number_format($value, 2);
    }
    public function scopeSearch($query, string|null $search = null): Builder
    {
        return empty($search) && !is_numeric($search) ? $query : $query->where('cost', '=', (float) $search);
    }
    public function getFormattedCurrencyAttribute(): string
    {
        return $this->convert($this->cost);
    }
}
