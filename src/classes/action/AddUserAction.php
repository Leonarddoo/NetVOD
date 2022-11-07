<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\Auth;

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
                    <button name="submit">Connexion</button>
                </form>';
                break;
            case 'POST':
                $result .= Auth::register($_POST['email'], $_POST['passwd']) ? 'Utilisateur enregistré' : 'Erreur d\'enregistrement';
                break;
        }
        return $result;
    }
}