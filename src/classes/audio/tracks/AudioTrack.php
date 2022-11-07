<?php

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\db\ConnectionFactory;

class AudioTrack{
    private string $titre;
    private string $genre;
    private float $duree;
    private string $filename;

    /**
     * @param string $titre
     * @param string $genre
     * @param int $duree
     * @param string $filename
     */
    public function __construct(string $titre, string $genre, float $duree, string $filename)
    {
        $this->titre = $titre;
        $this->genre = $genre;
        $this->duree = $duree;
        $this->filename = $filename;
    }

    function toString(): string
    {
        return json_encode($this);
    }

    public function __get(string $attr): mixed
    {
        if (property_exists($this, $attr)) return $this->$attr;
        throw new InvalidPropertyNameException("$attr isn't attribute of this instance of class");
    }

    public function __set(string $attr, mixed $value): void{
        if ($attr === 'titre' or $attr === 'filename') {
            throw new NonEditablePropertyException("attribute $attr is not editable");
        } elseif ($attr === 'duree' and $value < 0){
            throw new InvalidPropertyValueException("attribute $attr don't support negative number");
        } elseif (property_exists($this, $attr)) {
            $this->$attr = $value;
        } else throw new InvalidPropertyNameException("$attr isn't attribute of this instance of class");
    }

    public function insertTrack(): void
    {
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare('INSERT INTO track(TITRE, GENRE, DUREE, FILENAME, TYPE, ARTISTE_ALBUM, TITRE_ALBUM, ANNEE_ALBUM, NUMERO_ALBUM, AUTEUR_PODCAST, DATE_POSDCAST) VALUES (?,?,?,?,?,?,?,?,?,?,?)');

        $statement->bindParam(1, $this->titre);
        $statement->bindParam(2, $this->genre);
        $statement->bindParam(3, $this->duree);
        $statement->bindParam(4, $this->filename);

        $statement->execute();
    }
}