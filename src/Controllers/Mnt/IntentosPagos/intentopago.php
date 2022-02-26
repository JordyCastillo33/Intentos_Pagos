<?php

    namespace Controllers\Mnt\IntentosPagos;

use Controllers\PublicController;
use Views\Renderer;

    class IntentoPago extends PublicController
    {
        private $_modeStrings = array(
            "INS" => "Nuevo Intento de Pago",
            "UPD" => "Editar %s (%s)",
            "DSP" => "Detalle de %s (%s)",
            "DEL" => "Eliminando %s (%s)"
        );
        private $_estIntentos = array(
            "ENV" => "Enviado",
            "PGD" => "Pagado",
            "CNL" => "Cancelado",
            "ERR" => "Error"
        );
        private $_viewData = array(
            "mode" => "INS",
            "id"=> 0,
            "fecha" => "",
            "cliente" => "",
            "fechaVencimiento" => "",
            "estado" => "ENV",
            "modeDsc" => "",
            "readonly" => false,
            "isInsert" => false,
            "estIntentos"=>[],
            "csxsToken" => ""
        );
        private function init(){
            if (isset($_GET["mode"]))
            {
                $this->_viewData["mode"] = $_GET["mode"];
            }
            if (isset($_GET["id"]))
            {
                $this->_viewData["id"] = $_GET["id"];
            }

            if(!isset($this->_modeStrings[$this->_viewData["mode"]]))
            {
                error_log($this->toString()."Mode not valid ". $this->_viewData["mode"],0);
                \Utilities\Site::redirectToWithMsg('index.php?page=mnt.intentospagos.intentospagos', 
                'Sucedio un error al procesar la pagina');
            }

            if ($this->_viewData["mode"] !== "INS" && intval($this->_viewData["id"],10) !== 0)
            {
                $this->_viewData["mode"] !== "DSP";
            }
        }
        private function handlePost()
        {
            \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);
            
            if(!isset($_SESSION["intentoPago_crsxToken"]) || $_SESSION["intentoPago_crsxToken"] !== $this->_viewData["crsxToken"])
            {
                unset($_SESSION["intentoPago_crsxToken"]);
                \Utilities\Site::redirectToWithMsg('index.php?page=mnt.intentospagos.intentospagos', 
                'Ocurrio un error, no se puede procesar' );
            }
        $this->_viewData["id"] = intval($this->_viewData["id"], 10);
        if (!\Utilities\Validators::isMatch(
            $this->_viewData["estado"],
            "/^(ENV)|(PGD)|(CNL)|(ERR)$/"
        )
        ) {
            $this->_viewData["errors"][] = "El intento de pago debe ser ENV, PGD, CNL o ERR";
        }

        if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0 ) {

        } else {
            unset($_SESSION["intentoPago_crsxToken"]);
            switch ($this->_viewData["mode"]) {
            case 'INS':
                # code...
                $result = \Dao\Mnt\IntentosPagos::agregarIntentosPagos(
                    $this->_viewData["cliente"],
                    $this->_viewData["monto"],
                    $this->_viewData["fechaVencimiento"],
                    $this->_viewData["estado"]
                );
                
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.intentospagos.intentospagos',
                        "¡Registro agregado satisfactoriamente!"
                    );
                }
                break;
            case 'UPD':
                $result = \Dao\Mnt\IntentosPagos::modificarIntentosPagos(
                    $this->_viewData["cliente"],
                    $this->_viewData["monto"],
                    $this->_viewData["fechaVencimiento"],
                    $this->_viewData["estado"],
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.intentospagos.intentospagos',
                        "¡Registro modificado satisfactoriamente!"
                    );
                }
                break;
            case 'DEL':
                $result = \Dao\Mnt\IntentosPagos::eliminarIntentosPagos(
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.intentospagos.intentospagos',
                        "¡Registro eliminado satisfactoriamente!"
                    );
                }
                break;
            default:
               
                break;
            }
        }
            

        }

        private function preparaInformacion()
        {
            if ($this->_viewData["mode"] == "INS")
            {
                $this->_viewData["modeDsc"] = $this->_modeStrings[$this->_viewData["mode"]];
            }
            else
            {
                $tmpIntPago = \Dao\Mnt\IntentosPagos::obtenerPorIntId(intval($this->_viewData["id"],10));
                \Utilities\ArrUtils::mergeFullArrayTo($tmpIntPago, $this->_viewData);
                $this->_viewData["modeDsc"] = sprintf($this->_modeStrings[$this->_viewData["mode"]],
                $this->_viewData["cliente"],
                $this->_viewData["id"]
                 );
            }

            $this->_viewData["estIntentos"] = \Utilities\ArrUtils::toOptionsArray(
                $this->_estIntentos,
                'value',
                'text',
                'selected',
                $this->_viewData['estado']
            );                              
            $this->_viewData["crsxToken"] = md5(time()."intentoPago");
            $_SESSION["intentoPago_crsxToken"] = $this->_viewData["crsxToken"];

            
        }
        public function run(): void
        {
            $this->init();
            if($this->isPostBack())
            {
                $this->handlePost();
            }

            $this->preparaInformacion();

            Renderer::render('mnt/IntentoPago', $this->_viewData);
        }
    }


?>