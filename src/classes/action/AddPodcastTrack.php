<?php

namespace iutnc\deefy\action;

class AddPodcastTrack extends Action
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
                    <form method='post' enctype='multipart/form-data'>
                        <label>Fichier mp3 : 
                                <input type='file' name='fichier'>
                        </label>
                        <button type='submit'>Importer</button>
                    </form>
                FORM;
                break;
            case 'POST':
                $path = 'audio/';
                $uniq = uniqid();

                if (!$_FILES['fichier']['error']) {
                    $filename = $_FILES['fichier']['tmp_name'];
                    if (is_uploaded_file($filename)) {
                        if (str_ends_with($_FILES['fichier']['name'], '.mp3') and $_FILES['fichier']['type']) {
                            if (move_uploaded_file($filename, "$path$uniq.mp3")) {
                                echo 'success';
                            }
                        }
                    }
                }
                break;
        }
        return $output;
    }
}