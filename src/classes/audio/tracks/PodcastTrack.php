<?php

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack{
    protected string $date;
    protected string $auteur;

    public function __construct(string $titre, string $auteur, string $genre, float $duree, string $date, string $chemin)
    {
        parent::__construct($titre, $genre, $duree,$chemin);
        $this->auteur = $auteur;
        $this->date = $date;
    }
}