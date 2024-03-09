<?php
  require_once __DIR__ . '/../connexion.php';
  class UsagerDao {
    private PDO $pdo;
    public function __construct() {
      $this->pdo = Connexion::getInstance()->getPdo();
    }
    public function findAll(): array {
      $query = 'SELECT * FROM usager';
      $stmt = $this->pdo->query($query);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
    public function add(Usager $usager) {
      $query = 'INSERT INTO usager (civilite, nom, prenom, sexe, adresse, code_postal, ville, date_nais, lieu_nais, num_secu) VALUES (:civilite, :nom, :prenom, :sexe, :adresse, :code_postal, :ville, :date_nais, :lieu_nais, :num_secu)';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':civilite', $usager->getCivilite());
      $stmt->bindValue(':nom', $usager->getNom());
      $stmt->bindValue(':prenom', $usager->getPrenom());
      $stmt->bindValue(':sexe', $usager->getSexe());
      $stmt->bindValue(':adresse', $usager->getAdresse());
      $stmt->bindValue(':code_postal', $usager->getCodePostal());
      $stmt->bindValue(':ville', $usager->getVille());
      $stmt->bindValue(':date_nais', $usager->getDateNais()->format('Y-m-d'));
      $stmt->bindValue(':lieu_nais', $usager->getLieuNais());
      $stmt->bindValue(':num_secu', $usager->getNumSecu());
      $this->pdo->beginTransaction();
      $stmt->execute();
      $id = $this->pdo->lastInsertId();
      $this->pdo->commit();
      return $this->get($id);
    }
    public function get(int $id): Usager {
      $query = 'SELECT * FROM usager WHERE id_usager = :id';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return new Usager($result);
    }
    public function delete(int $id) {
      $query = 'DELETE FROM usager WHERE id_usager = :id';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':id', $id);
      return $stmt->execute();
    }
    public function update(Usager $usager) {
      $query = 'UPDATE usager SET civilite = :civilite, nom = :nom, prenom = :prenom, sexe = :sexe, adresse = :adresse, code_postal = :code_postal, ville = :ville, date_nais = :date_nais, lieu_nais = :lieu_nais, num_secu = :num_secu WHERE id_usager = :id';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':civilite', $usager->getCivilite());
      $stmt->bindValue(':nom', $usager->getNom());
      $stmt->bindValue(':prenom', $usager->getPrenom());
      $stmt->bindValue(':sexe', $usager->getSexe());
      $stmt->bindValue(':adresse', $usager->getAdresse());
      $stmt->bindValue(':code_postal', $usager->getCodePostal());
      $stmt->bindValue(':ville', $usager->getVille());
      $stmt->bindValue(':date_nais', $usager->getDateNais()->format('Y-m-d'));
      $stmt->bindValue(':lieu_nais', $usager->getLieuNais());
      $stmt->bindValue(':num_secu', $usager->getNumSecu());
      $stmt->bindValue(':id', $usager->getIdUsager());
      $stmt->execute();
      return $this->get($usager->getIdUsager());
    }
  }