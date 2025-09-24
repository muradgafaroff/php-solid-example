<?php
/*
* Single Responsibility Principle
* Hər class yalnız bir məsuliyyətə sahib olmalıdır.
*/

// BAD CODE
// class Order

// {

//   private $item = [];
//   private $totalPrice = 0;


//   public function addItem($name = '', $price = 1, $quantity = 1)
//   {

//     $this->item[] = ['name' => (string)$name, 'price' => $price, 'quantity' => $quantity];
//   }


//   public function calculateTotalPrice()
//   {

//     $this->totalPrice = 0;

//     foreach ($this->item as $item) {


//       $this->totalPrice += $item['price'] * $item['quantity'];
//     }

//     return $this->totalPrice;
//   }

//   public function printOrders()
//   {

//     $output = '';

//     foreach ($this->item as $item) {

//       $output .= $item['name'] . ' ' . $item['price'] . ' ' . $item['quantity'] . "\n";
//     }
//     echo $output;
//   }


//   public function saveDatabase()
//   {

//     // Save to Database
//     echo 'Sved to Database';
//   }
// }


// $order = new Order();
// $order->addItem('short', '50', '2');
// $order->addItem('mont', '200', '1');
// $order->calculateTotalPrice();
// $order->printOrders();
// $order->saveDatabase();


//GOOD CODE


/**
 * Single Responsibility Principle
 *
 * Hər class yalnız bir məsuliyyətə sahib olmalıdır.
 * Burada hər class yalnız öz işini görür:
 * - Order: sifariş idarəetməsi
 * - OrderPrinter: sifarişləri çap edir
 * - OrderCalculator: sifarişin ümumi qiymətini hesablayır
 * - OrderRepository: sifarişi "database"-ə saxlayır
 */

/**
 * Class Order
 * Sifarişdəki məhsulları idarə edir.
 */
class Order
{
    private array $items = [];

    /**
     * Məhsul əlavə edir.
     *
     * @param string $name Məhsul adı
     * @param float $price Məhsul qiyməti
     * @param int $quantity Məhsul sayı
     */
    public function addItem(string $name, float $price, int $quantity): void
    {
        $this->items[] = [
            'name'     => $name,
            'price'    => $price,
            'quantity' => $quantity
        ];
    }

    /**
     * Məhsulların siyahısını qaytarır.
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}

/**
 * Class OrderPrinter
 * Sifarişləri ekrana çıxarır.
 */
class OrderPrinter
{
    public function printOrders(Order $order): void
    {
        foreach ($order->getItems() as $item) {
            echo "{$item['name']} {$item['price']} {$item['quantity']}\n";
        }
    }
}

/**
 * Class OrderCalculator
 * Sifarişin ümumi qiymətini hesablayır.
 */
class OrderCalculator
{
    public function calculateTotalPrice(Order $order): float
    {
        $totalPrice = 0;
        foreach ($order->getItems() as $item) {
            $totalPrice += $item["price"] * $item["quantity"];
        }
        return $totalPrice;
    }
}

/**
 * Class OrderRepository
 * Sifarişi "database"-ə saxlayır.
 */
class OrderRepository
{
    public function save(Order $order): string
    {
        // Burada DB yazma loqikası olacaq
        return "Saved to Database";
    }
}

// ========================
// İstifadə nümunəsi
// ========================

$order = new Order();
$order->addItem('short', 50, 2);
$order->addItem('mont', 200, 1);

$orderPrinter   = new OrderPrinter();
$orderCalculator = new OrderCalculator();
$orderRepository = new OrderRepository();

$orderPrinter->printOrders($order);

$totalPrice = $orderCalculator->calculateTotalPrice($order);
echo "Total Price: {$totalPrice}\n";

echo $orderRepository->save($order);
