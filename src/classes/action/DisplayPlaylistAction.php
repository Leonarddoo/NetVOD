<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\auth\Auth;
use iutnc\deefy\render\AudioListRenderer;

class DisplayPlaylistAction extends Action
{

    /**
     * @param string $output
     * @return string
     */
    public function execute(): string
    {
        $output = '';
        $playlist = Playlist::find($_GET['id']);
        if ($playlist != null) {
            if (Auth::ownPlaylist($_GET['id'])) {
                $render = new AudioListRenderer($playlist);
                $output .= $render->render();
            } else {
                http_response_code(403);
                $output .= 'Accès interdit à cette playlist';
            }
        } else {
            http_response_code(404);
            $output .= 'Playlist non trouvée';
        }
        return $output;
    }
}