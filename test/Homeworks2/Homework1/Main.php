<?php

namespace Homeworks2\Homework1;

class Main {
    function fooA() {
        $a1 = new A();
        $a2 = new A();
        $a1->foo();
        $a2->foo();
        $a1->foo();
        $a2->foo();
    }

    function fooAB() {
        $a1 = new A();
        $b1 = new B();
        $a1->foo();
        $b1->foo();
        $a1->foo();
        $b1->foo();
    }
}

class A
{
public function foo() {
    static $x = 0;//переменная инициализируется 1 раз за выполнения всего скрипта и держит в памяти
    echo ++$x;
}
}
class B extends A {
}