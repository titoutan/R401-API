<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/../Model/Usager.php';
  require_once __DIR__ . '/../Model/Medecin.php';

  use Symfony\Component\HttpFoundation\Request;

  $usagers = $app['controllers_factory'];

  $usagers->get('/', function() use ($app) {
    $liste_usagers = Usager::all();
    return $app->json($liste_usagers,200);
  });
  
  $usagers->post('/', function(Request $request) use ($app) {

    $data = json_decode($request->getContent(), true);

    $erreurChamps = validateUsagerInput($data, $app);
    if ($erreurChamps) {
      return $erreurChamps;
    }

    $usager = new Usager();
    $usager->setCivilite($app->escape($data['civilite']));
    $usager->setNom($app->escape($data['nom']));
    $usager->setPrenom($app->escape($data['prenom']));
    $usager->setSexe($app->escape($data['sexe']));
    $usager->setAdresse($app->escape($data['adresse']));
    $usager->setCodePostal($app->escape($data['code_postal']));
    $usager->setVille($app->escape($data['ville']));
    $usager->setDateNais(date_create_immutable_from_format('d/m/Y', $app->escape($data['date_nais'])));
    $usager->setLieuNais($app->escape($data['lieu_nais']));
    $usager->setNumSecu($app->escape($data['num_secu']));
    
    $usager = Usager::add($usager);
    return $app->json($usager->toArray(),201);
  });

  $usagers->get('/{usager}', function($usager) use ($app) {
    return $usager ? $app->json($usager->toArray(),200) : $app->json('[R401 Rest API] Usager introuvable',404);
  })
  ->convert('usager', function($usager) {
    return Usager::get($usager);
  });

  $usagers->patch('/{usager}', function(Request $request, $usager) use ($app) {
    if (!$usager) {
      return $app->json('[R401 Rest API] Usager introuvable',404);
    }
    $data = json_decode($request->getContent(), true);
    $erreurChamps = validateUsagerInput($data, $app);
    if ($erreurChamps) {
      return $erreurChamps;
    }
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
    if (!Usager::get($usager)) {
      return $app->json('[R401 Rest API] Usager introuvable',404);
    }
    Usager::delete($usager);
    return $app->json($usager,200);
  });

  return $usagers;

  function validateUsagerInput($data, $app) {
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
      return $app->json('[R401 Rest API] Paramètre(s) manquant(s) pour créer un usager',400);
    }
    //format de la date
    if (!$date_nais = date_create_immutable_from_format('d/m/Y', $data['date_nais'])) {
      return $app->json('[R401 Rest API] format date invalide',400);
    }
    if (!array_search($data['civilite'], array('M.', 'Mme.', 'Mlle.')) && array_search($data['civilite'], array('M.', 'Mme.', 'Mlle.')) !== 0) {
      return $app->json('[R401 Rest API] Civilité invalide',400);
    }
    if ((!preg_match('/[12][0-9]{12}/', $data['num_secu']) || Usager::getByNumero($data['num_secu']))) {
      return $app->json('[R401 Rest API] Numéro de sécurité sociale invalide',400);
    }
    if (!preg_match('/[0-9]{5}/', $data['code_postal'])) {
      return $app->json('[R401 Rest API] Code postal invalide',400);
    }
    if (isset($data['id_medecin']) && !Medecin::get($data['id_medecin'])) {
      return $app->json('[R401 Rest API] Medecin introuvable',404);
    }
    return false;
  }