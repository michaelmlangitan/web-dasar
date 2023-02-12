<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Serialization;

use JMS\Serializer\SerializerBuilder;

class SerializeBuilder
{
    public static function build(): self
    {
        return new static();
    }

    public function toArray($data, ?SerializationContextInterface $serializationContext = null): ?array
    {
        if (null === $data) {
            return null;
        }

        $serializer = SerializerBuilder::create()
            ->setSerializationContextFactory(new SerializationContextFactory(
                null !== $serializationContext ? $serializationContext : new CommonSerialization()
            ))
            ->build();

        return $serializer->toArray($data);
    }
}