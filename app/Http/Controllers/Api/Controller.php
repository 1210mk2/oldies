<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Oldies but goldies api doc",
 *      description="made for test",
 *      @OA\Contact(
 *          email="1210mk2@gmail.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Server(
 *      url="/api",
 *      description="OpenApi dynamic host server"
 * )
 *
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     description="Use a token from .env API_TOKEN (eg. JdJEeb5hB8nCiZ7nuTPMn54wb1nAUjlqWtbqcEfr)",
 *     name="api_key",
 *     in="header",
 *     securityScheme="token",
 * )
 *
 *
 * @OA\Tag(
 *     name="Artist",
 *     description="Operations about artists",
 * )
 * @OA\Tag(
 *     name="Record",
 *     description="Operations about table records",
 * )
 * @OA\Tag(
 *     name="Search",
 *     description="Operations about search",
 * )
 */

class Controller extends \App\Http\Controllers\Controller
{

}
