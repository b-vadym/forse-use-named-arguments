<?php

require __DIR__ . '/vendor/autoload.php';

class Foo {
    public function __construct(public int $foo)
    {
    }

    public function method(int $foo): void
    {
        $this->foo = $foo;
    }
}

$foo = new Foo(foo: 1);
$foo->method(foo: 1);
$foo = new Foo(
    1
);
$foo->method(1);

/** @psalm-suppress  UseNamedArguments */
$foo = new Foo(
    1
);
/** @psalm-suppress  UseNamedArguments */
$foo->method(1);