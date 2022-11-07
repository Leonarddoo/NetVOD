<?php

namespace iutnc\deefy\render;

use \iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

class AudioListRenderer implements Renderer
{
    private AudioList $liste;

    public function __construct(AudioList $liste)
    {
        $this->liste = $liste;
    }

    public function render(int $selector=0): string
    {
        $string = "<div>Nom : {$this->liste->nom}<BR>";
        foreach ($this->liste->pistes as $piste) {
            if ($piste instanceof AlbumTrack) {
                $piste_render = new AlbumTrackRenderer($piste);
            } elseif ($piste instanceof PodcastTrack) {
                $piste_render = new PodcastRenderer($piste);
            }
            $string .= $piste_render->render(self::COMPACT);
        }
        return "$string<BR>Nombre de pistes : {$this->liste->nbPistes}<BR>Durée totale : {$this->liste->dureeTotale}</div>";
    }
}