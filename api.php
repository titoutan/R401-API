<?php
  require_once __DIR__ . '/vendor/autoload.php';
  require_once __DIR__ . '/Model/Usager.php';
  require_once __DIR__ . '/utils.php';

  use Silex\Application;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;

  $app = new Application();
  $app['debug'] = true;
  
  //Vérification de la connexion de l'utilisateur
  $app->before(
    function () use ($app) {
      if (!$token = get_bearer_token()) {
        return $app->json(null, 401, ['Status-Message' => '[R401 Rest API] Bearer token manquant']);
      }
      //Requête à l'api d'authentification
      $curl_handle=curl_init();
      curl_setopt($curl_handle, CURLOPT_URL,'http://a4authapi.alwaysdata.net?token='.$token);
      curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl_handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      $result = curl_exec($curl_handle);
      curl_close($curl_handle);
      //Si la requête à échoué (ne devrait jamais apparaître)
      if ($result === false) {
        return $app->json(null, 500, ['Status-Message' => '[R401 Rest API] Erreur de connexion']);
      }
      $result = json_decode($result,true);
      //Si le token est valide, l'api d'authentification renvoie true, sinon false
      if ($result['data']) {
        return;
      }
      else {
        return $app->json(null, 403, ['Status-Message' => '[R401 Rest API] Token invalide']);
      }
    }
  );

  //Formatage de la reponse
  $app->after(
    function(Request $request, Response $response) {
      $response->headers->set('Access-Control-Allow-Origin', '*');
      $data = json_decode($response->getContent(),true);
      $status_code = $response->getStatusCode();
      $status_message = $response->headers->get('Status-Message');
      $body = ['status_code' => $status_code, 'status_message' => $status_message];
      if (!empty($data)) {
        $body['data'] = $data;
      }
      $response->setContent(json_encode($body));
    }
  );

  //On monte les controlleurs
  $app->mount('/usagers', include 'Controller/UsagerController.php');
  $app->mount('/medecins', include 'Controller/MedecinController.php');
  $app->mount('/consultations', include 'Controller/ConsultationController.php');
  $app->mount('/stats', include 'Controller/StatistiquesController.php');

  $app->run();