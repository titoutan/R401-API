<?php
  require_once __DIR__ . '/vendor/autoload.php';
  require_once __DIR__ . '/Model/Usager.php';
  require_once __DIR__ . '/utils.php';

  use Silex\Application;
  use Symfony\Component\HttpFoundation\Request;

  $app = new Application();
  $app['debug'] = true;
  
  $app->before(
    function (Request $request) use ($app) {
      if (!$token = get_bearer_token()) {
        return $app->json('[R401 Rest API] Bearer token manquant', 401);
      }

      $curl_handle=curl_init();
      curl_setopt($curl_handle, CURLOPT_URL,'http://a4authapi.alwaysdata.net?token='.$token);
      curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl_handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      $result = curl_exec($curl_handle);
      curl_close($curl_handle);
      if ($result === false) {
        return $app->json('[R401 Rest API] Erreur de connexion', 500);
      }
      $result = json_decode($result,true);
      if ($result['data']) {
        return;
      }
      else {
        return $app->json('[R401 Rest API] Token invalide', 403);
      }
    }
  );

  //On monte les controlleurs
  $app->mount('/usagers', include 'Controller/UsagerController.php');
  $app->mount('/medecins', include 'Controller/MedecinController.php');

  $app->run();