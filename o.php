<?php

/*
* Open Closed Principle
*
* Classes should be open for extension but closed for modification.
*/
//BAD CODE


// class Discount{
//     public $amount;
//     public $type;
//     public function calculate($amount,$type){

//         if($type == 'percent'){
//             return $amount * 0.2;
//         }else if($type == 'nominal'){
//             return $amount * 100;
//     }


//     }
// }

// $discount = new Discount();
// echo $discount->calculate(100,'percent');
// echo "\n";
// echo $discount->calculate(100,'nominal');

//GOOD CODE

/*
 * Open Closed Principle
 * Yeni strategiyalar əlavə edirik, mövcud kodu dəyişmirik
 */

interface DiscountStrategy
{
    public function apply(float $amount): float;
}

class PercentDiscount implements DiscountStrategy
{

    public function apply(float $amount): float
    {

        return $amount * 0.5;
    }
}


class NominalDiscount implements DiscountStrategy
{

    public function apply(float $amount): float
    {

        return $amount - 100;
    }
}

class DiscountCalculate
{
    private DiscountStrategy $strategy;
    public function __construct(DiscountStrategy $strategy)
    {

        $this->strategy = $strategy;
    }

    public function calculate(float $amount): float
    {

        return $this->strategy->apply($amount);
    }
}

$discount = new DiscountCalculate(new NominalDiscount());
echo $discount->calculate(200);
echo "\n";
$discount = new DiscountCalculate(new PercentDiscount());
echo $discount->calculate(200);
