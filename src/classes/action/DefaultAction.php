<?php

namespace iutnc\netvod\action;

class DefaultAction extends Action
{

    public function execute(): string
    {
        return <<<FORM
<div class="box">
    <h1>Bienvenue</h1>

    <h3>Films, séries et bien plus en illimité</h3>
    <form method="get">
        <button type="submit" name="action" value="signin">Connection</button>
        <button type="submit" name="action" value="add-user">Inscription</button>
    </form>
</div>
FORM;
    }
}