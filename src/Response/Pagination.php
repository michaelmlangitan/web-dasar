<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Response;

use App\Serialization\SerializationContextInterface;
use App\Serialization\SerializeBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function sprintf;

/**
 * Class Pagination
 * @package App\Response
 * @version 0.1
 */
class Pagination
{
    private int $status;
    private array $headers;
    private ApiResponse $response;

    /**
     * Pagination constructor.
     * @param ApiResponse $response
     * @param int $status
     * @param array $headers
     * @since 0.1
     */
    public function __construct(ApiResponse $response, int $status = Response::HTTP_OK, array $headers = [])
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->response = $response;
    }

    /**
     * @param Paginator|Container $payload
     * @param SerializationContextInterface|null $serializationContext
     * @return JsonResponse
     * @since 0.1
     */
    public function response(mixed $payload, ?SerializationContextInterface $serializationContext = null): JsonResponse
    {
        if ($payload instanceof Paginator) {
            $payload = new Container($payload);
        } else if ($payload instanceof Container) {
            if (!$payload->getPayload() instanceof Paginator) {
                throw new RuntimeException(sprintf('The payload should instance of %s to make pagination response.', Paginator::class));
            }
        } else {
            throw new RuntimeException(sprintf('The payload should instance of %s or %s to make pagination response.', Paginator::class, Container::class));
        }

        /** @var Paginator $paginator */
        $paginator = $payload->getPayload();
        $query = $paginator->getQuery();
        $payload->setPayload([
            'total'=>$paginator->count(),
            'offset'=>$query->getFirstResult(),
            'limit'=>$query->getMaxResults(),
            'results'=>SerializeBuilder::build()->toArray($query->getResult(), $serializationContext)
        ]);


        return $this->response->success($payload, $this->status, $this->headers);
    }
}