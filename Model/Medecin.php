<?php
  require_once __DIR__.'/../Dao/MedecinDao.php';

  class Medecin {
    private static $dao;
    private static function getDao() {
      return self::$dao ?? self::$dao = new MedecinDao();
    }
    public static function all() : array {
      return self::getDao()->findAll();
    }
    public static function add(Medecin $medecin) : Medecin | Bool {
      return self::getDao()->add($medecin);
    }
    public static function get(int $id) : Medecin | Bool {
      return self::getDao()->get($id);
    }
    public static function delete(int $id) {
      return self::getDao()->delete($id);
    }
    public static function update(Medecin $medecin) : Medecin | Bool {
      return self::getDao()->update($medecin);
    }
    private int $id_medecin;
    private string $civilite;
    private string $nom;
    private string $prenom;

    public function __construct(array $data = []) {
      if (
        isset($data['civilite']) &&
        isset($data['nom']) && 
        isset($data['prenom'])
        ) {
        $this->civilite = $data['civilite'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
      }
      if (isset($data['id_medecin'])) {
        $this->id_medecin = $data['id_medecin'];
      }
    }

    public function getIdMedecin(): int {
        return $this->id_medecin;
    }

    public function setIdMedecin(int $id_medecin): void {
        $this->id_medecin = $id_medecin;
    }

    public function getCivilite(): string {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): void {
        $this->civilite = $civilite;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function toArray(): array {
      return [
          'id_medecin' => $this->id_medecin,
          'civilite' => $this->civilite,
          'nom' => $this->nom,
          'prenom' => $this->prenom
      ];
  }
}