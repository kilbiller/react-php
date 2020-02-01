<?php

namespace React;

class ReactNode
{

    /**
     * A component classpath OR an html tag
     */
    public string $type;

    /**
     * Node props
     */
    public ?array $props;

    /**
     * Node children
     *
     * @var ReactNode|string|int|float|null
     */
    public $children;

    /**
     * Check if content should be sanitized
     *
     * @param  ReactNode|string|int|float|null $children
     * @return bool
     */
    private function shouldSanitizeInput($children): bool
    {
        $dangerouslySetInnerHTML = $this->props['dangerouslySetInnerHTML'] ?? false;
        return !$dangerouslySetInnerHTML && is_string($children);
    }

    public function __construct(string $type, ?array $props, $children)
    {
        $this->type = $type;
        $this->props = $props;

        if ($this->shouldSanitizeInput($children)) {
            $this->children = htmlspecialchars($children);
        } else {
            $this->children = $children;
        }
    }
}
