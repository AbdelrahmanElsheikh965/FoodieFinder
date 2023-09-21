<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MealOrder
 *
 * @property int $meal_id
 * @property int $order_id
 * @property int $quantity
 * @property string $notes
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder whereMealId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MealOrder extends Model
{

    protected $table = 'meal_order';
    public $timestamps = true;
    protected $fillable = array('meal_id', 'order_id', 'quantity', 'notes', 'price');

}
