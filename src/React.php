<?php

namespace React;

use Exception;

class React
{

    private const HTML_VOID_ELEMENTS = [
    'area',
    'base',
    'br',
    'col',
    'embed',
    'hr',
    'img',
    'input',
    'link',
    'meta',
    'param',
    'source',
    'track',
    'wbr',
    ];

    public static function createElement(string $type, ?array $props = null, $children = null): ReactNode
    {
        return new ReactNode($type, $props, $children);
    }

    public static function renderToString(?ReactNode $node): ?string
    {
        if ($node === null) {
            return null;
        }

        $type = $node->type;
        $props = $node->props;
        $children = $node->children;

        // Custom component
        if (class_exists($type)) {
            $component = new $type($props);
            return self::renderToString($component->render());
        }

        // Html tag
        if (is_string($type)) {
            $propsStr = '';
            if (is_array($props)) {
                foreach ($props as $key => $value) {
                    if (!in_array($key, ['dangerouslySetInnerHTML'])) {
                        $propsStr .= "{$key}=\"{$value}\" ";
                    }
                }
                $propsStr = substr($propsStr, 0, strlen($propsStr) - 1);
            }
            
            if ($children instanceof ReactNode) {
                $children = self::renderTostring($children);
            }

            $html = '<' . $type;

            if (!empty($propsStr)) {
                $html .= ' ' . $propsStr;
            }

            if (in_array($type, self::HTML_VOID_ELEMENTS)) {
                $html .= ' />';
            } else {
                $html .= '>' .  $children . '</' . $type . '>';
            }

            return $html;
        }

        throw new Exception('Not implemented.');
    }
}
