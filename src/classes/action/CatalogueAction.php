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

        $output .= <<<CATALOGUE
<h3 class="catalogue-title">Catalogue</h3>
<div class="catalogue">
CATALOGUE;

        while ($data = $statement->fetch()) {
            $output .= <<<CATALOGUE
<a class="card" href="?action=serie&id={$data['id']}">
    <div class="card-content">
        <div class="image">
            <img src='{$data['img']}' alt='Une image correspondant à la série'>
        </div>
        <div class="text">
            <span class="title">{$data['titre']}</span>
        </div>
    </div>
</a>
CATALOGUE;
        }
        $output .= '</div>';
        return $output;
    }
}