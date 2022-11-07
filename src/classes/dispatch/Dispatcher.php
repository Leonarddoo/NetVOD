<?php

namespace iutnc\netvod\dispatch;

use iutnc\netvod\action\AddUserAction;
use iutnc\netvod\action\DefaultAction;
use iutnc\netvod\action\SigninAction;

class Dispatcher
{
    private ?string $action;

    public function __construct()
    {
        $this->action = $_GET['action'] ?? '';
    }

    public function run(): void
    {
        $action = match ($this->action) {
//            'display-playlist' => new DisplayPlaylistAction(),
            'signin' => new SigninAction(),
            'add-user' => new AddUserAction(),
//            'add-playlist' => new AddPlaylistAction(),
//            'add-podcasttrack' => new AddPodcastTrack(),
            default => new DefaultAction(),
        };

        $output = $action->execute();
        $this->renderPage($output);
    }

    private function renderPage(string $html): void
    {
        echo <<<FORM
        <!doctype html>
        <html lang="fr">
            <body>
                $html
            </body>
        </html>
FORM;
    }
}