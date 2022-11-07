<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;

class AddPlaylistAction extends Action
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
                    <form method='post' action='?action=add-playlist'>
                        <label>Nom :
                            <input type='text' name='name'> 
                        </label>
                        <button type='submit'>Ajouter une playlist</button>
                    </form>
                FORM;
                break;
            case 'POST':
                if ($name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                    $_SESSION['ma_playlist'] = serialize(new Playlist($name));
                    $renderer = new AudioListRenderer(unserialize($_SESSION['ma_playlist']));
                    $output .= $renderer->render();
                    $output .= '<a href="?action=add-podcast">Ajouter une piste</a>';
                }
                break;
        }
        return $output;
    }
}