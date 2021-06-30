<?php
//include_once "Funcion.php";
class Funcion_Musicales extends Funcion{
    
    private $director;  
    private $cantidad_actores;    
    
    public function __construct(){
        parent:: __construct();
        $this->cantidad_actores="";
        $this->director="";
    }
    
    public function cargar($idfuncion,$nombre,$horaInicio,$duracion,$precio,$objteatro,$director,$cantidad_actores){
        parent:: cargar2($idfuncion,$nombre,$horaInicio,$duracion,$precio,$objteatro);
        $this->setDirector($director);
        $this->setCantidad_actores($cantidad_actores);
    }
    /*public function cargar($datos){
        parent:: cargar2($datos);
        $this->setDirector($datos['director']);
        $this->setCantidad_actores($datos['cantactores ']);
    }*/
    
    public function getDirector(){
        return $this->director;
    }

    public function getCantidad_actores(){
        return $this->cantidad_actores;
    }

    public function setDirector($director){
        $this->director = $director;
    }

    public function setCantidad_actores($cantidad_actores){
        $this->cantidad_actores = $cantidad_actores;
    }

    public function Buscar($idfuncion){
        $base=new BaseDatosTeatro();
        $consultaFuncion="Select * from funmusical where idfuncion=".$idfuncion;
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaFuncion)){
                if($row=$base->Registro()){
                    parent::Buscar($idfuncion);
                    $this->setDirector($row['director']);
                    $this->setCantidad_actores($row['cantactores']);
                    $resp= true;
                }
                
            }	else {
                $this->setmensajeoperacion($base->getError());
                
            }
        }	else {
            $this->setmensajeoperacion($base->getError());
            
        }
        return $resp;
    }
    
    public function listar($condicion=""){
        $arregloFuncion = null;
        $base=new BaseDatosTeatro();
        $consultaFuncion="SELECT funcion.idfuncion,funcion.nombre as nombre,funcion.horainicio as horainicio, funcion.duracion as duracion,funcion.precio as precio,funcion.idteatro as idteatro,director,cantactores FROM `funmusical` 
                          INNER JOIN funcion ON funmusical.idfuncion=funcion.idfuncion";
        if ($condicion!=""){
            $consultaFuncion=$consultaFuncion.' where '.$condicion;
        }
        $consultaFuncion.=" order by director ";
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaFuncion)){
                $arregloFuncion= array();
                while($row=$base->Registro()){
                    $funcion=new Funcion_Musicales();
                    $funcion->Buscar($row['idfuncion']);
                    array_push($arregloFuncion,$funcion);
                }
            }	else {
                $error=$base->getError();
                $this->setmensajeoperacion($error);
                
            }
        }	else {
            $this->setmensajeoperacion($base->getError());
            
        }
        return $arregloFuncion;
    }

    public function insertar(){
        $base=new BaseDatosTeatro();
        
        $resp= false;
        if(parent::insertar()){
            $consultaInsertar="INSERT INTO funmusical(idfuncion,director,cantactores)
            VALUES (".parent::getIdFuncion().",'".$this->getDirector()."',".$this->getCantidad_actores().")";
            if($base->Iniciar()){
                if($base->Ejecutar($consultaInsertar)){
                    $resp=  true;
                }	else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        }
        return $resp;
    }
    public function modificar(){
        $resp =false;
        $base=new BaseDatosTeatro();
        if(parent::modificar()){
        $consultaModifica="UPDATE funmusical SET director='".$this->getDirector()."',cantactores='".$this->getCantidad_actores().
        "'WHERE idfuncion=". parent::getIdfuncion();
        if($base->Iniciar()){
            if($base->Ejecutar($consultaModifica)){
                $resp=  true;
            }else{
                $this->setmensajeoperacion($base->getError());
                
            }
        }else{
            $this->setmensajeoperacion($base->getError());
            
        }
        }
        return $resp;
    }
    public function eliminar(){
        $base=new BaseDatosTeatro();
        $resp=false;
        if($base->Iniciar()){
            $consultaBorra="DELETE FROM funmusical WHERE idfuncion=".$this->getIdFuncion();
            if($base->Ejecutar($consultaBorra)){
                if(parent::eliminar()){
                    $resp=  true;
                }
            }else{
                $this->setmensajeoperacion($base->getError());
                
            }
        }else{
            $this->setmensajeoperacion($base->getError());
            
        }
        return $resp;
    }

    /////
    public function darCosto(){
        $costo=parent:: darCosto()*1.12;
        return $costo;
    }

    public function __toString(){
        return
        "\nMUSICAL: \n".parent:: __toString().
        "\nDIRECTOR: ".$this->getDirector().
        "\nCANTIDAD DE PERSONAS EN ESCENA: ".$this->getCantidad_actores();
    }
}