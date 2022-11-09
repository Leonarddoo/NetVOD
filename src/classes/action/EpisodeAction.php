<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\Utils;

class EpisodeAction extends Action
{
    public function execute(): string
    {
        $output = '';
        if ($id = filter_var($_GET['id'], FILTER_VALIDATE_INT)) {

                $PDO = ConnectionFactory::makeConnection();

                $episode_statement= $PDO->prepare('SELECT id i,numero num ,titre title,resume res,duree dur,file fil,serie_id idse,img FROM episode WHERE episode.id = ?');
                $episode_statement-> bindParam(1,$id);
                $episode_statement->execute();


                if($episode = $episode_statement->fetch()){
                    $output .= "<h3>{$episode['title']}</h3>";

                    $output .="<img src='{$episode['img']}' alt=\"Une image correspond à l'episode\">";
                    $output .="<div> Episode n° {$episode['i']}</div>";
                    $output .="<div> {$episode['title']}</div>";

                    $output .= "<div> Résumé : <p>{$episode['res']}</p></div>";
                    $output .= "<div> Durée: <p>{$episode['dur']}</p></div>";




                }

            }



        return $output;
    }
}

