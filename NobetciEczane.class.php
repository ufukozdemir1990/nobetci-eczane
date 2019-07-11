<?php
    /**
     * 	@author: Ufuk OZDEMIR
     * 	@mail: ufuk.ozdemir1990@gmail.com || info@ufukozdemir.website
     * 	@website: ufukozdemir.website
     */

    class NobetciEczane {

        private $sehir; // Girilecek İl
        private $ilce;  // Girilecek İlçe
        private $tarih;  // Girilecek İlçe
        private $gelenVeri; // Çektiğimiz Veriler
        private $verilerArray = array(); // göndereceğimiz JSON Verileri

        /**
         * NobetciEczane constructor.
         * @param $il
         * @param null $ilce
         */
        public function __construct($il, $ilce = null){
            $this->sehir = $il;
            $this->ilce = $ilce;
            $this->gelenVeri = $this->curl("https://ecza.io/".$this->cevir($this->sehir)."-".$this->cevir($this->ilce)."-nobetci-eczane");
            $this->parcala();
        }

        /**
         * Veri Parçala
         */
        private function parcala(){
            preg_match_all('#<div class="alert alert-info" role="alert">(.*?)</div>#si', $this->gelenVeri,$alert);
            preg_match_all('#<p>(.*?)</p>#si', $alert[0][0],$baslik);
            preg_match_all('#<h4 class="alert-heading">(.*?)</h4>#si', $alert[0][0],$tarih);
            preg_match_all('#<strong>(.*?)</strong>#si', $baslik[0][0],$toplam);
            preg_match_all('#<div class="Proin-text-wrap">(.*?)</div>#si', $this->gelenVeri,$nobetci_ezcaneler);
            $toplam_nobetci = strip_tags($toplam[0][0]);
            $this->tarih = explode(' - ', strip_tags($tarih[0][0]));

            if(empty($toplam_nobetci)) die("Nöbetçi Eczane Bulunamadı!");
            $verilerArray[0] = 0;

            for ($i = 0; $i < $toplam_nobetci; $i++) {
                preg_match_all('#<h6 style="margin-top:5px;" >(.*?)</h6>#si', $nobetci_ezcaneler[0][$i],$eczane_adi);
                preg_match_all('#<p>(.*?)</p>#si', $nobetci_ezcaneler[0][$i],$eczane_bilgi);

                if (!empty(strip_tags($eczane_adi[0][0]))) {
                    $this->verilerArray[$i]['eczane_tarih']     = $this->tarih[0];
                    $this->verilerArray[$i]['eczane_adi']       = strip_tags($eczane_adi[0][0]);
                    $this->verilerArray[$i]['eczane_adres']     = str_replace('Adres: ', '', strip_tags($eczane_bilgi[0][0]));
                    $this->verilerArray[$i]['eczane_telefon']   = str_replace('Telefon: ', '', strip_tags($eczane_bilgi[0][1]));
                }
            }
        }

        /**
         * Önbellekleme ile Veri Getirme
         * @return false|string
         */
        public function getir() {
            $eczane = __DIR__.'/nobetci-eczaneler.json';
            if (file_exists($eczane)) {
                json_encode(file_get_contents($eczane), TRUE);

                $json = json_decode(file_get_contents($eczane));
                $json_eczane_adi = $json[0]->eczane_adi;
                $veri_eczane_adi = $this->verilerArray[0]['eczane_adi'];

                if($json_eczane_adi != $veri_eczane_adi && $this->tarih != strftime('%e %B %Y')){
                    file_put_contents($eczane, json_encode($this->verilerArray));
                }

            } else {
                file_put_contents($eczane, json_encode($this->verilerArray));
            }

            return file_get_contents($eczane);
        }

        /**
         * String Çevirme
         * @param $string
         * @return mixed|string|string[]|null
         */
        private function cevir($string) {
            $tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç');
            $en = array('s','s','i','i','g','g','u','u','o','o','c','c');
            $string = str_replace($tr, $en, $string);
            $string = strtolower($string);
            $string = preg_replace('/&.+?;/', '', $string);
            $string = preg_replace('/[^%a-z0-9 _-]/', '', $string);
            $string = preg_replace('/\s+/', '-', $string);
            $string = preg_replace('|-+|', '-', $string);
            $string = trim($string, '-');
            return $string;
        }

        /**
         * Curl ile Veri Çekme
         * @param $link
         * @return bool|string
         */
        public function curl($link){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $source = curl_exec($ch);
            curl_close($ch);
            return $source;
        }

    }
