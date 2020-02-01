<?php

// phpcs:disable PSR1.Files.SideEffects
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

use React\React;
use React\Component;
use React\ReactNode;

use function React\div;
use function React\el;
use function React\span;

describe(
    'React',
    function () {
        it(
            'should render a div correctly',
            function () {
                $html = React::renderToString(el('div'));
    
                expect($html)->toBe('<div></div>');
            }
        );

        it(
            'should render a self closign tag correctly',
            function () {
                $html = React::renderToString(el('img', ['src' => 'huhu'], 'hello'));

                expect($html)->toBe('<img src="huhu" />');
            }
        );

        it(
            'should render nested elements correctly',
            function () {
                $html = React::renderToString(el('div', null, el('div', null, 'hello')));

                expect($html)->toBe('<div><div>hello</div></div>');
            }
        );

        it(
            'should render empty custom components correctly',
            function () {
                class MyComponent implements Component
                {

                    public function render(): ?ReactNode
                    {
                        return null;
                    }
                }
        
                $html = React::renderToString(el(MyComponent::class, null, 'lol'));

                expect($html)->toBe(null);
            }
        );

        it(
            'should sanitize inputs by default',
            function () {
                class MyComponent2 implements Component
                {

                    public function render(): ?ReactNode
                    {
                        return div(['class' => 'yay'], span(['class' => 'yay'], '<i>lol</i>'));
                    }
                }
        
                $html = React::renderToString(el(MyComponent2::class, null));

                expect($html)->toBe('<div class="yay"><span class="yay">&lt;i&gt;lol&lt;/i&gt;</span></div>');
            }
        );

        it(
            'should bypass sanitization',
            function () {
                $html = React::renderToString(div(['dangerouslySetInnerHTML' => true], '<span>Hi</span>'));

                expect($html)->toBe('<div><span>Hi</span></div>');
            }
        );
    }
);
