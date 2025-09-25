<?php

/*
* Liskov Substitution Principle
*
* Subclasses should be replaceable with their base classes without breaking the program.
* This means derived classes must be substitutable for their base classes.
*/
//BAD CODE

// class Order
// {
//     protected $items;
//     protected $totalPrice;

//     public function addItem($name = '', $price = 0, $quantity = 0)
//     {
//         $this->items[] = ['name' => $name, 'price' => $price, 'quantity' => $quantity];
//     }

//     public function calculateTotalPrice()
//     {
//         $this->totalPrice = 0;

//         foreach ($this->items as $item) {
//             $this->totalPrice += $item['price'] * $item['quantity'];
//         }
//         return $this->totalPrice;
//     }
// }

// class SpecialOrder extends Order
// {

//     public function addItem($name = '', $price = 0, $quantity = 0)
//     {
//         if ($price < 0) {
//             throw new \Exception('Price cannot be negative');
//         } 

//          parent::addItem($name, $price,$quantity);                    
//         
//     }
// }

// class Controller
// {

//     public function __construct(Order $order)
//     {

//         echo $order->calculateTotalPrice() . "\n";
//     }
// }

// $order = new Order();
// $order->addItem("short", "-50", "3");
// $controlller = new Controller($order);

// $specialOrder = new SpecialOrder();
// $specialOrder->addItem("mont", "150", "3");
// $controlller = new Controller($specialOrder);

// GOOD CODE
// =====================================
// Burada Order interface yaradılır. Interface LSP üçün vacibdir,
// çünki interface bütün implementasiya edən class-lara eyni metodları təmin etməyi məcbur edir.
// Bu yolla Controller yalnız Order tipinə bağlı olur və alt class-ların konkret davranışından asılı qalmır.
// Bu polymorphism və contract-based design təmin edir.
interface Order{
    public function calculateTotalPrice();
    public function addItem($name, $price, $quantity);
}

class NormalOrder implements Order{

    // items və totalPrice hər iki class-da saxlanılır,
    // çünki onlar metodların işləməsi üçün lazımdır.
    protected $items = [];
    protected $totalPrice;

    // addItem metodu NormalOrder üçün standart davranışı təmin edir.
    public function addItem($name = '', $price = 0, $quantity = 0)
    {
        $this->items[] = ['name' => $name, 'price' => $price, 'quantity' => $quantity];
    }

    // calculateTotalPrice metodu item-lərin cəmini hesablayır.
    public function calculateTotalPrice()
    {
        $this->totalPrice = 0;

        foreach ($this->items as $item) {
            $this->totalPrice += $item['price'] * $item['quantity'];
        }
        return $this->totalPrice;
    }
}

class SpecialOrder implements Order{
    protected $items = [];
    protected $totalPrice;

    // SpecialOrder addItem metodunda əlavə şərt yoxlaması edir.
    // Interface sayəsində bu davranış xüsusi olaraq SpecialOrder-a aid olur
    // və inheritance üzərində yaranan LSP pozulması riski aradan qalxır.
    public function addItem($name = '', $price = 0, $quantity = 0)
    {
        if ($price < 0) {
            throw new \Exception('Price cannot be negative');
        } 

        $this->items[] = ['name' => $name, 'price' => $price, 'quantity' => $quantity];                 
    }

    public function calculateTotalPrice()
    {
        $this->totalPrice = 0;

        foreach ($this->items as $item) {
            $this->totalPrice += $item['price'] * $item['quantity'];
        }
        return $this->totalPrice;
    }
}

// Controller yalnız Order interface tipində obyekt qəbul edir.
// Bu Liskov Substitution Principle-ə uyğun dizayndır,
// çünki burada NormalOrder və SpecialOrder eyni interface-ə görə işləyir.
class Controller{
    public function __construct(Order $order)
    {
        echo $order->calculateTotalPrice() . "\n";
    }
}

// NormalOrder nümunəsi
$order = new NormalOrder();
$order->addItem("short", "50", "4");
$controller = new Controller($order);

// SpecialOrder nümunəsi
// SpecialOrder-in addItem metodu əlavə yoxlama edir,
// amma interface müqaviləsinə uyğun olaraq işləyir.
// Bu yolla Liskov Substitution Principle qorunur.
$specialOrder = new SpecialOrder();
$specialOrder->addItem("mont", "250", "4");
$controller = new Controller($specialOrder);
