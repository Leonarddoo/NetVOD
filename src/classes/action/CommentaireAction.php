<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class CommentaireAction extends Action
{

    public function execute(): string
    {
        $output = '';

        if ($id_serie = filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $output .= "<h1>Commentaires : </h1>";

            $PDO = ConnectionFactory::makeConnection();
            $statement = $PDO->prepare('SELECT email, commentaire, note FROM avis INNER JOIN User on avis.id_user = User.id WHERE id_serie = ?');
            $statement->bindParam(1, $id_serie);
            $statement->execute();

            while ($data=$statement->fetch()) {
                $output .= '<div>';

                $output .= "<h3>Utilisateur : </h3>{$data['email']}";
                $output .= "<h4>Commentaire : </h4><p>{$data['commentaire']}</p>";
                $output .= "<strong>Note : </strong>{$data['note']}/5";

                $output .= '</div><br>';
            }
        }

        return $output;
    }
}