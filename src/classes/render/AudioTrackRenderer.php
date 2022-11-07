<?php

namespace iutnc\deefy\render;

abstract class AudioTrackRenderer implements Renderer
{
    public function render(int $selector): string {
        $string = "<div>";
        switch ($selector) {
            case self::COMPACT:
                $string .= $this->show_compact();
                break;
            case self::LONG:
                $string .= $this->show_long();
                break;
        }
        $string .= "</div><audio controls src='{$this->fichier()}'></audio>";

        return $string;
    }

    abstract function show_compact(): string;

    abstract function show_long(): string;

    abstract function fichier(): string;
}