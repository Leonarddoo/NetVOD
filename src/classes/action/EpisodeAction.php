<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\User;
use PDOException;

class EpisodeAction extends Action
{
    public function execute(): string
    {
        $output = '';
        if ($id = filter_var($_GET['id'], FILTER_VALIDATE_INT)) {

            $PDO = ConnectionFactory::makeConnection();

            $episode_statement = $PDO->prepare('SELECT id i,numero num ,titre title,resume res,duree dur,file fil,serie_id idse,img FROM episode WHERE episode.id = ?');
            $episode_statement->bindParam(1, $id);
            $episode_statement->execute();

            if ($episode = $episode_statement->fetch()) {
                $output .= "<h1><div> Episode n° {$episode['num']}</div></h1>";
                $output .= "<h2>{$episode['title']}</h2>";

                $output .= "<div></div><video controls src='video/{$episode['fil']}'></video></div>";


                $output .= "<img src='{$episode['img']}' alt=\"Une image correspond à l'episode\">";

                $output .= "<div> Résumé : <p>{$episode['res']}</p></div>";
                $output .= "<div> Durée: <p>{$episode['dur']} min</p></div>";

                if (Auth::connected()) {
                    $id_user = User::sessionUser()->id;
                    $serie = $episode['idse'];

                    $watch_statement = $PDO->prepare('INSERT INTO userWatch VALUES (:user, :serie, :episode) ON DUPLICATE KEY UPDATE id_ep=:episode');

                    $watch_statement->bindParam('user', $id_user);
                    $watch_statement->bindParam('serie', $serie);
                    $watch_statement->bindParam('episode', $id);

                    $watch_statement->execute();

                    if ($this->http_method === 'POST') {
                        $note = filter_var($_POST['note'], FILTER_VALIDATE_INT);
                        $commentaire = filter_var($_POST['commentaire'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        if ($note and $commentaire) {
                            $statement = $PDO->prepare('INSERT INTO avis VALUES (:serie, :user, :note, :comment) ON DUPLICATE KEY UPDATE note = :note, commentaire = :comment');

                            $statement->bindParam('serie', $serie);
                            $statement->bindParam('user', $id_user);
                            $statement->bindParam('note', $note);
                            $statement->bindParam('comment', $commentaire);

                            $statement->execute();
                        }
                    }

                    $statement = $PDO->prepare('SELECT * FROM avis WHERE id_serie = ? and id_user = ?');

                    $statement->bindParam(1, $serie);
                    $statement->bindParam(2, $id_user);

                    $statement->execute();

                    if ($var = $statement->fetch()) {
                        $note = $var['note'];
                        $commentaire = $var['commentaire'];
                    } else {
                        $note = 0;
                        $commentaire = '';
                    }

                    $output .= '<h3>Ton commentaire sur la série : </h3><form method="post">';
                    $output .= 'Note : ';
                    for ($i = 1; $i <= 5; $i++) {
                        $output .= "<label>$i</label><input type='radio' name='note' value='$i' required ";
                        if ($note === $i) {
                            $output .= 'checked';
                        }
                        $output .= '></label>';
                    }

                    $output .= "<div><textarea name='commentaire'>$commentaire</textarea></div>";

                    $output .= "<button type='submit'>Envoyer</button>";

                    $output .= '</form>';
                }
            }
        }
        return $output;
    }
}


