<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\User;
use iutnc\netvod\Utils;

class HomeAction extends Action
{

    public function execute(): string
    {
        $output = '';
        if (isset($_SESSION['user'])) {
            $output .= Utils::linked_button('Catalogue', 'catalogue');
            $output .= Utils::linked_button('Déconnexion', 'disconnect');

            $PDO = ConnectionFactory::makeConnection();

            $preference_statement = $PDO->prepare('SELECT * FROM userPreference INNER JOIN serie ON id_serie=serie.id WHERE id_user = ?');
            $visionnage_statement = $PDO->prepare('SELECT * FROM userWatch INNER JOIN serie ON id_serie=serie.id WHERE id_user = ?');

            $id_user = User::sessionUser()->id;

            $preference_statement->bindParam(1, $id_user);
            $preference_statement->execute();

            $visionnage_statement->bindParam(1, $id_user);
            $visionnage_statement->execute();

            $output .= 'Préférences : <ul>';
            while ($data=$preference_statement->fetch()) {
                $output .= "<li><a href='?action=serie&id={$data['id_serie']}'>{$data['titre']}<img src='{$data['img']}' alt='Une image correspondant à la série'></a></li>";
            }
            $output .= '</ul>En cours : <ul>';
            while ($data=$visionnage_statement->fetch()) {
                $output .= "<li><a href='?action=serie&id={$data['id_serie']}'>{$data['titre']}<img src='{$data['img']}' alt='Une image correspondant à la série'></a></li>";
            }
            $output .= '</ul>';

            return $output;
        } else {
            $output .= <<<FORM
<style>
    body{
        height: 100vh;
        width: 100%;
        background-image: url("img/bg.jpg");
        position: relative;
        isolation: isolate;
        color: white;
    }
    
    body::after {
        content: '';
        position: absolute;
        z-index: -1;
        inset: 0;
        background-color: black;
        opacity: .6;
    }
</style>
<div class="box">
    <h1>Bienvenue</h1>

    <h3>Films, séries et bien plus en illimité</h3>
    <form class="auth" method="get">
        <button type="submit" name="action" value="signin">Connection</button>
        <button type="submit" name="action" value="add-user">Inscription</button>
    </form>
</div>
FORM;
        }
        return $output;
    }
}