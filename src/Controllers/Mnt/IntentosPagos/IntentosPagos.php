<?php
   namespace Controllers\Mnt\IntentosPagos;

    use Controllers\PublicController;
    use Views\Renderer;


   class IntentosPagos extends PublicController {
    public function run(): void
    {
        $viewData = array();
        $viewData["intentosPagos"] = \Dao\Mnt\IntentosPagos::obtenerTodos();

        Renderer::render('mnt/IntentosPagos',$viewData);
    }
   }
?>