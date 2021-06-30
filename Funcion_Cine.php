<?php

class Funcion_Cine extends Funcion{
    
    private $genero;
    private $pais;
    
    public function __construct(){
        parent:: __construct();
        $this->genero="";
        $this->pais="";
    }
    
    public function cargar($idfuncion,$nombre,$horaInicio,$duracion,$precio,$objteatro,$genero,$pais){
        parent::cargar2($idfuncion,$nombre,$horaInicio,$duracion,$precio,$objteatro);
        $this->setGenero($genero);
        $this->setPais($pais);
    }
    /*public function cargar($datos){
        parent:: cargar2($datos);
        $this->setGenero($datos['genero']);
        $this->setPais($datos['pais']);
    }*/

    public function getGenero(){
        return $this->genero;
    }

    public function getPais(){
        return $this->pais;
    }

    public function setGenero($genero){
        $this->genero = $genero;
    }

    public function setPais($pais){
        $this->pais = $pais;
    }

    public function Buscar($idfuncion){
        $base=new BaseDatosTeatro();
        $consultaFuncion="Select * from funcine where idfuncion=".$idfuncion;
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaFuncion)){
                if($row=$base->Registro()){
                    parent::Buscar($idfuncion);
                    $this->setGenero($row['genero']);
                    $this->setPais($row['pais']);
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
        $consultaFuncion="SELECT funcion.idfuncion,funcion.nombre as nombre,funcion.horainicio as horainicio, funcion.duracion as duracion,funcion.precio as precio,funcion.idteatro as idteatro,genero,pais FROM `funcine` 
                          INNER JOIN funcion ON funcine.idfuncion=funcion.idfuncion";
        if ($condicion!=""){
            $consultaFuncion=$consultaFuncion.' where '.$condicion;
        }
        $consultaFuncion.=" order by genero ";
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaFuncion)){
                $arregloFuncion= array();
                while($row=$base->Registro()){
                    $funcion=new Funcion_Cine();
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
        if(parent:: insertar()){
        $consultaInsertar="INSERT INTO funcine(idfuncion,genero,pais)
				VALUES (".parent::getIdFuncion().",'".$this->getGenero()."','".$this->getPais()."')";
        echo $consultaInsertar;
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
        $consultaModifica="UPDATE funcine SET genero='".$this->getGenero()."',pais='".$this->getPais()."'
                            WHERE idfuncion=". parent::getIdfuncion();
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
            $consultaBorra="DELETE FROM funcine WHERE idfuncion=".$this->getIdFuncion();
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

    public function darCosto(){
        $costo=parent:: darCosto()*1.65;
        return $costo;
    }

    public function __toString(){
        return
        "\nCINE: \n".parent:: __toString()
        ."\nGENERO: ".$this->getGenero()
        ."\nPAIS: ".$this->getPais()."\n";
    }
}