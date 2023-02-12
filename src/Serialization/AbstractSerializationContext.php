<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Serialization;

use function array_search;
use function array_splice;
use function array_unique;
use function in_array;

abstract class AbstractSerializationContext
{
    private array $groups = [];

    public function hasGroup(string $group): bool
    {
        return in_array($group, $this->groups);
    }

    public function addGroups(array $groups): void
    {
        foreach ($groups as $group) {
            $this->addGroup($group);
        }
    }

    public function addGroup(string $group): void
    {
        $this->groups[] = $group;
    }

    public function getGroups(bool $addDefaultGroup = true): array
    {
        $groups = $this->groups;

        if ($addDefaultGroup) {
            $groups[] = 'Default';
        }

        return array_unique($groups);
    }

    public function removeGroups(array $groups): void
    {
        foreach ($groups as $group) {
            $this->removeGroup($group);
        }
    }

    public function removeGroup(string $group): void
    {
        if (false === $key = array_search($group, $this->groups)) {
            return;
        }

        array_splice($this->groups, $key);
    }
}