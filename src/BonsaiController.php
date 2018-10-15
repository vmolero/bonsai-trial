<?php

namespace PlanetaHuerto;

class BonsaiController
{
    private $file_db;

    public function __construct()
    {
        $this->connectDB();
    }

    public function list(): array
    {
        $result = $this->file_db->query('SELECT * FROM bonsai');
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function abonar(string $id, string $fechaRecibida)
    {
        $elemento = $this->fetch(intval($id));
        /** @var Abonable $bonsai */
        $bonsai = $this->BonsaiFactory($elemento, null, $fechaRecibida);
        $fecha = new \DateTime($fechaRecibida);
        if ($bonsai->tengoQueAbonar($fecha)) {
            $bonsai->abonar($fecha);
            $this->save(NecesidadEnum::ABONO, intval($id), $fecha);
            return true;
        }
        return false;
    }

    public function regar(string $id, string $fechaRecibida)
    {
        $elemento = $this->fetch(intval($id));
        /** @var Regable $bonsai */
        $bonsai = $this->BonsaiFactory($elemento, $fechaRecibida);
        
        return $bonsai->riego();
    }

    public function transplantar(string $id, string $fechaRecibida)
    {
        $elemento = $this->fetch(intval($id));
        /** @var BonsaiTree $bonsai */
        $bonsai = $this->BonsaiFactory($elemento);
        return $bonsai->transplantar(new \DateTime($fechaRecibida));
    }

    public function pulverizar($id)
    {
        $elemento = $this->fetch($id);
        /** @var Pulverizable $bonsai */
        $bonsai = $this->bonsaiFactory($elemento);
        
        return $bonsai->pulverizar();
    }

    private function bonsaiFactory(array $elemento, $fechaRiego = null, $fechaAbono = null): BonsaiTree
    {
        $bonsai = null;
        $riego = new RiegoVisitor($fechaRiego ? new \DateTime($fechaRiego) : null);
        $abono = new AbonoStrategy();
        
        switch ($elemento['tipo']) {
            case TipoBonsaiEnum::FICUS:
                $bonsai = new Ficus($riego, $abono);
                break;
            case TipoBonsaiEnum::MANZANO:
                $bonsai = new Manzano($riego, $abono);
                break;
            case TipoBonsaiEnum::OLMO:
                $bonsai = new Olmo($riego, $abono);
                break;
            case TipoBonsaiEnum::OLIVO:
                $bonsai = new Olivo($riego, $abono);
                break;
            default:
                throw new \LogicException('Error tipo bonsai');
        }
        if (isset($elemento['abonado']) && $elemento['abonado'] !== '') {
            $bonsai->abonar(new \DateTime($elemento['abonado']));
        }
        return $bonsai;
    }

    private function connectDB()
    {
        // Create (connect to) SQLite database in file
        $this->file_db = new \PDO('sqlite:bonsaitrial.sqlite3');
        // Set errormode to exceptions
        $this->file_db->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }

    private function fetch($id): array
    {
        $stmt = $this->file_db->prepare('SELECT * FROM bonsai WHERE id = :id');
        $stmt->bindParam(':id', $id, SQLITE3_INTEGER);
        $res = $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function save(string $operacion, int $id, \DateTime $fecha): bool
    {
        $stmt = $this->file_db->prepare("UPDATE bonsai SET $operacion = :operacion WHERE id = :id");
        $stmt->bindParam(':id', $id, SQLITE3_INTEGER);
        $stmt->bindParam(':operacion', $fecha->format('Y-m-d'), SQLITE3_TEXT);
        return $stmt->execute();
    }
}
