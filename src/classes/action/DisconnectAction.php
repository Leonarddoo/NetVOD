<?php

namespace iutnc\netvod\action;

class DisconnectAction extends Action
{

    public function execute(): string
    {
        session_destroy();
        header('Location: ?');
        return '';
    }
}