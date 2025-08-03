<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealContractStatistics extends Model
{
    protected $fillable = [
        'date',
        'delivery_cost',
        'food_cost',
        'program_delivery_cost',
        'weekly_delivery_cost',
        'weekly_food_cost',
        'weekly_program_delivery_cost',
        'monthly_delivery_cost',
        'monthly_food_cost',
        'monthly_program_delivery_cost',
        'yearly_delivery_cost',
        'yearly_food_cost',
        'yearly_program_delivery_cost',
    ];
}
