<?php
/*
 * This file is part of the Web Dasar Project.
 * (c) Michael M Langitan <michaelmlangitan@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use App\Entity\Option;
use App\Repository\OptionRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use function array_key_exists;

class OptionExtension extends AbstractExtension
{
    private OptionRepository $repository;

    /** @var array|Option[] */
    private array $options = [];

    public function __construct(OptionRepository $repository)
    {
        $this->repository = $repository;
        $this->initAutoloadOptions();
    }

    private function initAutoloadOptions()
    {
        $options = $this->repository->findAllAutoload();
        foreach ($options as $option) {
            $this->options[$option->getName()] = $option;
        }
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('web_info', [$this, 'webInfo']),
            new TwigFunction('get_option', [$this, 'getOption'])
        ];
    }

    public function webInfo(string $name, ?string $default = null): ?string
    {
        return array_key_exists($name, $this->options) ? $this->options[$name]->getValue() : $default;
    }

    public function getOption(string $name, ?string $default = null, bool $asEntity = false)
    {
        if (array_key_exists($name, $this->options)) {
            return $asEntity ? $this->options[$name] : $this->options[$name]->getValue();
        }

        if ($option = $this->repository->findByName($name)) {
            return $asEntity ? $option : $option->getValue();
        }

        return $default;
    }
}