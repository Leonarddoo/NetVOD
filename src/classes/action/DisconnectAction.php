<?php

namespace iutnc\netvod\action;

use iutnc\netvod\Utils;

class DisconnectAction extends Action
{

    public function execute(): string
    {
        session_destroy();
        Utils::redirect();
        return '';
    }
}