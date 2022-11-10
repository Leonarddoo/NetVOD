<?php

namespace iutnc\netvod\action;

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
        $PDO = ConnectionFactory::makeConnection();

        $statement = $PDO->prepare('SELECT id,titre,img FROM serie');
        $statement->execute();

        $output .= '<ul>';
        while ($data = $statement->fetch()) {
            $output .= "<li><a href='?action=serie&id={$data['id']}'>{$data['titre']}<img src='{$data['img']}' alt='Une image correspondant à la série'></a></li>";
        }
        $output .= '</ul>';

//                $ep_statement = $PDO->prepare('SELECT episode.titre ep_titre, s.titre s_titre FROM episode INNER JOIN serie s on episode.serie_id = s.id');
//                $ep_statement->execute();
//
//                while ($data=$ep_statement->fetch()) {
//                    $output .= "<div>Episode : {$data['ep_titre']}</div>";
//                }
//                break;
        return $output;
    }
}