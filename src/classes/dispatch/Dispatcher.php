<?php

namespace iutnc\netvod\dispatch;

use iutnc\netvod\action\AddUserAction;
use iutnc\netvod\action\CatalogueAction;
use iutnc\netvod\action\CommentaireAction;
use iutnc\netvod\action\DefaultAction;
use iutnc\netvod\action\EpisodeAction;
use iutnc\netvod\action\DisconnectAction;
use iutnc\netvod\action\HomeAction;
use iutnc\netvod\action\ProfilAction;
use iutnc\netvod\action\SerieAction;
use iutnc\netvod\action\SigninAction;

class Dispatcher
{
    private ?string $action;

    public function __construct()
    {
        $this->action = $_GET['action'] ?? null;
    }

    public function run(): void
    {
        $action = match ($this->action) {
//            'display-playlist' => new DisplayPlaylistAction(),
            null => new HomeAction(),
            'signin' => new SigninAction(),
            'add-user' => new AddUserAction(),
//            'add-playlist' => new AddPlaylistAction(),
//            'add-podcasttrack' => new AddPodcastTrack(),
            'catalogue' => new CatalogueAction(),
            'serie' => new SerieAction(),
            'episode' => new EpisodeAction(),
            'disconnect' => new DisconnectAction(),
            'comments' => new CommentaireAction(),
            'profil'=> new ProfilAction(),
            default => new DefaultAction()
        };

        $output = $action->execute();
        $this->renderPage($output);
    }

    private function renderPage(string $html): void
    {
        echo <<<FORM
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../../style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
        <title>NetVOD</title>
        <script src="https://kit.fontawesome.com/d15fb273b2.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <style>
            body{
                background-color: #1b1b1b;
            }
        </style>
        <header>
            <nav>
                <a href="?"><img src="img/logo.png" alt="logo"></a>
                <ul>
                    <li><a href="?">Accueil</a></li>
                    <li><a href="?action=catalogue">Catalogue</a></li>
                    <li><a href="?action=profil">Profil</a></li>
                    <li><a href="?action=disconnect">Déconnexion</a></li>
                </ul>
            </nav>
        </header>
        $html
    </body>
</html>
FORM;
    }
}