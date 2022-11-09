<?php

namespace iutnc\netvod\action;

use iutnc\netvod\Utils;

class DefaultAction extends Action
{

    public function execute(): string
    {
        Utils::redirect();
        return '';
    }
}