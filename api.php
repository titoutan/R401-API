<?php
  require_once __DIR__ . '/vendor/autoload.php';
  require_once __DIR__ . '/Model/Usager.php';
  require_once __DIR__ . 'utils.php';

  use Silex\Application;

  $app = new Application();
  $app['debug'] = true;

  //On monte les controlleurs
  $app->mount('/usagers', include 'Controller/UsagerController.php');
  $app->mount('/medecins', include 'Controller/MedecinController.php');

  $app->run();