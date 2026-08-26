<?php

$header = <<<'EOF'
This file is part of the overtrue/chinese-calendar.
(c) overtrue <i@overtrue.me>
This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/src', __DIR__.'/tests'])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'header_comment' => ['header' => $header],
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_superfluous_phpdoc_tags' => false,
        'global_namespace_import' => ['import_classes' => true],
        'phpdoc_align' => ['align' => 'vertical'],
        'yoda_style' => false,
    ])
    ->setFinder($finder);
