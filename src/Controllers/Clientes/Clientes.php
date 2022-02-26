<?php
    namespace Controllers\Clientes; //Nombre carpeta debe coincidir

use Controllers\PublicController;
use Views\Renderer;

class Clientes extends PublicController//Coincidir con nombre de archivo
{
    public function run(): void {
        $viewData = array();
        $viewData["titulo"] = 'Manejo de Clientes';
        $viewData["clientes"] = array(
            "Orlando",
            "Josue",
            "Adriana",
            "Carlos Gabriel",
            "Argelio"
        );

        Renderer::render('Clientes/clientes', $viewData);
        
    }
}
?>