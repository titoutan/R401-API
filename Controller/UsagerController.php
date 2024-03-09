<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/../Model/Usager.php';

  use Symfony\Component\HttpFoundation\Request;

  $usagers = $app['controllers_factory'];

  $usagers->get('/', function() use ($app) {
    $liste_usagers = Usager::all();
    return $app->json($liste_usagers,200);
  });
  
  $usagers->post('/', function(Request $request) use ($app) {

    $data = json_decode($request->getContent(), true);

    validateInput($data, $app);

    $usager = new Usager();
    $usager->setCivilite($app->escape($data['civilite']));
    $usager->setNom($app->escape($data['nom']));
    $usager->setPrenom($app->escape($data['prenom']));
    $usager->setSexe($app->escape($data['sexe']));
    $usager->setAdresse($app->escape($data['adresse']));
    $usager->setCodePostal($app->escape($data['code_postal']));
    $usager->setVille($app->escape($data['ville']));
    $usager->setDateNais(date_create_immutable_from_format('Y-m-d', $app->escape($data['date_nais'])));
    $usager->setLieuNais($app->escape($data['lieu_nais']));
    $usager->setNumSecu($app->escape($data['num_secu']));
    
    $usager = Usager::add($usager);
    return $app->json($usager->toArray(),201);
  });

  $usagers->get('/{usager}', function($usager) use ($app) {
    return $app->json($usager->toArray(),200);
  })
  ->convert('usager', function($usager) {
    return Usager::get($usager);
  });

  $usagers->patch('/{usager}', function(Request $request, $usager) use ($app) {
    $data = json_decode($request->getContent(), true);
    $usager = $usager->toArray();
    foreach ($data as $key => $value) {
      $usager[$key] = $app->escape($value);
    }
    $usager = new Usager($usager);
    $usager = Usager::update($usager);
    return $app->json($usager->toArray(),200);
  })
  ->convert('usager', function($usager) {
    return Usager::get($usager);
  });
  
  $usagers->delete('/{usager}', function($usager) use ($app) {
    Usager::delete($usager);
    return $app->json($usager,200);
  });

  return $usagers;

  function validateInput($data, $app) {
    if (
      !isset($data['civilite']) || 
      !isset($data['nom']) || 
      !isset($data['prenom']) || 
      !isset($data['sexe']) || 
      !isset($data['adresse']) || 
      !isset($data['code_postal']) || 
      !isset($data['ville']) || 
      !isset($data['date_nais']) || 
      !isset($data['lieu_nais']) || 
      !isset($data['num_secu']) 
      ) {
      return $app->abort(400, '[R401 Rest API] Paramètre(s) manquant(s) pour créer un usager');
    }
    //format de la date
    if (!$date_nais = date_create_immutable_from_format('d/m/Y', $data['date_nais'])) {
      return $app->abort(400, '[R401 Rest API] format date invalide');
    }
    if (!array_search($data['civilite'], array('M.', 'Mme.', 'Mlle.')) && array_search($data['civilite'], array('M.', 'Mme.', 'Mlle.')) !== 0) {
      return $app->abort(400, '[R401 Rest API] Civilité invalide');
    }
    if (!preg_match('/[12][0-9]{12}/', $data['num_secu'])) {
      return $app->abort(400, '[R401 Rest API] Numéro de sécurité sociale invalide');
    }
    if (!preg_match('/[0-9]{5}/', $data['code_postal'])) {
      return $app->abort(400, '[R401 Rest API] Code postal invalide');
    }
  }