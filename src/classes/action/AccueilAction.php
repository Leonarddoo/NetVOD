<?php

namespace iutnc\netvod\action;

use iutnc\netvod\action\Action;
use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\User;

class AccueilAction extends Action
{

    public function execute(): string
    {
        /**
         * @param string $output
         * @return string
         */
        $output = 'Préférences :';
        switch ($this->http_method) {
            case 'GET':
                $PDO = ConnectionFactory::makeConnection();
                $preference_statement = $PDO->prepare('SELECT * FROM userPreference INNER JOIN serie ON id_serie=serie.id WHERE id_user = ?');
                $visionnage_statement = $PDO->prepare('SELECT * FROM userVisionnage INNER JOIN serie ON id_serie=serie.id WHERE id_user = ?');

                $user = unserialize($_SESSION['user']);
                $id_user = $user->id;

                $preference_statement->bindParam(1, $id_user);
                $visionnage_statement->bindParam(1, $id_user);
                $preference_statement->execute();
                $visionnage_statement->execute();

                $output .= '<ul>';
                while ($data=$preference_statement->fetch()) {
                    $output .= "<li>{$data['titre']}<img src='{$data['img']}' alt='Une image correspondant à la série'></li>";
                }
                while ($data=$visionnage_statement->fetch()) {
                    $output .= "<li>{$data['titre']}<img src='{$data['img']}' alt='Une image correspondant à la série'></li>";
                }
                $output .= '</ul>';

            case 'POST':
                break;
        }
        return $output;
    }
}