<?php


namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\User;
use iutnc\netvod\Utils;

class ProfilAction extends Action
{

    /**
     * @param string $output
     * @return string
     */
    public function execute(): string
    {
        $result = "";

        $PDO = ConnectionFactory::makeConnection();


        if (Auth::connected()) {
            switch ($this->http_method) {
                case 'POST':
                    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if ($id_genre = filter_var($_POST['genrePref'], FILTER_VALIDATE_INT)) {
                        $id_user = User::sessionUser()->id;

                        $addGenre = $PDO->prepare('UPDATE User SET nom = ?, prenom = ?, id_genre_pref = ? WHERE id = ?');
                        $addGenre->bindParam(1, $nom);
                        $addGenre->bindParam(2, $prenom);
                        $addGenre->bindParam(3, $id_genre);
                        $addGenre->bindParam(4, $id_user);
                        $addGenre->execute();
                    }
                case 'GET':
                    $statement = $PDO->prepare('SELECT id_genre id, libelleGenre libelle FROM genre');
                    $statement->execute();

                    $statement2 = $PDO->prepare('SELECT id id, titre title FROM serie');
                    $statement2->execute();


                    $options = '';
                    while ($data = $statement->fetch()) {
                        $options .= "<option value='{$data['id']}'>{$data['libelle']}</option>";
                    }

                    $options2 = '';
                    while ($data2 = $statement2->fetch()) {
                        $options2 .= "<option value='{$data2['id']}'>{$data2['title']}</option>";
                    }


                    $result .= <<<FORM
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
    <h3>Gestion du Profil</h3>
    <form class="auth" method="post">
        <input type="nom" id="nom" name="nom" placeholder="Nom" required>
        <input type="prenom" id="prenom" name="prenom" placeholder="prenom"  required>
        <div>Genre Préféré :  
            <select name="genrePref" id="genrePref">
                <option value="0">-Choisis une option-</option>
                $options
            </select>
        </div>
        <button type="submit">Enregistrer</button>
    
      
    </form>
</div>
FORM;
            }
        } else {
            Utils::redirect();
        }

        return $result;
    }
}
