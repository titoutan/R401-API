<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/../Model/Consultation.php';
  require_once __DIR__ . '/../Model/Usager.php';
  require_once __DIR__ . '/../Model/Medecin.php';

  use Symfony\Component\HttpFoundation\Request;

  $consultations = $app['controllers_factory'];

  $consultations->get('/', function() use ($app) {
    $liste = Consultation::all();
    return $app->json($liste,200,['Status-Message' => '[R401 Rest API] Liste des consultations']);
  });
  
  $consultations->post('/', function(Request $request) use ($app) {

    $data = json_decode($request->getContent(), true);

    if ($err = validateConsultationInput($data, $app)) {
      return $err;
    }

    $consultation = new Consultation();
    $consultation->setIdUsager($app->escape($data['id_usager']));
    $consultation->setIdMedecin($app->escape($data['id_medecin']));
    $consultation->setDuree($app->escape($data['duree_consult']));
    $consultation->setDateConsult(date_create_immutable_from_format('d/m/Y',$app->escape($data['date_consult']) ? date_create_immutable_from_format('d/m/Y',$app->escape($data['date_consult'])) : date_create_immutable_from_format('d/m/y',$data['date_consult'])));
    $consultation->setHeureConsult(date_create_immutable_from_format('H:i',$app->escape($data['heure_consult'])));
    
    $consultation = Consultation::add($consultation);
    return $app->json($consultation->toArray(),201,['Status-Message' => '[R401 Rest API] Consultation ajoutée']);
  });

  $consultations->get('/{consultation}', function($consultation) use ($app) {
    return $consultation ? $app->json($consultation->toArray(),200,['Status-Message' => '[R401 Rest API] Consultation trouvée']) : $app->json(null,404,['Status-Message' => '[R401 Rest API] Consultation introuvable']);
  })
  ->convert('consultation', function($consultation) {
    return Consultation::get($consultation);
  });

  $consultations->patch('/{consultation}', function(Request $request, $consultation) use ($app) {
    if (!$consultation) {
      return $app->json(null,404,['Status-Message' => '[R401 Rest API] Consultation introuvable']);
    }
    $data = json_decode($request->getContent(), true);

    $consultation = $consultation->toArray();
    foreach ($data as $key => $value) {
      $consultation[$key] = $app->escape($value);
    }

    if ($err = validateConsultationInput($consultation, $app)) {
      return $err;
    }

    $consultation = new Consultation($consultation);
    $consultation = Consultation::update($consultation);
    return $app->json($consultation->toArray(),200,['Status-Message' => '[R401 Rest API] Consultation modifiée']);
  })
  ->convert('consultation', function($consultation) {
    return Consultation::get($consultation);
  });
  
  $consultations->delete('/{consultation}', function($consultation) use ($app) {
    if (!Consultation::get($consultation)) {
      return $app->json(null,404,['Status-Message' => '[R401 Rest API] Consultation introuvable']);
    }
    Consultation::delete($consultation);
    return $app->json($consultation,200,['Status-Message' => '[R401 Rest API] Consultation supprimée']);
  });

  return $consultations;

  function validateConsultationInput($data, $app) {
    if (
      !isset($data['id_usager']) || 
      !isset($data['id_medecin']) || 
      !isset($data['duree_consult']) ||
      !isset($data['date_consult']) ||
      !isset($data['heure_consult']) 
      ) {
      return $app->json(null, 400,['Status-Message' => '[R401 Rest API] Paramètre(s) manquant(s) pour créer un medecin']);
    }
    if (!Medecin::get($data['id_medecin'])) {
      return $app->json(null,400,['Status-Message' => '[R401 Rest API] Medecin introuvable']);
    }
    if (!Usager::get($data['id_usager'])) {
      return $app->json(null,400,['Status-Message' => '[R401 Rest API] Usager introuvable']);
    }
    if (!(date_create_immutable_from_format('d/m/Y',$data['date_consult']) || date_create_immutable_from_format('d/m/y',$data['date_consult']))) {
      return $app->json(null,400,['Status-Message' => '[R401 Rest API] Date de consultation invalide']);
    }
    if (!date_create_immutable_from_format('H:i',$data['heure_consult'])) {
      return $app->json(null,400,['Status-Message' => '[R401 Rest API] Heure de consultation invalide']);
    }
    if ($data['duree_consult'] < 0) {
      return $app->json(null,400,['Status-Message' => '[R401 Rest API] Duree de consultation invalide']);
    }
    $consultsMedecin = Consultation::getByMedecinAndDate($data['id_medecin'],date_create_immutable_from_format('d/m/Y',$data['date_consult']) ? date_create_immutable_from_format('d/m/Y',$data['date_consult']) : date_create_immutable_from_format('d/m/y',$data['date_consult']));
    $start = strtotime($data['heure_consult']);
    $end = strtotime($data['heure_consult']) + $data['duree_consult']*60;
    foreach ($consultsMedecin as $consult) {
      if (max($start, strtotime($consult['heure_consult'])) < min($end, strtotime($consult['heure_consult'])+$consult['duree_consult']*60)) {
        return $app->json(null,409,['Status-Message' => '[R401 Rest API] Consultation non disponible']);
      }
    }

    return false;
  }