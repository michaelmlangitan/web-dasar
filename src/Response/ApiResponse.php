<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    public static function create(): static
    {
        return new static();
    }

    public function success(mixed $payload, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        if (!$payload instanceof Container) {
            $payload = new Container($payload);
        }

        $payload->getHeader()->set('is_error', false);

        return $this->set($payload, $status, $headers);
    }

    public function pagination(int $status = Response::HTTP_OK, array $headers = []): Pagination
    {
        return new Pagination($this, $status, $headers);
    }

    public function error(mixed $messages, int $status = Response::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): JsonResponse
    {
        if (!$messages instanceof Container) {
            $messages = new Container(null, $messages);
        }

        $messages->getHeader()->set('is_error', true);

        return $this->set($messages, $status, $headers);
    }

    public function set(Container $container, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        if(!$container->getHeader()->has('is_error')) {
            $container->getHeader()->set('is_error', false);
        }

        return $this->raw([
            'header'=>$container->getHeader()->all(),
            'messages'=>$container->getMessages(),
            'payload'=>$container->getPayload()
        ], $status, $headers);
    }

    public function raw($data, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }
}