<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Serialization;

use JMS\Serializer\SerializationContext;

interface SerializationContextInterface
{
    public function setContextFactory(SerializationContext $serializationContext): SerializationContext;
}