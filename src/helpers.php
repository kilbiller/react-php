<?php

namespace React;

/**
 * Shorthand for React::createElement
 *
 * @param  string                          $type
 * @param  array|null                      $props
 * @param  ReactNode|string|int|float|null $children
 * @return ReactNode
 */
function el(string $type, ?array $props = null, $children = null): ReactNode
{
    return React::createElement($type, $props, $children);
}

function div(?array $props = null, $children = null): ReactNode
{
    return React::createElement('div', $props, $children);
}

function span(?array $props = null, $children = null): ReactNode
{
    return React::createElement('span', $props, $children);
}
