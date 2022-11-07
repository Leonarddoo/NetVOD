<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AlbumTrack;

class AlbumTrackRenderer extends AudioTrackRenderer
{
    public AlbumTrack $albumTrack;

    public function __construct(AlbumTrack $albumTrack)
    {
        $this->albumTrack = $albumTrack;
    }

    function show_compact(): string
    {
        return "Titre : {$this->albumTrack->titre}<BR>";
    }

    function show_long(): string
    {
        return "{$this->albumTrack->titre}<BR>
                {$this->albumTrack->artiste}<BR>
                {$this->albumTrack->album}<BR>
                {$this->albumTrack->annee}<BR>
                {$this->albumTrack->nbPiste}<BR>
                {$this->albumTrack->genre}<BR>
                {$this->albumTrack->duree}<BR>
                {$this->fichier()}";
    }

    public function fichier(): string
    {
        return $this->albumTrack->filename;
    }
}