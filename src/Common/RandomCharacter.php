<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Common;

use RuntimeException;

class RandomCharacter
{
    public const CHAR_NUMBER = 0;
    public const CHAR_UPPERCASE = 1;
    public const CHAR_LOWERCASE = 2;
    private array $charOptions = [];

    public function __construct(array $charOptions = [self::CHAR_NUMBER, self::CHAR_UPPERCASE])
    {
        $this->setCharOptions($charOptions);
    }

    public static function build(array $charOptions = [self::CHAR_NUMBER, self::CHAR_UPPERCASE]): static
    {
        return new static($charOptions);
    }

    public function hasCharOption(int $char): bool
    {
        return in_array($char, $this->charOptions);
    }

    public function setCharOptions(array $chars): self
    {
        foreach ($chars as $char) {
            $this->setCharOption($char);
        }

        return $this;
    }

    public function setCharOption(int $char): self
    {
        if (!in_array($char, $this->charOptions)) {
            $this->charOptions[] = $char;
        }

        return $this;
    }

    public function removeCharOption(int $char): self
    {
        if (false !== $key = array_search($char, $this->charOptions)) {
            unset($this->charOptions[$key]);
        }

        return $this;
    }

    public function generate(int $length = 10, ?string $prefix = null): string
    {
        $result = '';
        $chars = $this->getChars();
        $maxChars = strlen($chars) - 1;

        for($x=0; $x<$length; $x++) {
            $result .= $chars[mt_rand(0, $maxChars)];
        }

        return $prefix.$result;
    }

    private function getChars(): string
    {
        $chars = '';

        if ($this->hasCharOption(self::CHAR_NUMBER)) {
            $chars .= '0123456789';
        }

        if ($this->hasCharOption(self::CHAR_UPPERCASE)) {
            $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        if ($this->hasCharOption(self::CHAR_LOWERCASE)) {
            $chars .= 'abcdefghijklmnopqrstuvwxyz';
        }

        if (empty($chars)) {
            throw new RuntimeException('Please to set the char options to generate random characters.');
        }

        return $chars;
    }
}