<?php

namespace iutnc\deefy\audio\tracks;

class AlbumTrack extends AudioTrack // pistesAudio
{

    protected string $artiste;
    protected int $annee;
    protected string $album;
    protected int $nbPiste;


    /**
     * @param string $titre
     */
    public function __construct(string $titre, string $artiste , string $album , int $annee, int $nbPiste,string $genre ,float $duree, string $chemin)
    {
        parent::__construct($titre,$genre,$duree,$chemin);
        $this->artiste = $artiste;
        $this->annee = $annee;
        $this->album = $album;
        $this->nbPiste= $nbPiste;
    }
}
