<?php

require_once __DIR__ . '/../connexion.php';

class ConsultationDao{

    private PDO $pdo;
    public function __construct() {
      $this->pdo = Connexion::getInstance()->getPdo();
    }

    public function findAll(): array {
        $query = 'SELECT * FROM consultation';
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getById($id) {
        $query = 'SELECT * FROM consultation WHERE id_consult = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new Consultation($result) : false;
    }

    public function getConsultationByIdMedecin($id):array {
        $query = 'SELECT * FROM consultation WHERE id_medecin = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getConsultationByIdUsager($id):array {
        $query = 'SELECT * FROM consultation WHERE id_usager = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getConsultationByMedecinForDate($idMedecin,$dateParam): array {
        $query = 'SELECT * FROM consultation WHERE id_medecin = :idMedecin AND date_consult = :dateParam';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':idMedecin', $idMedecin);
        $stmt->bindValue(':dateParam', $dateParam->format('Y-m-d'));
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getConsultationByUsagerForDate($idUsager,$dateParam): array {
        $query = 'SELECT * FROM consultation WHERE id_usager = :idUsager AND date_consult = :dateParam';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':idUsager', $idUsager);
        $stmt->bindValue(':dateParam', $dateParam->format('Y-m-d'));
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function add(Consultation $consultation){
        $query = 'INSERT INTO consultation (date_consult,heure_consult,duree_consult,id_medecin,id_usager) VALUES (:date_consult,:heure_consult,:duree_consult,:id_medecin,:id_usager)';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':date_consult', $consultation->getDateConsult()->format('Y-m-d'));
        $stmt->bindValue(':heure_consult', $consultation->getHeureConsult()->format('H:i'));
        $stmt->bindValue(':duree_consult', $consultation->getDuree());
        $stmt->bindValue(':id_medecin', $consultation->getIdMedecin());
        $stmt->bindValue(':id_usager', $consultation->getIdUsager());
        
        $this->pdo->beginTransaction();
        $stmt->execute();
        $id = $this->pdo->lastInsertId();

        $this->pdo->commit();
        return $this->getById($id);
    }

    public function update(Consultation $consultation) {
        $query = 'UPDATE consultation SET date_consult = :date_consult, heure_consult = :heure_consult, id_medecin = :id_medecin, id_usager = :id_usager, duree_consult = :duree_consult WHERE id_consult = :id_consult';
        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':date_consult', $consultation->getDateConsult()->format('Y-m-d'));
        $stmt->bindValue(':heure_consult', $consultation->getHeureConsult()->format('H:i'));
        $stmt->bindValue(':duree_consult', $consultation->getDuree());
        $stmt->bindValue(':id_medecin', $consultation->getIdMedecin());
        $stmt->bindValue(':id_usager', $consultation->getIdUsager());
        $stmt->bindValue(':id_consult', $consultation->getIdConsult());
      
        $stmt->execute();
      
        return $this->getById($consultation->getIdConsult());
    }

    public function delete(int $id) {
        $query = 'DELETE FROM consultation WHERE id_consult = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function getAllIdConsultationByMedecin(int $idMedecin) {
        $query = 'SELECT id_consult FROM consultation WHERE id_medecin = :id_medecin';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_medecin', $idMedecin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllIdConsultationByUsager(int $idUsager) {
        $query = 'SELECT id_consult FROM consultation WHERE id_usager = :id_usager';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_usager', $idUsager);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
}
