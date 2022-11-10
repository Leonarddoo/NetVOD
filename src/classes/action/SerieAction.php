<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\User;
use iutnc\netvod\Utils;
use PDOException;

class SerieAction extends Action
{

    public function execute(): string
    {
        $output = '';
        if ($id_serie = filter_var($_GET['id'], FILTER_VALIDATE_INT)) { // vérifie si le paramètre id est un nombre
            $PDO = ConnectionFactory::makeConnection();

            $serie_statement = $PDO->prepare('SELECT serie.id idserie,serie.titre title, serie.descriptif sum, serie.annee year, serie.date_ajout date, count(episode.id) nb_ep FROM serie INNER JOIN episode on serie.id = episode.serie_id WHERE serie.id = ? GROUP BY serie.id, serie.titre');
            $serie_statement->bindParam(1, $id_serie);
            $serie_statement->execute();

            $genre_statement = $PDO->prepare('SELECT libelleGenre FROM genre INNER JOIN estGenreDe on genre.id_genre = estGenreDe.id_genre WHERE id_serie = ?');
            $genre_statement->bindParam(1, $id_serie);
            $genre_statement->execute();

            $public_statement = $PDO->prepare('SELECT libelle FROM public INNER JOIN estPublicDe on public.id_public = estPublicDe.id_public WHERE id_serie = ?');
            $public_statement->bindParam(1, $id_serie);
            $public_statement->execute();

            if ($serie = $serie_statement->fetch()) { // si la serie dont l'id est $id existe
                $output .= "<h1>{$serie['title']}</h1>";

                $output .= "<div>Nombre d'episodes : {$serie['nb_ep']}</div>";

                $genre = Utils::pdo2string($genre_statement, 0, separator: '', start: '<ul>', end: '</ul>', before: '<li>', after: '</li>');
                $output .= "<div>Genre(s) : $genre</div>";

                $public = Utils::pdo2string($public_statement, 0, separator: '', start: '<ul>', end: '</ul>', before: '<li>', after: '</li>');
                $output .= "<div>Public(s) visé(s) : $public</div>";

                $output .= "<div>Descriptif : <p>{$serie['sum']}</p></div>";
                $output .= "<div>Année de sortie : {$serie['year']}</div>";
                $output .= "<div>Date d'ajout : {$serie['date']}</div>";

                $comments = '';

                if (Auth::connected()) {
                    if ($this->http_method === 'POST') {
                        if (isset($_POST['like'])) {
                            if ($_POST['like'] === 'true') {
                                $like_statement = $PDO->prepare('INSERT INTO userPreference VALUES (?, ?)');

                                $id_user = User::sessionUser()->id;

                                $like_statement->bindParam(1, $id_user);
                                $like_statement->bindParam(2, $id_serie);

                                $like_statement->execute();
                            } else {
                                $unlike_statement = $PDO->prepare('DELETE FROM userPreference WHERE id_user=? and id_serie=?;');

                                $id_user = User::sessionUser()->id;

                                $unlike_statement->bindParam(1, $id_user);
                                $unlike_statement->bindParam(2, $id_serie);

                                $unlike_statement->execute();
                            }

                        }
                    }

                    $likecheck_statement = $PDO->prepare('SELECT count(*) size FROM userPreference WHERE id_user = ? and id_serie = ?');
                    $id_user = User::sessionUser()->id;
                    $likecheck_statement->bindParam(1, $id_user);
                    $likecheck_statement->bindParam(2, $id_serie);
                    $likecheck_statement->execute();

                    if ($likecheck_statement->fetch()['size'] === 0) {
                        $output .= Utils::linked_button('Ajouter à mes préférences', 'true', 'post', 'like');
                    } else {
                        $output .= Utils::linked_button('Supprimer de mes préférences', 'false', 'post', 'like');
                    }
                }

                $output .= '<h2>Liste des épisodes : </h2>';

                $ep_statement = $PDO->prepare('SELECT e.id id, e.titre title, numero, duree, resume, e.img FROM serie INNER JOIN episode e on serie.id = e.serie_id WHERE serie.id = ? ORDER BY numero');
                $ep_statement->bindParam(1, $id_serie);
                $ep_statement->execute();

                $output .= '<ul>';
                while ($ep = $ep_statement->fetch()) {
                    $output .= "<li><a href='?action=episode&id={$ep['id']}'>";


                    $output .= "<h3>Episode n° {$ep['numero']} : {$ep['title']}, durée : {$ep['duree']} min</h3>";
                    $output .= "<h4>Résumé : </h4><p>{$ep['resume']}</p>";
                    $output .= "<img src='{$ep['img']}' alt=\"Une image correspond à l'episode\">";

                    $output .= '</a></li>';
                }
                $output .= '</ul>';

                $output .= '<h2>Section commentaire</h2>';

                $avg_statement = $PDO->prepare('SELECT avg(note) moyenne FROM avis WHERE id_serie = ?');
                $avg_statement->bindParam(1, $id_serie);
                $avg_statement->execute();

                $raw_moyenne = $avg_statement->fetch()['moyenne'];
                $moyenne = round($raw_moyenne, 2);

                $output .= "<div>La moyenne de cette série est de : $moyenne</div>";
                $output .= "<div><a href='?action=comments&id=$id_serie'>Voir la liste des commentaires</a></div>";
            }
        }
        return $output;

    }
}