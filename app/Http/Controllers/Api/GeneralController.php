<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use App\Models\City;
use App\Models\Meal;
use App\Models\Region;
use OpenApi\Annotations as OA;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{

    /**
     * @OA\Get(
     *    path="/articles",
     *    operationId="index",
     *    tags={"Articles"},
     *    summary="Get list of articles",
     *    description="Get list of articles",
     *    @OA\Parameter(name="limit", in="query", description="limit", required=false,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Parameter(name="page", in="query", description="the page number", required=false,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Parameter(name="order", in="query", description="order  accepts 'asc' or 'desc'", required=false,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Response(
     *          respond=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */
    public function cities()
    {
        $rows = City::all();
        return ($rows);
    }

    public function regions()
    {
        $rows = Region::all();
        return ($rows);
    }

    public function categories()
    {
        $rows = Category::all();
        return ($rows);
    }

    public function reviews()
    {
        $rows = Review::all();
        return ($rows);
    }

    public function restaurants()
    {
        $rows = Restaurant::all();
        return ($rows);
    }

    public function meals()
    {
        $rows = Meal::all();
        return ($rows);
    }
}
