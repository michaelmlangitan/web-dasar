<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Serialization;

use JMS\Serializer\ContextFactory\SerializationContextFactoryInterface;
use JMS\Serializer\SerializationContext;

class SerializationContextFactory implements SerializationContextFactoryInterface
{
    private SerializationContextInterface $serializationContext;

    public function __construct(SerializationContextInterface $serializationContext)
    {
        $this->serializationContext = $serializationContext;
    }

    /**
     * @return SerializationContext
     * @since 0.1
     */
    public function createSerializationContext(): SerializationContext
    {
        return $this->serializationContext->setContextFactory(new SerializationContext());
    }
}