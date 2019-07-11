# Nöbetci Eczaneler
Php ile günlük nöbetçi eczane listesini veren Php sınıfı

Eczanelere ait veriler <a href="https://ecza.io/" target="_blank">ecza.io</a> sitesinden alınmıştır. 

Ecza.io sitesinden çekilen veriler, json olarak tutulabilir. Bu sayede her seferinde Ecza.io sitesinden çekilmeyeceği için performans artışı sağlanabilir.

<h2>Çalışma Mantığı</h2>

Öncelikle Php Sınıfımızı Sayfaya Dahil Edelim.
```php
require_once("NobetciEczane.class.php");
```
Daha Sonra Sınıfımızı Başlatalım. 
```php
// Hangi İli ve İlçeyi İstiyorsak Parametre Verileri Gönderlim
$eczane = new NobetciEczane("izmir", "bornova");
```

Daha Sonra Nöbetçi Eczanelerimizi Çekelim.
```php
// Verilerimizi Çekebiliriz.
echo $eczane->getir();
```

Genel Olarak Tam Kodumuz Şöyle. 
```php
header("Content-type:application/jSon");

// Sınıfımızı Sayfamıza Dahil Ettik 
require_once("NobetciEczane.class.php");

// Sınıfı Başlattık 
$eczane = new NobetciEczane("izmir", "bornova");

// Nöbetçi Eczanelerimizi JSON Olarak Çektik 
echo $eczane->getir();
```
