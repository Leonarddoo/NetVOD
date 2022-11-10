<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\exception\AuthException;
use iutnc\netvod\Utils;

class SigninAction extends Action
{

    /**
     * @param string $output
     * @return string
     */
    public function execute(): string
    {
        $output = '';
        switch ($this->http_method) {
            case 'GET':
                if (Auth::connected()) {
                    Utils::redirect();
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
                        <h3>S'identifier</h3>
                        <form class="auth" method="post">
                            <input type="email" id="email" name="email" placeholder="Email" required>
                            <input type="password" id="password" name="passwd" placeholder="Mot de passe"  required>
                    
                            <button type="submit">Se connecter</button>
                            
                            <p>Vous n'avez pas de compte ? <a href="?action=add-user">Inscrivez-vous</a></p>
                        </form>
                    </div>
                    FORM;
                }
//                <form method="post" action="?action=signin">
//                    <label>Email :
//                        <input type="email" name="email">
//                    </label>
//                    <label>Mot de passe :
//                        <input type="password" name="passwd">
//                    </label>
//                    <button type="submit">Connexion</button>
//                </form>
//                FORM;
                break;
            case 'POST':
                try {
                    Auth::authenticate($_POST['email'], $_POST['passwd']);
                    Utils::redirect();
                } catch (AuthException) {
                    $output .= 'Erreur d\'authentification';
                }
                break;
        }
        return $output;
    }
}