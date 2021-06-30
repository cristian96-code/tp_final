<?php

class Funcion{
    private $idfuncion;
    private $nombre;
    private $horaInicio;
    private $duracion;
    private $precio;
    private $objteatro;
    private $mensajeoperacion;
    
    public function __construct(){
        $this->idfuncion=0;
        $this->nombre="";
        $this->horaInicio="";
        $this->duracion="";
        $this->precio="";
        $this->objteatro="";
    }
    
    public function cargar2($idfuncion,$nombre,$horaInicio,$duracion,$precio,$objteatro){
        $this->setIdfuncion($idfuncion);
        $this->setNombre($nombre);
        $this->setHoraInicio($horaInicio);
        $this->setDuracion($duracion);
        $this->setPrecio($precio);
        $this->setObjTeatro($objteatro);
    }
    /*public function cargar2($datos){
        $this->setIdfuncion($datos['idfuncion']);
        $this->setNombre($datos['nombre']);
        $this->setHoraInicio($datos['horainicio']);
        $this->setDuracion($datos['duracion']);
        $this->setPrecio($datos['precio']);
        $this->setObjTeatro($datos['idteatro']);
    }*/

    public function getIdFuncion(){
        return $this->idfuncion;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getHoraInicio(){
        return $this->horaInicio;
    }
    public function getDuracion(){
        return $this->duracion;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function getObjTeatro(){
        return $this->objteatro;
    }
    public function getmensajeoperacion(){
        return $this->mensajeoperacion ;
    }
    
    public function setIdfuncion($idfuncion){
        $this->idfuncion=$idfuncion;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setHoraInicio($horaInicio){
        $this->horaInicio = $horaInicio;
    }
    public function setDuracion($duracion){
        $this->duracion = $duracion;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }
    public function setObjTeatro($objteatro){
        $this->objteatro=$objteatro;
    }
    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion=$mensajeoperacion;
    }

    public function darCosto(){
        return $this->getPrecio();
    }
    
    public function Buscar($idfuncion){
        $base=new BaseDatosTeatro();
        $consultaFuncion="Select * from funcion where idfuncion=".$idfuncion;
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaFuncion)){
                if($row=$base->Registro()){
                    $this->setIdfuncion($idfuncion);
                    $this->setNombre($row['nombre']);
                    $this->setHoraInicio($row['horainicio']);
                    $this->setDuracion($row['duracion']);
                    $this->setPrecio($row['precio']);
                    $ObjT = new Teatro();
                    $ObjT->Buscar($row['idteatro']);
                    $this->setObjTeatro($ObjT);
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
        $consultaFuncion="Select * from funcion ";
        if ($condicion!=""){
            $consultaFuncion=$consultaFuncion.' where '.$condicion;
        }
        $consultaFuncion.=" order by idfuncion ";
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaFuncion)){
                $arregloFuncion= array();
                while($row=$base->Registro()){
                    $funcion = new Funcion();
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
        $consultaInsertar="INSERT INTO funcion(nombre,horainicio,duracion,precio,idteatro)
				VALUES ('".$this->getNombre()."','".$this->getHoraInicio()."','".$this->getDuracion()."','".$this->getPrecio()."',".$this->getObjTeatro()->get_Idteatro().")";
        echo $consultaInsertar;
        if($base->Iniciar()){
                if($id = $base->devuelveIDInsercion($consultaInsertar)){
                    $this->setIdfuncion($id);
                    $resp=  true;
                }
            	else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp =false;
        $base=new BaseDatosTeatro();
        $consultaModifica="UPDATE funcion SET nombre='".$this->getNombre().
        "',horainicio='".$this->getHoraInicio()."',duracion='".$this->getDuracion()."',precio='".$this->getPrecio()."',idteatro=".$this->getObjTeatro()->get_Idteatro().
        " WHERE idfuncion=". $this->getIdFuncion();
        echo $consultaModifica;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaModifica)){
                $resp=  true;
            }else{
                $this->setmensajeoperacion($base->getError());
                
            }
        }else{
            $this->setmensajeoperacion($base->getError());
            
        }
        return $resp;
    }
    
    public function eliminar(){
        $base=new BaseDatosTeatro();
        $resp=false;
        if($base->Iniciar()){
            $consultaBorra="DELETE FROM funcion WHERE idfuncion=".$this->getIdFuncion();
            if($base->Ejecutar($consultaBorra)){
                $resp=  true;
            }else{
                $this->setmensajeoperacion($base->getError());
                
            }
        }else{
            $this->setmensajeoperacion($base->getError());
            
        }
        return $resp;
    }
    
    public function horaInicioFuncion(){
        $array=$this->getHoraInicio();
        $string="";
        $string=$array["h"].":".$array["m"];   
        return $string;        
    }
    public function __toString(){
        return 
        "\nID Funcion: ".$this->getIdFuncion().
        "\nNombre: ".$this->getNombre().
        "\nHora de Inicio: ".$this->getHoraInicio().
        "\nDuracion: ".$this->getDuracion().
        "\nPrecio: ".$this->getPrecio();
    }
}
?>