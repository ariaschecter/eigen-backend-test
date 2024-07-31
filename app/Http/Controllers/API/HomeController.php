<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * @OA\Get(
 *     path="/home",
 *     tags={"Users"},
 *     summary="Get list of users",
 *     description="Returns list of users",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/User")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request",
 *     )
 * )
 */

class HomeController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     title="User",
     *     required={"name", "email"},
     *     @OA\Property(
     *         property="id",
     *         type="string",
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="John Doe"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         example="johndoe@example.com"
     *     ),
     * )
     */
    public function index()
    {
        return response()->json([
            'data' => User::all()
        ]);
    }
}
