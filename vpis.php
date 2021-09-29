<?php

include 'hauth/src/autoload.php';
include '../config.php';

use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;
use Hybridauth\Storage\Session;

$storage = new Session();


try {

    $hybridauth = new Hybridauth($hybridauthConfig);

     if (isset($_GET['via'])) {
             $storage->set('provider', $_GET['via']);
         }

         if ($provider = $storage->get('provider')) {
                 $hybridauth->authenticate($provider);
                 $storage->set('provider', null);
             }


    $hybridauth->authenticate($provider);

    $adapters = $hybridauth->getConnectedAdapters();

    HttpClient\Util::redirect('https://it-place.si/vnos.php');
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
