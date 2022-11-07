<?php

namespace iutnc\deefy\audio\lists;


use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\db\ConnectionFactory;

class Playlist extends AudioList
{
    public function ajouterPiste(AudioTrack $piste): void
    {
        $this->pistes[] = $piste;
        $this->nbPistes++;
        $this->dureeTotale += $piste->duree;
    }

    public function supprimerPiste(int $index): void
    {
        $this->dureeTotale -= $this->pistes[$index];
        $this->nbPistes--;

        unset($this->pistes[$index]);
    }

    public function ajouterTout(array $pistes): void
    {
        foreach ($pistes as $piste) {
            $this->ajouterPiste($piste);
        }
    }

    public function getTrackList(): array
    {
        $db = \iutnc\deefy\db\ConnectionFactory::makeConnection();
        $statement = $db->prepare('SELECT * FROM track
                                    INNER JOIN playlist2track p2t on track.id = p2t.id_track
                                    INNER JOIN playlist on p2t.id_pl = playlist.id
                                    WHERE playlist.nom = ?');
        $nom = $this->nom;
        $statement->bindParam(1, $nom);
        $statement->execute();

        $res = [];
        while ($line = $statement->fetch())
            switch ($line['type']) {
                case 'A':
                    $res[] = new AlbumTrack($line['titre'], $line['artiste_album'], $line['titre_album'], $line['annee_album'], $line['no_piste_dans_liste'], $line['genre'], $line['duree'], $line['filename']);
                    break;
                case 'P':
                    $res[] = new PodcastTrack($line['titre'], $line['auteur_podcast'], $line['genre'], $line['duree'], $line['date_posdcast'], $line['filename']);
                    break;
            }
        return $res;
    }

    public static function find(int $id): ?Playlist
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $PDO = ConnectionFactory::makeConnection();
            $statement = $PDO->prepare('SELECT nom FROM playlist WHERE id = ?');
            $statement->bindParam(1, $id);
            $statement->execute();

            if ($data = $statement->fetch()) {
                $nom = $data['nom'];

                $resultat = new Playlist($nom);
                $resultat->ajouterTout($resultat->getTrackList());
                return $resultat;
            }
        }
        return null;
    }
}