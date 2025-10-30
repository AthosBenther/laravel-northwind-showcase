<?php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,         // standard formatting
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'single_quote' => true,
        'no_unused_imports' => true,
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/app')
    );
