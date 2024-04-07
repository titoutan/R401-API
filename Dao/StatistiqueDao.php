<?php
  require_once __DIR__ . '/../connexion.php';
  class StatistiqueDao {
    private PDO $pdo;
    public function __construct() {
      $this->pdo = Connexion::getInstance()->getPdo();
    }

    //-----------------------------------------------------------------------------------------

    public function getStatistiquesMedecins() {
        $getStatistiques = $this->pdo->query(
            "SELECT SUM(C.duree_consult) AS DureeTotaleConsult , C.id_medecin AS id
            FROM consultation C, medecin M
            WHERE
                C.id_medecin = M.id_medecin
                AND C.date_consult < CURDATE()
                AND (C.date_consult < CURDATE() OR (C.date_consult = CURDATE() AND C.heure_consult < CURTIME()))
            GROUP BY C.id_medecin
            ORDER BY DureeTotaleConsult DESC"
        );
        $tableauSortie = $getStatistiques->fetchAll(PDO::FETCH_ASSOC);
        return $tableauSortie;
    }

    //-----------------------------------------------------------------------------------------

    
    public function getStatistiquesUsagers() {
        return [
            "HommeAvant25" => $this->getHommeBefore25(),
            "HommeAvant50" => $this->getHommeBetween25And50(),
            "HommeApres50" => $this->getHommeAfter50(),
            "FemmeAvant25" => $this->getFemmeBefore25(),
            "FemmeAvant50" => $this->getFemmeBetween25And50(),
            "FemmeApres50" => $this->getFemmeAfter50(),
        ];
    }

    //-----------------------------------------------------------------------------------------

    private function getHommeBefore25() {
        return $this->getIndividuBefore25("H")['Total'];
    }
    private function getHommeBetween25And50() {
        return $this->getIndividuBetween25And50("H")['Total'];
    }
    private function getHommeAfter50() {
        return $this->getIndividuAfter50("H")['Total'];
    }
    
    private function getFemmeBefore25() {
        return $this->getIndividuBefore25("F")['Total'];
    }
    private function getFemmeBetween25And50() {
        return $this->getIndividuBetween25And50("F")['Total'];
    }
    private function getFemmeAfter50() {
        return $this->getIndividuAfter50("F")['Total'];
    }

    //----------------------------------------------------------------------------------------

    private function getIndividuBefore25(String $sexe) {
        $getStatistiques = $this->pdo->query(
            "SELECT COUNT(*) AS Total
            FROM consultation C, usager U
            WHERE 
                U.id_usager = C.id_usager
                AND U.sexe = '$sexe'
                AND U.date_nais > DATE_SUB(NOW(), INTERVAL 25 YEAR)
            "
        );
        $tableauSortie = $getStatistiques->fetch(PDO::FETCH_ASSOC);
        return $tableauSortie;
    }

    private function getIndividuBetween25and50(String $sexe) {
        $getStatistiques = $this->pdo->query(
            "SELECT COUNT(*) AS Total
            FROM consultation C, usager U
            WHERE 
                U.id_usager = C.id_usager
                AND U.sexe = '$sexe'
                AND U.date_nais BETWEEN DATE_SUB(NOW(), INTERVAL 50 YEAR) AND DATE_SUB(NOW(), INTERVAL 25 YEAR)
            "
        );
        $tableauSortie = $getStatistiques->fetch(PDO::FETCH_ASSOC);
        return $tableauSortie;
    }

    private function getIndividuAfter50(String $sexe) {
        $getStatistiques = $this->pdo->query(
            "SELECT COUNT(*) AS Total
            FROM consultation C, usager U
            WHERE 
                U.id_usager = C.id_usager
                AND U.sexe = '$sexe'
                AND U.date_nais < DATE_SUB(NOW(), INTERVAL 50 YEAR)
            "
        );
        $tableauSortie = $getStatistiques->fetch(PDO::FETCH_ASSOC);
        return $tableauSortie;
    }
}
