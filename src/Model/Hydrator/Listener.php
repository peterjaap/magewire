<?php declare(strict_types=1);
/**
 * Copyright © Willem Poortman 2021-present. All rights reserved.
 *
 * Please read the README and LICENSE files for more
 * details on copyrights and license information.
 */

namespace Magewirephp\Magewire\Model\Hydrator;

use Magewirephp\Magewire\Helper\Functions as FunctionsHelper;
use Magewirephp\Magewire\Component;
use Magewirephp\Magewire\Model\HydratorInterface;
use Magewirephp\Magewire\Model\RequestInterface;
use Magewirephp\Magewire\Model\ResponseInterface;

class Listener implements HydratorInterface
{
    protected FunctionsHelper $functionsHelper;
    protected array $listeners;

    /**
     * @param FunctionsHelper $functionsHelper
     * @param array $listeners
     */
    public function __construct(
        FunctionsHelper $functionsHelper,
        array $listeners = []
    ) {
        $this->functionsHelper = $functionsHelper;
        $this->listeners = $listeners;
    }

    /**
     * @inheritdoc
     */
    public function hydrate(Component $component, RequestInterface $request): void
    {
        //
    }

    /**
     * @inheritdoc
     */
    public function dehydrate(Component $component, ResponseInterface $response): void
    {
        if ($response->getRequest()->isPreceding()) {
            $response->effects['listeners'] = array_keys($this->assimilateListeners($component));
        }
    }

    /**
     * Merges optional injected event listeners for the given Component.
     *
     * @param Component $component
     * @return array
     */
    public function assimilateListeners(Component $component): array
    {
        $listeners = $component->getListeners();

        if (isset($this->listeners[$component->name])) {
            $listeners = array_merge($this->listeners[$component->name], $listeners);
        }

        // Global event's for each component
        $listeners['refresh'] = '$refresh';

        return $this->functionsHelper->mapWithKeys(function ($value, $key) {
            return [is_numeric($key) ? $value : $key => $value];
        }, $listeners);
    }
}
