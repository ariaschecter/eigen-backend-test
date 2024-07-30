<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="My API",
 *     description="API Documentation",
 *     @OA\Contact(
 *         email="support@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Server(
 *     url="https://eigen-test.acielana.my.id/api",
 *     description="DevelopmentServer"
 * )
 * @OA\Server(
 *     url="http://127.0.0.1:8000/api",
 *     description="Local Server"
 * )
 */
class SwaggerController extends BaseController
{
    // You can place additional annotations here
}

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
