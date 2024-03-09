<?php
  require_once __DIR__ . '/vendor/autoload.php';
  require_once __DIR__ . '/Model/Usager.php';

  use Silex\Application;

  $app = new Application();
  $app['debug'] = true;

  //On monte les controlleurs
  $app->mount('/usagers', include 'Controller/UsagerController.php');

  $app->run();