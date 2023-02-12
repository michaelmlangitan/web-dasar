<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use App\Serialization\CommonSerialization;
use App\Serialization\SerializeBuilder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use function json_decode;
use function json_encode;

class CommonExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('json_decode', [$this, 'jsonDecode']),
            new TwigFilter('json_encode', [$this, 'jsonEncode']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('deserialize_entity', [$this, 'deserializeEntity']),
        ];
    }

    public function jsonDecode(string $str, ?bool $associative = null, int $flags = 0, int $depth = 512)
    {
        return json_decode($str, $associative, $depth, $flags);
    }

    public function jsonEncode(array $data, int $flags = 0, int $depth = 512): string
    {
        return json_encode($data, $flags, $depth);
    }

    public function deserializeEntity($entity, array $groups = []): ?array
    {
        return SerializeBuilder::build()->toArray($entity, new CommonSerialization($groups));
    }
}