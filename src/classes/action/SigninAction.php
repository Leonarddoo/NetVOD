<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\exception\AuthException;

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
                $output .= <<<FORM
                    <div class="box">
                        <h3>S'identifier</h3>
                        <form method="post">
                            <input type="email" id="email" name="email" placeholder="Email" required>
                            <input type="password" id="password" name="password" placeholder="Mot de passe"  required>
                    
                            <button type="submit">Se connecter</button>
                            
                            <p>Vous n'avez pas de compte ? <a href="?action=add-user">Inscrivez-vous</a></p>
                        </form>
                    </div>
                    FORM;
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
                    $playlists = '';
                    $user = Auth::authenticate($_POST['email'], $_POST['passwd']);
                    foreach ($user->getPlaylists() as $playlist) {
                        if ($playlist instanceof Playlist) {
                            $playlists .= '<li>' . $playlist->nom . '</li>';
                        }

                    }
                    $output .= "Playlists : <ul>$playlists</ul>";
                } catch (AuthException) {
                    $output .= 'Erreur d\'authentification';
                }
                break;
        }
        return $output;
    }
}