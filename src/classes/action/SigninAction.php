<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\auth\Auth;
use iutnc\deefy\AuthException;

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
                <form method="post" action="?action=signin">
                    <label>Email : 
                        <input type="email" name="email">
                    </label>
                    <label>Mot de passe : 
                        <input type="password" name="passwd">
                    </label>
                    <button type="submit">Connexion</button>
                </form>
                FORM;
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