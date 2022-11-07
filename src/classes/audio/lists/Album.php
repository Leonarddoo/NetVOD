<?php

namespace iutnc\deefy\audio\lists;

class Album extends AudioList
{
    protected string $artiste;
    protected string $datesortie;

    public function __construct(string $nom, string $artiste, string $datesortie, array $pistes)
    {
        parent::__construct($nom, $pistes);
        $this->artiste = $artiste;
        $this->datesortie = $datesortie;
    }

    public function __set(string $attr, mixed $value): void
    {
        if (property_exists($this, $attr)) {
            if ($attr === 'artiste' or $attr === 'datesortie')
                $this->$attr = $value;
        }
        throw new InvalidPropertyNameException("$attr isn't attribute of this instance of class");
    }
}