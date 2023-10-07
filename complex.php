<?php
class Complex implements JsonSerializable {
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

    final public function getA(): float {
        return $this->a;
    }

    final public function getB(): float {
        return $this->b;
    }

    public function jsonSerialize(): string {
        return json_encode(['real' => $this->a, 'imaginary' => $this->b]);
    }

    public function plus(Complex $complex2): Complex {
        $a = $this->a + $complex2->a;
        $b = $this->b + $complex2->b;
        return new Complex($a, $b);
    }

    public function minus(Complex $complex2): Complex {
        $a = $this->a - $complex2->a;
        $b = $this->b - $complex2->b;
        return new Complex($a, $b);
    }

    public function multiply(Complex $complex2): Complex {
        $c=$complex2->a;
        $d=$complex2->b;
        $a = $this->a*$c - $this->b*$d;
        $b = $this->b*$c + $this->a*$d;
        return new Complex($a, $b);
    }

    public function divide(Complex $complex2): Complex {
        $c=$complex2->a;
        $d=$complex2->b;
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
var_dump(json_encode($result));