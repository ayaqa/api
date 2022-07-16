<?php

use OpenApi\Annotations as OA;

define('APP_URL', config('APP_URL'));

/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      title="AyaQA",
 *      version="0.0.1",
 *      description="AyaQA API Docs",
 *      @OA\Contact(
 *          name="Angel Manchev",
 *          email="angel@manchev.pro",
 *          url="https://github.com/ayaqa"
 *      ),
 *  ),
 *  @OA\Server(
 *     url=APP_URL,
 *     description="AyaQA Rest API"
 *  ),
 *  @OA\PathItem(path="/")
 * )
 */
class OpenAPI
{
}
