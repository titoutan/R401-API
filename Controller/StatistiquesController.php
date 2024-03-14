<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../Dao/StatistiqueDao.php';

    use Symfony\Component\HttpFoundation\Request;

    $stats = $app['controllers_factory'];

    $daoStat = new StatistiqueDao();

    $stats->get('/medecins', function() use ($app) {
        $daoStat = new StatistiqueDao();
        $stats_medecins = $daoStat->getStatistiquesMedecins();
        return $app->json($stats_medecins,200);
      });

    $stats->get('/usagers', function() use ($app) {
        $daoStat = new StatistiqueDao();
        $stats_usagers = $daoStat->getStatistiquesUsagers();
        return $app->json($stats_usagers,200);
      });

    return $stats;
  