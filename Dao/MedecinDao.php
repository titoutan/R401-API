<?php
  require_once __DIR__ . '/../connexion.php';
  class MedecinDao {
    private PDO $pdo;
    public function __construct() {
      $this->pdo = Connexion::getInstance()->getPdo();
    }
    public function findAll(): array {
      $query = 'SELECT * FROM medecin';
      $stmt = $this->pdo->query($query);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
    public function add(Medecin $medecin) : Medecin | Bool {
      $query = 'INSERT INTO medecin (civilite, nom, prenom) VALUES (:civilite, :nom, :prenom)';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':civilite', $medecin->getCivilite());
      $stmt->bindValue(':nom', $medecin->getNom());
      $stmt->bindValue(':prenom', $medecin->getPrenom());
      $this->pdo->beginTransaction();
      $stmt->execute();
      $id = $this->pdo->lastInsertId();

      $this->pdo->commit();
      return $this->get($id);
    }
    public function get(int $id): Medecin | Bool {
      $query = 'SELECT * FROM medecin WHERE id_medecin = :id';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result ? new Medecin($result) : false;
    }
    public function delete(int $id) {
      $daoConsult = new ConsultationDao();
      $array = $daoConsult->getAllIdConsultationByMedecin($id);
      foreach ($array as $cle => $valeur) {
          $daoConsult->delete($valeur);
      }
      $query = 'DELETE FROM medecin WHERE id_medecin = :id';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':id', $id);
      return $stmt->execute();
    }
    public function update(Medecin $medecin) : Medecin | Bool {
      $query = 'UPDATE usager SET civilite = :civilite, nom = :nom, prenom = :prenom WHERE id_usager = :id';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':civilite', $medecin->getCivilite());
      $stmt->bindValue(':nom', $medecin->getNom());
      $stmt->bindValue(':prenom', $medecin->getPrenom());
      $stmt->bindValue(':id', $medecin->getIdMedecin());
      $stmt->execute();
      return $this->get($medecin->getIdMedecin());
    }
  }