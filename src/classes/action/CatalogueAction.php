<?php

namespace classes\action;

use iutnc\netvod\action\Action;
use iutnc\netvod\auth\Auth;

class CatalogueAction extends Action
{

    public function execute(): string
    {

        /**
         * @param string $output
         * @return string
         */
        $output = '';
        switch ($this->http_method) {
            case 'GET':

                // TODO
                $output .= <<<FORM
                <form method="post" action="?action=news&id=1">
                </form>

                FORM;
                break;
            case 'POST':
                $playlists = '';

                // TODO

                break;
        }
        return $output;
    }
}