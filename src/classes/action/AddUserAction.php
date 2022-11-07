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
                $result .= <<<FORM
<div class="box">
    <h3>S'enregister</h3>
    <form method="post">
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Mot de passe"  required>
        <input type="password" id="v-password" name="v-password" placeholder="Répéter le mot de passe"  required>
    
        <button type="submit">S'inscrire</button>
        <p>Vous avez déjà un compte ? <a href="?action=signin">Connectez-vous</a></p>
    </form>
</div>
FORM;
//<form method="post" action="?action=add-user">
//    <label>Email :
//        <input name="email" type="email">
//    </label>
//    <label>Mot de passe :
//        <input name="passwd" type="password">
//    </label>
//    <label>Répéter le mot de passe :
//        <input name="repeat" type="password">
//    </label>
//    <button name="submit">Inscription</button>
//</form>
//FORM;
                break;
            case 'POST':
                if ($_POST['passwd'] === $_POST['v-password']) {
                    $result .= Auth::register($_POST['email'], $_POST['passwd']) ? 'Utilisateur enregistré' : 'Erreur d\'enregistrement';
                } else {
                    $result .= 'Les deux champs de mot de passe ne correspondent pas';
                }
                break;
        }
        return $result;
    }
}