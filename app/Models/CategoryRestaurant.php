<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryRestaurant
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $restaurant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRestaurant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRestaurant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRestaurant query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRestaurant whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRestaurant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRestaurant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRestaurant whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRestaurant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CategoryRestaurant extends Model 
{

    protected $table = 'category_restaurant';
    public $timestamps = true;

}