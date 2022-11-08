<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\Utils;

class SerieAction extends Action
{

    public function execute(): string
    {
        $output = '';
        if ($id = filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $PDO = ConnectionFactory::makeConnection();

            $serie_statement = $PDO->prepare('SELECT serie.titre title, serie.descriptif sum, serie.annee year, serie.date_ajout date, count(episode.id) nb_ep FROM serie INNER JOIN episode on serie.id = episode.serie_id WHERE serie.id = ? GROUP BY serie.id, serie.titre');
            $serie_statement->bindParam(1,$id);
            $serie_statement->execute();

            $genre_statement = $PDO->prepare('SELECT libelleGenre FROM genre INNER JOIN estGenreDe on genre.id_genre = estGenreDe.id_genre WHERE id_serie = ?');
            $genre_statement->bindParam(1,$id);
            $genre_statement->execute();

            $public_statement = $PDO->prepare('SELECT libelle FROM public INNER JOIN estPublicDe on public.id_public = estPublicDe.id_public WHERE id_serie = ?');
            $public_statement->bindParam(1,$id);
            $public_statement->execute();

            if ($serie = $serie_statement->fetch()) { // si la serie dont l'id est $id existe
                $output .= "<h4>{$serie['title']}</h4>";

                $output .= "<div>Nombre d'episodes : {$serie['nb_ep']}</div>";

                $genre = Utils::pdo2string($genre_statement, 0, separator: '', start: '<ul>', end: '</ul>', before: '<li>', after: '</li>');
                $output .= "<div>Genre(s) : $genre</div>";

                $public = Utils::pdo2string($public_statement, 0, separator: '', start: '<ul>', end: '</ul>', before: '<li>', after: '</li>');
                $output .= "<div>Public(s) visé(s) : $public</div>";

                $output .= "<div>Descriptif : <p>{$serie['sum']}</p></div>";
                $output .= "<div>Année de sortie : {$serie['year']}</div>";
                $output .= "<div>Date d'ajout : {$serie['date']}</div>";

                $ep_statement = $PDO->prepare('SELECT e.titre title, numero, duree, resume FROM serie INNER JOIN episode e on serie.id = e.serie_id WHERE serie.id = ? ORDER BY numero');
                $ep_statement->bindParam(1,$id);
                $ep_statement->execute();

                $output .= '<ul>';
                while ($serie=$ep_statement->fetch()) {
                    $output .= '<li>';

                    $output .= "Episode n° {$serie['numero']} : {$serie['title']}, durée : {$serie['duree']}";
                    $output .= "<p>Résumé : {$serie['resume']}</p>";
                    $output .= "<img src='{$serie['img']}' alt=\"Une image correspond à l'episode\">";

                    $output .= '</li>';
                }
                $output .= '</ul>';
            }
        }
        return $output;

    }
}