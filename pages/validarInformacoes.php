<?php

class Validar
{
    public function validarInformacoes($info){
        return trim(addslashes(htmlspecialchars($info)));
    }
}
