<?php

namespace iutnc\deefy\render;

class PodcastRenderer extends AudioTrackRenderer
{
    public \iutnc\deefy\audio\tracks\PodcastTrack $podcastTrack;

    public function __construct(\iutnc\deefy\audio\tracks\PodcastTrack $pt)
    {
        $this->podcastTrack = $pt;
    }

    function show_compact(): string
    {
        return "Titre : {$this->podcastTrack->titre}<BR>";
    }

    function show_long(): string
    {
        return "{$this->podcastTrack->titre}<BR>
                {$this->podcastTrack->auteur}<BR>
                {$this->podcastTrack->date}<BR>
                {$this->podcastTrack->genre}<BR>
                {$this->podcastTrack->duree}<BR>
                {$this->fichier()}";
    }

    function fichier(): string
    {
        return $this->podcastTrack->filename;
    }
}