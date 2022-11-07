<?php

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\exception\InvalidPropertyNameException;

class AudioList
{
    private string $nom;
    protected int $nbPistes;
    protected float $dureeTotale;
    protected array $pistes;

    public function __construct(string $nom, array $pistes=[])
    {
        $this->nom = $nom;
        $this->pistes = $pistes;
        $this->nbPistes = count($pistes);
        $this->dureeTotale = 0;
        foreach ($pistes as $piste) {
            $this->dureeTotale += $piste->duree;
        }
    }

    public function __get(string $attr): mixed
    {
        if (property_exists($this, $attr)) return $this->$attr;
        throw new InvalidPropertyNameException("$attr isn't attribute of this instance of class");
    }
}