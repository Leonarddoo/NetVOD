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

            null => new HomeAction(),
            'signin' => new SigninAction(),
            'add-user' => new AddUserAction(),

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
        <link rel="stylesheet" href="style.css">
        <title>NetVOD</title>
    </head>
    <body>
        <header>
            <a href="?"><img src="img/logo.png" alt="logo"></a>
        </header>
        $html
    </body>
</html>
FORM;
    }
}