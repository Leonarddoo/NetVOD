<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\User;
use iutnc\netvod\Utils;

class HomeAction extends Action
{

    public function execute(): string
    {
        $output = '';
        if (isset($_SESSION['user'])) {
//            $output .= Utils::linked_button('Catalogue', 'catalogue');
//            $output .= Utils::linked_button('Déconnexion', 'disconnect');

            $PDO = ConnectionFactory::makeConnection();

            $preference_statement = $PDO->prepare('SELECT * FROM userPreference INNER JOIN serie ON id_serie=serie.id WHERE id_user = ?');
            $visionnage_statement = $PDO->prepare('SELECT *, serie.titre s_titre, episode.titre e_titre FROM userWatch INNER JOIN serie ON id_serie=serie.id INNER JOIN episode ON userWatch.id_ep = episode.id WHERE id_user = ?');

            $id_user = User::sessionUser()->id;

            $preference_statement->bindParam(1, $id_user);
            $preference_statement->execute();

            $visionnage_statement->bindParam(1, $id_user);
            $visionnage_statement->execute();

            $output .= <<<LIKE
<div class="title-slide">
      <h3>Vos préférences</h3>
    </div>

    <section>
        <div class="swiper favoris container">
            <div class="swiper-wrapper content">
LIKE;

            while ($data=$preference_statement->fetch()) {
                $output .= <<<LIKE
<a class="swiper-slide card" href="?action=serie&id={$data['id_serie']}">
    <div class="card-content">
        <div class="image">
            <img src='{$data['img']}' alt='Une image correspondant à la série'>
        </div>
<!--        <div class="icons">-->
<!--            <i class="fa-solid fa-heart"></i>-->
<!--        </div>-->

        <div class="text">
            <span class="title">{$data['titre']}</span>
        </div>
    </div>
</a>
LIKE;
            }

            $output .= <<<PROGRESS
</div>
        </div>

        <div class="swiper-button-next favoris-next"></div>
        <div class="swiper-button-prev favoris-prev"></div>
    </section>

    <div class="title-slide">
        <h3>En cours</h3>
    </div>

    <section>
        <div class="swiper enCours container">
            <div class="swiper-wrapper content">
PROGRESS;

            while ($data=$visionnage_statement->fetch()) {
                $output .= <<<PROGRESS
<a class="swiper-slide card" href="?action=episode&id={$data['id']}">
    <div class="card-content">
        <div class="image">
            <img src='{$data['img']}' alt='Une image correspondant à la série'>
        </div>
<!--        <div class="icons">-->
<!--            <i class="fa-solid fa-heart"></i>-->
<!--        </div>-->

        <div class="text">
            <span class="title">{$data['s_titre']}<br>Episode en cours : {$data['e_titre']}</span>
        </div>
    </div>
</a>
PROGRESS;
            }

            $output .= <<<PROGRESS
</div>
    </div>

    <div class="swiper-button-next enCours-next"></div>
    <div class="swiper-button-prev enCours-prev"></div>

</section>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    const favoris = new Swiper(".favoris", {
        slidesPerView: 3,
        spaceBetween: 30,
        slidesPerGroup: 3,
        loop: true,
        loopFillGroupWithBlank: true,
        navigation: {
            nextEl: ".favoris-next",
            prevEl: ".favoris-prev",
        },
    });

    const enCours = new Swiper(".enCours", {
        slidesPerView: 3,
        spaceBetween: 30,
        slidesPerGroup: 3,
        loop: true,
        loopFillGroupWithBlank: true,
        navigation: {
            nextEl: ".enCours-next",
            prevEl: ".enCours-prev",
        },
    });
</script>
PROGRESS;

            return $output;
        } else {
            $output .= <<<FORM
<style>
    body{
        height: 100vh;
        width: 100%;
        background-image: url("img/bg.jpg");
        position: relative;
        isolation: isolate;
        color: white;
    }
    
    body::after {
        content: '';
        position: absolute;
        z-index: -1;
        inset: 0;
        background-color: black;
        opacity: .6;
    }
</style>
<div class="box">
    <h1>Bienvenue</h1>

    <h3>Films, séries et bien plus en illimité</h3>
    <form class="auth" method="get">
        <button type="submit" name="action" value="signin">Connection</button>
        <button type="submit" name="action" value="add-user">Inscription</button>
    </form>
</div>
FORM;
        }
        return $output;
    }
}