<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Serialization;

use JMS\Serializer\SerializationContext;

class CommonSerialization extends AbstractSerializationContext implements SerializationContextInterface
{
    public function __construct(array $groups = [])
    {
        $this->addGroups($groups);
    }

    public function setContextFactory(SerializationContext $serializationContext): SerializationContext
    {
        $serializationContext
            ->setSerializeNull(true)
            ->setGroups($this->getGroups());

        return $serializationContext;
    }
}