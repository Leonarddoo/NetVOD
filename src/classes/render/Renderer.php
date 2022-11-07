<?php

namespace iutnc\deefy\render;

interface Renderer{
    const COMPACT =0;
    const LONG=1;

    public function render(int $selector):string;


}