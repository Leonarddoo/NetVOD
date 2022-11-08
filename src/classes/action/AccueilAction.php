<?php

namespace iutnc\netvod\action;

use iutnc\netvod\action\Action;
use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;

class AccueilAction extends Action
{

    public function execute(): string
    {
        /**
         * @param string $output
         * @return string
         */
        $output = '';
        switch ($this->http_method) {
            case 'GET':
                $PDO = ConnectionFactory::makeConnection();
                $statement = $PDO->prepare('SELECT * FROM userPreference');
                $statement->execute();
                $output .= '<ul>';
                while ($data=$statement->fetch()) {
                    $output .= "<li>{$data['titre']}<img src='{$data['img']}' alt='Une image correspondant à la série'></li>";
                }
                $output .= '</ul>';

            case 'POST':
                break;
        }
        return $output;
    }
}