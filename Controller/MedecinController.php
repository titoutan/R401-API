<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/../Model/Medecin.php';

  use Symfony\Component\HttpFoundation\Request;

  $medecins = $app['controllers_factory'];

  $medecins->get('/', function() use ($app) {
    $liste_medecins = Medecin::all();
    return $app->json($liste_medecins,200,['Status-Message' => '[R401 Rest API] Medecin introuvable']);
  });
  
  $medecins->post('/', function(Request $request) use ($app) {

    $data = json_decode($request->getContent(), true);

    validateMedecinInput($data, $app);

    $medecin = new Medecin();
    $medecin->setCivilite($app->escape($data['civilite']));
    $medecin->setNom($app->escape($data['nom']));
    $medecin->setPrenom($app->escape($data['prenom']));
    
    $medecin = Medecin::add($medecin);
    return $app->json($medecin->toArray(),201,['Status-Message' => '[R401 Rest API] Medecin ajouté']);
  });

  $medecins->get('/{medecin}', function($medecin) use ($app) {
    return $medecin ? $app->json($medecin->toArray(),200,['Status-Message' => '[R401 Rest API] Medecin trouvé']) : $app->json(null,404,['Status-Message' => '[R401 Rest API] Medecin introuvable']);
  })
  ->convert('medecin', function($medecin) {
    return Medecin::get($medecin);
  });

  $medecins->patch('/{medecin}', function(Request $request, $medecin) use ($app) {
    if (!$medecin) {
      return $app->json(null,404,['Status-Message' => '[R401 Rest API] Medecin introuvable']);
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
      return $app->json(null,404,['Status-Message' => '[R401 Rest API] Medecin introuvable']);
    }
    Medecin::delete($medecin);
    return $app->json($medecin,200,['Status-Message' => '[R401 Rest API] Medecin supprimé']);
  });

  return $medecins;

  function validateMedecinInput($data, $app) {
    if (
      !isset($data['civilite']) || 
      !isset($data['nom']) || 
      !isset($data['prenom'])
      ) {
      return $app->json(null, 400,['Status-Message' => '[R401 Rest API] Paramètre(s) manquant(s) pour créer un medecin']);
    }
    if (!array_search($data['civilite'], array('M.', 'Mme.', 'Mlle.')) && array_search($data['civilite'], array('M.', 'Mme.', 'Mlle.')) !== 0) {
      return $app->json(null, 400, ['Status-Message' => '[R401 Rest API] Civilité invalide']);
    }
  }