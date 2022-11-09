<?php

namespace iutnc\netvod\action;

use iutnc\netvod\Utils;

class HomeAction extends Action
{

    public function execute(): string
    {
        $output = '';
        if (isset($_SESSION['user'])) {
            $output .= 'Connecté';
            $output .= Utils::linked_button('Déconnexion', 'disconnect');
        } else {
            $output .= <<<FORM
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