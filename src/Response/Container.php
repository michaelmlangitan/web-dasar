<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Response;

class Container
{
    private mixed $payload;
    private array $messages;
    private Header $header;

    public function __construct($payload, array|string $messages = [], array $header = [])
    {
        $this->payload = $payload;
        $this->messages = (array) $messages;
        $this->header = new Header($header);
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }

    public function setPayload($payload): void
    {
        $this->payload = $payload;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function setMessages($messages): void
    {
        $this->messages = (array) $messages;
    }

    public function getHeader(): Header
    {
        return $this->header;
    }
}