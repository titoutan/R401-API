<?php
  require_once __DIR__ . '/../connexion.php';
  class UsagerDao {
    private PDO $pdo;
    public function __construct() {
      $this->pdo = Connexion::getInstance()->getPdo();
    }
    public function findAll(): array {
      $query = 'SELECT * FROM usager ORDER BY id_usager';
      $stmt = $this->pdo->query($query);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $output = [];
      foreach ($result as $row) {
        array_push($output,(new Usager($row))->toArray());
      }
      return $output;
    }
    public function add(Usager $usager) : Usager | Bool {
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
      $stmt_id_medecin = $this->pdo->prepare('UPDATE usager SET id_medecin = :id_medecin WHERE id_usager = :id');
      $this->pdo->beginTransaction();
      $stmt->execute();
      $id = $this->pdo->lastInsertId();
      if ($usager->hasMedecin()) {
        $stmt_id_medecin->bindValue(':id_medecin', $usager->getIdMedecin());
        $stmt_id_medecin->bindValue(':id', $id);
        $stmt_id_medecin->execute();
      }
      $this->pdo->commit();
      return $this->get($id);
    }
    public function get(int $id): Usager | bool {
      $query = 'SELECT * FROM usager WHERE id_usager = :id';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$result) {
        return false;
      }
      return new Usager($result);
    }
    public function delete(int $id) {
      $daoConsult = new ConsultationDao();
      $array = $daoConsult->getAllIdConsultationByUsager($id);
      foreach ($array as $cle => $valeur) {
          $daoConsult->delete($valeur);
      }
      $query = 'DELETE FROM usager WHERE id_usager = :id';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':id', $id);
      return $stmt->execute();
    }
    public function update(Usager $usager) : Usager | Bool {
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
      if ($usager->hasMedecin()) {
        $stmt_id_medecin = $this->pdo->prepare('UPDATE usager SET id_medecin = :id_medecin WHERE id_usager = :id');
        $stmt_id_medecin->bindValue(':id_medecin', $usager->getIdMedecin());
        $stmt_id_medecin->bindValue(':id', $usager->getIdUsager());
        $stmt_id_medecin->execute();
      }
      return $this->get($usager->getIdUsager());
    }
    public function getByNumero($numero) : Usager | Bool {
      $query = 'SELECT * FROM usager WHERE num_secu = :numero';
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':numero', $numero);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$result) {
        return false;
      }
      return new Usager($result);
    }
  }