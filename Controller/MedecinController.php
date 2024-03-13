<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/../Model/Medecin.php';

  use Symfony\Component\HttpFoundation\Request;

  $medecins = $app['controllers_factory'];

  $medecins->get('/', function() use ($app) {
    $liste_medecins = Medecin::all();
    return $app->json($liste_medecins,200);
  });
  
  $medecins->post('/', function(Request $request) use ($app) {

    $data = json_decode($request->getContent(), true);

    validateMedecinInput($data, $app);

    $medecin = new Medecin();
    $medecin->setCivilite($app->escape($data['civilite']));
    $medecin->setNom($app->escape($data['nom']));
    $medecin->setPrenom($app->escape($data['prenom']));
    
    $medecin = Medecin::add($medecin);
    return $app->json($medecin->toArray(),201);
  });

  $medecins->get('/{medecin}', function($medecin) use ($app) {
    return $medecin ? $app->json($medecin->toArray(),200) : $app->json('[R401 Rest API] Medecin introuvable',404);
  })
  ->convert('medecin', function($medecin) {
    return Medecin::get($medecin);
  });

  $medecins->patch('/{medecin}', function(Request $request, $medecin) use ($app) {
    if (!$medecin) {
      return $app->json('[R401 Rest API] Medecin introuvable',404);
    }
    $data = json_decode($request->getContent(), true);
    $medecin = $medecin->toArray();
    foreach ($data as $key => $value) {
      $medecin[$key] = $app->escape($value);
    }
    $medecin = new Medecin($medecin);
    $medecin = Medecin::update($medecin);
    return $app->json($medecin->toArray(),200);
  })
  ->convert('medecin', function($medecin) {
    return Medecin::get($medecin);
  });
  
  $medecins->delete('/{medecin}', function($medecin) use ($app) {
    if (!Medecin::get($medecin)) {
      return $app->json('[R401 Rest API] Medecin introuvable',404);
    }
    Medecin::delete($medecin);
    return $app->json($medecin,200);
  });

  return $medecins;

  function validateMedecinInput($data, $app) {
    if (
      !isset($data['civilite']) || 
      !isset($data['nom']) || 
      !isset($data['prenom'])
      ) {
      return $app->abort(400, '[R401 Rest API] Paramètre(s) manquant(s) pour créer un medecin');
    }
    if (!array_search($data['civilite'], array('M.', 'Mme.', 'Mlle.')) && array_search($data['civilite'], array('M.', 'Mme.', 'Mlle.')) !== 0) {
      return $app->abort(400, '[R401 Rest API] Civilité invalide');
    }
  }