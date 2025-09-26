<?php
/*
* Interface Segregation Principle (ISP)
*
* Müştərilər (class-lar) ehtiyac duymadıqları metodları implementasiya etməyə məcbur olmamalıdır.
* Yəni, interface-lər çox böyük olmamalı, konkret məqsədlər üçün kiçik hissələrə bölünməlidir.
*/

// BAD CODE


// Burada Order interfeysi 3 metod ehtiva edir:
// - calculateTotalPrice()
// - downloadOrder()
// - shipOrder()
// Amma bütün Order tipləri bu 3 metodu istifadə etmir.
// Bu səbəbdən bəzi class-lar boş metod implementasiyası etməli olacaq.
// Bu isə Interface Segregation Principle-in pozulmasıdır.
// interface Order{
//     public function calculateTotalPrice();
//     public function downloadOrder();
//     public function shipOrder();
// }

// inStoreOrder yalnız calculateTotalPrice istifadə edir.
// Amma Order interfeysi ona 3 metodu zorla verib.
// Ona görə inStoreOrder əslində istifadə etmədiyi metodları da implementasiya etməyə məcbur olacaq.
// Bu, ISP prinsipinə ziddir.
// class inStoreOrder implements Order{
//     public function calculateTotalPrice(){
//         echo "calculate Total Price";
//     }

//     // ISP pozulması → inStoreOrder üçün downloadOrder və shipOrder lazımsızdır.
//     // Amma interface bunları məcbur edir → bu bad code-dur.
//     public function downloadOrder(){}
//     public function shipOrder(){}
// }

// onlineOrder üçün shipOrder, calculateTotalPrice və downloadOrder hamısı lazımdır.
// Yəni onlineOrder bu interfeysi normal implementasiya edir.
// Amma problem buradadır ki, interfeys hər kəsə eyni şeyi diktə edir,
// halbuki inStoreOrder üçün bunların hamısı mənasızdır.
// 
// GOOD CODE

// Ayrı-ayrı kiçik interfeyslər yaradırıq.
// Hər interfeys yalnız bir məsuliyyət daşıyır.
// Beləliklə, class-lar yalnız özlərinə lazım olan interfeysi implementasiya edirlər.

// Yalnız ümumi qiymət hesablanması ilə bağlı interfeys
interface CalculateOrder {
    public function calculateTotalPrice();
}

// Yalnız download əməliyyatı ilə bağlı interfeys
interface Download {
    public function downloadOrder();
}

// Yalnız shipping (çatdırılma) ilə bağlı interfeys
interface ShipOrder {
    public function shipOrder();
}


// inStoreOrder üçün yalnız calculateTotalPrice lazımdır.
// Ona görə yalnız CalculateOrder interfeysini implementasiya edir.
// Artıq lazımsız metodları implementasiya etməyə məcbur deyil → ISP qorunur.
class inStoreOrder implements CalculateOrder {
    public function calculateTotalPrice(){
        echo "calculate order total price";
    }
}


// onlineOrder həm hesablamanı, həm download-u, həm də ship əməliyyatını dəstəkləyir.
// Ona görə üç interfeysi birdən implementasiya edir.
// Yəni hər class yalnız özünə lazım olan interfeysləri implementasiya edir → doğru yanaşma.
class onlineOrder implements CalculateOrder, Download, ShipOrder {
    public function calculateTotalPrice(){
        echo "calculate order total price";
    }

    public function downloadOrder(){
        echo "download order";
    }

    public function shipOrder(){
        echo "ship order";  
    }   
}
 
