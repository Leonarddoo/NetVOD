<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;

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
                $result .= '<form method="post" action="?action=add-user">
                    <label>Email :
                        <input name="email" type="email"> 
                    </label>
                    <label>Mot de passe : 
                        <input name="passwd" type="password"> 
                    </label>
                    <label>Répéter le mot de passe : 
                        <input name="repeat" type="password">
                    </label>
                    <button name="submit">Connexion</button>
                </form>';
                break;
            case 'POST':
                if ($_POST['passwd'] === $_POST['repeat']) {
                    $result .= Auth::register($_POST['email'], $_POST['passwd']) ? 'Utilisateur enregistré' : 'Erreur d\'enregistrement';
                } else {
                    $result .= 'Les deux champs de mot de passe ne correspondent pas';
                }
                break;
        }
        return $result;
    }
}