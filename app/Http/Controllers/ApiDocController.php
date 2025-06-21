<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Api de atzicay",
 *     version="1.0.0",
 *     description="Documentación de la API de atzicay",
 * )
 * @OA\Server(
 *     url="http://localhost:8000/api/v1/atzicay",
 *     description="Servidor de desarrollo"
 * )
 */
class ApiDocController extends Controller
{
    // Este archivo solo es para documentación Swagger.
}
