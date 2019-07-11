<?php
    /**
     * 	@author: Ufuk OZDEMIR
     * 	@mail: ufuk.ozdemir1990@gmail.com || info@ufukozdemir.website
     * 	@website: ufukozdemir.website
     */

    header("Content-type:application/json");
    require_once(__DIR__."/NobetciEczane.class.php");
    $eczane = new NobetciEczane($_GET['il'], $_GET['ilce']);
    echo $eczane->getir();
