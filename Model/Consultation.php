<?php

class Consultation{

    private int $id_consult;
    private int $id_medecin;
    private int $id_usager;
    private DateTimeImmutable $heure_consult;
    private DateTimeImmutable $date_consult;
    private int $duree;
    
    public function __construct(array $data = []) {
        if(
            isset($data["id_medecin"]) && 
            isset($data["id_usager"]) && 
            isset($data["date_consult"]) && 
            isset($data["heure_consult"]) && 
            isset($data["duree_consult"])
        ) {
            $this->id_medecin = $data['id_medecin'];
            $this->id_usager = $data['id_usager'];
            $this->date_consult = $data['date_consult'] instanceof DateTimeImmutable ? $data['date_consult'] : new DateTimeImmutable($data['date_consult']);
            $this->heure_consult = $data['heure_consult'] instanceof DateTimeImmutable ? $data['heure_consult'] : new DateTimeImmutable($data['heure_consult']);
            $this->duree = $data['duree_consult'];

            if(isset($data['id_consult'])) {
                $this->id_consult = $data['id_consult'];
            }

        }
    }

    public function getIdConsult(): int {
        return $this->id_consult;
    }

    public function setIdConsult(int $id_consult): void {
        $this->id_consult = $id_consult;
    }

    public function getIdMedecin(): int {
        return $this->id_medecin;
    }

    public function setIdMedecin(int $id_medecin): void {
        $this->id_medecin = $id_medecin;
    }

    public function getIdUsager(): int {
        return $this->id_usager;
    }

    public function setIdUsager(int $id_usager): void {
        $this->id_usager = $id_usager;
    }

    public function getHeureConsult(): DateTimeImmutable {
        return $this->heure_consult;
    }

    public function setHeureConsult(DateTimeImmutable $heure_consult): void {
        $this->heure_consult = $heure_consult;
    }

    public function getDateConsult(): DateTimeImmutable {
        return $this->date_consult;
    }

    public function setDateConsult(DateTimeImmutable $date_consult): void {
        $this->date_consult = $date_consult;
    }

    public function getDuree(): int {
        return $this->duree;
    }

    public function setDuree(int $duree): void {
        $this->duree = $duree;
    }

    public function toArray(): array {
        return [
            'id_consult' => $this->id_consult,
            'id_medecin' => $this->id_medecin,
            'id_usager' => $this->id_usager,
            'heure_consult' => $this->heure_consult->format("H:i"),
            'date_consult' => $this->date_consult->format("d/m/Y"),
            'duree_consult' => $this->duree,
        ];
    }
}