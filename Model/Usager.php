<?php
  require_once __DIR__ . '/../Dao/UsagerDao.php';
  class Usager {
    private static $dao;
    private static function getDao() {
      return self::$dao ?? self::$dao = new UsagerDao();
    }
    public static function all() : array{
      return self::getDao()->findAll();
    }
    public static function add(Usager $usager) : Usager | Bool {
      return self::getDao()->add($usager);
    }
    public static function get(int $id) : Usager | Bool {
      return self::getDao()->get($id);
    }
    public static function delete(int $id) {
      return self::getDao()->delete($id);
    }
    public static function update(Usager $usager) : Usager | Bool {
      return self::getDao()->update($usager);
    }
    public static function getByNumero(string $num_secu) : Usager | Bool {
      return self::getDao()->getByNumero($num_secu);
    }
    private int $id_usager;
    private string $civilite;
    private string $nom;
    private string $prenom;
    private string $sexe;
    private string $adresse;
    private string $code_postal;
    private string $ville;
    private DateTimeImmutable $date_nais;
    private string $lieu_nais;
    private string $num_secu;
    private int $id_medecin;

    public function __construct(array $data = []) {
      if (
        isset($data['civilite']) && 
        isset($data['nom']) && 
        isset($data['prenom']) && 
        isset($data['sexe']) && 
        isset($data['adresse']) && 
        isset($data['code_postal']) && 
        isset($data['ville']) && 
        isset($data['date_nais']) && 
        isset($data['lieu_nais']) &&
        isset($data['num_secu']) 
        ) {
        $this->civilite = $data['civilite'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->sexe = $data['sexe'];
        $this->adresse = $data['adresse'];
        $this->code_postal = $data['code_postal'];
        $this->ville = $data['ville'];
        $this->date_nais = $data['date_nais'] instanceof DateTimeImmutable ? $data['date_nais'] : new DateTimeImmutable($data['date_nais']);
        $this->lieu_nais = $data['lieu_nais'];
        $this->num_secu = $data['num_secu'];
      }
      if (isset($data['id_usager'])) {
        $this->id_usager = $data['id_usager'];
      }
      if (isset($data['id_medecin'])) {
        $this->id_medecin = $data['id_medecin'];
      }
    }

    public function toArray(): array {
      $output = [
        'id_usager' => $this->id_usager,
        'civilite' => $this->civilite,
        'nom' => $this->nom,
        'prenom' => $this->prenom,
        'sexe' => $this->sexe,
        'adresse' => $this->adresse,
        'code_postal' => $this->code_postal,
        'ville' => $this->ville,
        'date_nais' => $this->date_nais->format('d/m/Y'),
        'lieu_nais' => $this->lieu_nais,
        'num_secu' => $this->num_secu
      ];
      if ($this->hasMedecin()) {
        $output['id_medecin'] = $this->id_medecin;
      }
      return $output;
    }

    public function getIdUsager(): int {
        return $this->id_usager;
    }

    public function setIdUsager(int $id_usager): void {
        $this->id_usager = $id_usager;
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

    public function getSexe(): string {
        return $this->sexe;
    }

    public function setSexe(string $sexe): void {
        $this->sexe = $sexe;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void {
        $this->adresse = $adresse;
    }

    public function getCodePostal(): string {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): void {
        $this->code_postal = $code_postal;
    }

    public function getVille(): string {
        return $this->ville;
    }

    public function setVille(string $ville): void {
        $this->ville = $ville;
    }

    public function getDateNais(): DateTimeImmutable {
        return $this->date_nais;
    }

    public function setDateNais(DateTimeImmutable $date_nais): void {
        $this->date_nais = $date_nais;
    }

    public function getLieuNais(): string {
        return $this->lieu_nais;
    }

    public function setLieuNais(string $lieu_nais): void {
        $this->lieu_nais = $lieu_nais;
    }

    public function getNumSecu(): string {
        return $this->num_secu;
    }

    public function setNumSecu(string $num_secu): void {
        $this->num_secu = $num_secu;
    }

    public function hasMedecin(): bool {
      return isset($this->id_medecin);
    }

    public function getIdMedecin(): int {
        return $this->id_medecin;
    }

    public function setIdMedecin(int $id_medecin): void {
        $this->id_medecin = $id_medecin;
    }
}