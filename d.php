<?php
/*
* Dependency Inversion Principle (DIP)
*
* Yüksək səviyyəli modullar (məs: OrderManager) aşağı səviyyəli modullardan (məs: MySQLConnection) 
* asılı olmamalıdır.
* Hər ikisi abstraksiyadan (interface və ya abstract class) asılı olmalıdır.
*/

// BAD CODE


// Bu class konkret olaraq MySQL ilə işləyir
// class MySQLConnection {
//     public function save($data) {
//         echo "Save data to MySQL Database\n";
//     }
// }


// OrderManager birbaşa MySQLConnection-dan asılıdır.
// Yəni biz MongoDB və ya başqa DB istəsək, kodu dəyişməliyik → bu isə DIP pozuntusudur.
// class OrderManager {
//     private $connection;

//     public function __construct(MySQLConnection $connection) {
//         $this->connection = $connection;
//     }

//     public function save($order) {
//         $this->connection->save($order);
//     }
// }


//GOOD CODE – Dependency Inversion Principle (DIP)

// Abstraksiya yaradılır: 
// OrderManager konkret class-a deyil, bu interface-ə bağlı olacaq.
interface OrderRepostoryInterface {
    public function save($data);
}

// Konkret implementasiya (MySQLConnection).
// Bu class database-ə save etməyi özünə uyğun reallaşdırır.
class MySQLConnection implements OrderRepostoryInterface {
    public function save($data) {
        echo "Save data to MySQL Database\n";
    }
}

// Başqa bir implementasiya (Redis).
// Artıq OrderManager Redis ilə də işləyə bilir, dəyişiklik etmədən.
class Redis implements OrderRepostoryInterface {
    public function save($data) {
        echo "Save data to Redis\n";
    }
}

// Yüksək səviyyəli class (OrderManager).
// Diqqət et: bu class artıq birbaşa MySQLConnection-dan asılı deyil!
// Yalnız abstraksiyadan (OrderRepostoryInterface) asılıdır.
class OrderManager {
    private $connection;

    // Konstruktor interface qəbul edir (dependency injection).
    public function __construct(OrderRepostoryInterface $connection) {
        $this->connection = $connection;
    }

    // Biznes səviyyəli metod – sifarişi saxlamaq.
    // Əslində işi aşağı səviyyəli class (MySQL/Redis) görür.
    public function saveOrder($data) {
        $this->connection->save($data);
    }
}

// İstifadə nümunələri:
// İndi istənilən storage ilə işləyə bilərik, OrderManager kodunu dəyişmədən.
$order = new OrderManager(new Redis());
$order->saveOrder("order1");   // Save data to Redis

$order = new OrderManager(new MySQLConnection());
$order->saveOrder("order2");   // Save data to MySQL Database
