<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\Utils;

class AddUserAction extends Action
{

    /**
     * @param string $output
     * @return string
     */
    public function execute(): string
    {
        $result = "";

        switch ($this->http_method) {
            case 'GET':
                if (Auth::connected()) {
                    Utils::redirect();
                } else {
                    $result .= <<<FORM
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
    <h3>S'enregister</h3>
    <form class="auth" method="post">
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="passwd" placeholder="Mot de passe"  required>
        <input type="password" id="v-password" name="check-passwd" placeholder="Répéter le mot de passe"  required>
    
        <button type="submit">S'inscrire</button>
        <p>Vous avez déjà un compte ? <a href="?action=signin">Connectez-vous</a></p>
    </form>
</div>
FORM;
                }

                break;
            case 'POST':
                if ($_POST['passwd'] === $_POST['check-passwd']) {
                    $result .= Auth::register($_POST['email'], $_POST['passwd']) ? 'Utilisateur enregistré' : 'Erreur d\'enregistrement';
                } else {
                    $result .= 'Les deux champs de mot de passe ne correspondent pas';
                }
                break;
        }
        return $result;
    }
}