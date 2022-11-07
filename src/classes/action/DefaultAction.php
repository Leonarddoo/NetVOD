<?php

namespace iutnc\netvod\action;

class DefaultAction extends Action
{

    public function execute(): string
    {
        header('Location: ?');
        return '';
    }
}