<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Response;

class Header
{
    protected array $params;

    public function __construct(array $params)
    {
        $this->replace($params);
    }

    public function replace(array $params): void
    {
        foreach ($params as $name=>$value) {
            $this->set($name, $value);
        }
    }

    public function set($name, $value): void
    {
        $this->params[$name] = $value;
    }

    public function get($name, $default = null): mixed
    {
        return $this->has($name) ? $this->params[$name] : $default;
    }

    public function has($name): bool
    {
        return isset($this->params[$name]);
    }

    public function remove($name): void
    {
        unset($this->params[$name]);
    }

    public function all(): array
    {
        return $this->params;
    }
}