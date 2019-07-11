# Nöbetci Eczaneler
Php ile günlük nöbetçi eczane listesini veren Php sınıfı

Eczanelere ait veriler <a href="https://ecza.io/" target="_blank">ecza.io</a> sitesinden alınmıştır. 

<h2>Çalışma Mantığı</h2>

Öncelikle Php Sınıfımızı Sayfaya Dahil Edelim.
```php
require_once("NobetciEczane.class.php");
```
Daha Sonra Sınıfımızı Başlatalım. 
```php
$eczane = new NobetciEczane("izmir", "bornova"); // Hangi İli ve İlçeyi İstiyorsak Parametre Verileri Gönderlim
```

Daha Sonra Nöbetçi Eczanelerimizi Çekelim.
```php
echo $eczane->getir(); // Verilerimizi Çekebiliriz.

```

Genel Olarak Tam Kodumuz Şöyle. 
```php
header("Content-type:application/jSon");
require_once("NobetciEczane.class.php"); // Sınıfımızı Sayfamıza Dahil Ettik 
$eczane = new NobetciEczane("izmir", "bornova"); // Sınıfı Başlattık 
echo $eczane->getir(); // Nöbetçi Eczanelerimizi JSON Olarak Çektik 
