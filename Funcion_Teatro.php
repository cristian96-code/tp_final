<?php


//include_once "Funcion.php";

class Funcion_Teatro extends Funcion{
    
    public function __construct(){
        parent:: __construct();
    }
    public function darCosto(){
        $costo=parent:: darCosto()*1.45;
        return $costo;
    }
    public function cargar($idfuncion,$nombre,$horaInicio,$duracion,$precio,$objteatro){
        parent::cargar2($idfuncion,$nombre,$horaInicio,$duracion,$precio,$objteatro);
    }
    /*public function cargar($datos){
        parent:: cargar2($datos);
    }*/
    
    public function Buscar($idfuncion){
        $base=new BaseDatosTeatro();
        $consultaFuncion="Select * from funteatro where idfuncion=".$idfuncion;
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaFuncion)){
                parent::Buscar($idfuncion);
                $resp= true;
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
        $consultaFuncion="SELECT funcion.idfuncion,funcion.nombre as nombre,funcion.horainicio as horainicio, funcion.duracion as duracion,funcion.precio as precio,funcion.idteatro FROM `funteatro` 
                          INNER JOIN funcion ON funteatro.idfuncion=funcion.idfuncion";
        if ($condicion!=""){
            $consultaFuncion=$consultaFuncion.' where '.$condicion;
        }
        $consultaFuncion.=" order by nombre ";
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaFuncion)){
                $arregloFuncion= array();
                while($row=$base->Registro()){
                    $funcion=new Funcion_Teatro();
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
            $consultaInsertar="INSERT INTO funteatro(idfuncion)
				VALUES (".parent::getIdFuncion().")";
            
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
            $consultaModifica="UPDATE funteatro SET 
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
            $consultaBorra="DELETE FROM funteatro WHERE idfuncion=".$this->getIdFuncion();
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
    
    public function __toString(){
        return 
        "\nOBRA: \n".parent:: __toString()."\n";
    }
}