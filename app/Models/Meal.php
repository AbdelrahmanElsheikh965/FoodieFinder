<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Meal
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $price
 * @property string|null $offer_price
 * @property string $prep_time
 * @property string $image
 * @property int $restaurant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Restaurant $restaurant
 * @method static \Illuminate\Database\Eloquent\Builder|Meal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Meal whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal whereOfferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal wherePrepTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Meal extends Model
{

    protected $table = 'meals';
    public $timestamps = true;
    protected $fillable = array('title', 'body', 'price', 'offer_price', 'prep_time', 'image', 'restaurant_id');

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'meal_order', 'meal_id', 'order_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\restaurant');
    }

}
