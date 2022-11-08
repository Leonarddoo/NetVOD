<?php

namespace iutnc\netvod\action;

use iutnc\netvod\action\Action;
use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;

class CatalogueAction extends Action
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

                $statement = $PDO->prepare('SELECT id,titre,img FROM serie');
                $statement->execute();

                $output .= '<ul>';
                while ($data=$statement->fetch()) {
                    $output .= "<li>{$data['titre']}<img src='{$data['img']}' alt='Une image correspondant à la série'></li>";
                }
                $output .= '</ul>';

//                $ep_statement = $PDO->prepare('SELECT episode.titre ep_titre, s.titre s_titre FROM episode INNER JOIN serie s on episode.serie_id = s.id');
//                $ep_statement->execute();
//
//                while ($data=$ep_statement->fetch()) {
//                    $output .= "<div>Episode : {$data['ep_titre']}</div>";
//                }
//                break;
            case 'POST':

                break;
        }
        return $output;
    }
}