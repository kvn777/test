<?php
class Complex {
    private float $a;
    private float $b;

    public function __construct(float $a, float $b) {
        $this->a = $a;
        $this->b = $b;
    }

    public function __toString(): string {
        $sign = ($this->b >= 0) ? '+' : '-';
        return $this->a.$sign.abs($this->b).'i';
    }

    public function getA(): float {
        return $this->a;
    }

    public function getB(): float {
        return $this->b;
    }

    public function toJson(): string {
        return json_encode(['real' => $this->a, 'imaginary' => $this->b]);
    }

    public function plus(Complex $complex2): Complex {
        $a = $this->a + $complex2->getA();
        $b = $this->b + $complex2->getB();
        return new Complex($a, $b);
    }

    public function minus(Complex $complex2): Complex {
        $a = $this->a - $complex2->getA();
        $b = $this->b - $complex2->getB();
        return new Complex($a, $b);
    }

    public function multiply(Complex $complex2): Complex {
        $c=$complex2->getA();
        $d=$complex2->getB();
        $a = $this->a*$c - $this->b*$d;
        $b = $this->b*$c + $this->a*$d;
        return new Complex($a, $b);
    }

    public function divide(Complex $complex2): Complex {
        $c=$complex2->getA();
        $d=$complex2->getB();
        $delim = pow($c,2) + pow($d,2);
        $a = ($this->a*$c + $this->b*$d)/$delim;
        $b = ($this->b*$c - $this->a*$d)/$delim;
        return new Complex($a, $b);
    }
}

$complex1 = new Complex(1, 2);
$complex2 = new Complex(3, 4);

$result = $complex1->divide($complex2);

echo $result . PHP_EOL;