<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\User;
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
                    $output .="<h1><div> Episode n° {$episode['num']}</div></h1>";
                    $output .= "<h2>{$episode['title']}</h2>";

                    $output .= "<div></div><video controls src='video/{$episode['fil']}'></video></div>";


                    $output .="<img src='{$episode['img']}' alt=\"Une image correspond à l'episode\">";

                    $output .= "<div> Résumé : <p>{$episode['res']}</p></div>";
                    $output .= "<div> Durée: <p>{$episode['dur']} min</p></div>";

                    $watch_statement = $PDO->prepare('INSERT INTO userWatch VALUES (?, ?, 0)');//TODO

                    $id_user = User::sessionUser()->id;

                    $watch_statement->bindParam(1, $id_user);
                    $watch_statement->bindParam(2,$episode['idse']);
                    //$watch_statement->execute();//TODO







                }

            }



        return $output;
    }
}


