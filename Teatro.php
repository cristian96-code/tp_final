<?php

class Teatro{
    //variables instancia
    private $idteatro;
    private $nombre;
    private $direccion;
    private $colObjFunciones;//coleccion de funciones
    private $mensajeoperacion;
    
    public function __construct(){
        $this->idteatro=0;
        $this->colObjFunciones="";
        $this->nombre="";
        $this->direccion="";
    }
    
    
    /*public function cargar($idteatro,$nombre,$direccion){
        Teatro::set_Idteatro($idteatro);
        Teatro::set_Nombre($nombre);
        Teatro::set_Direccion($direccion);
    }*/
    public function cargar($idteatro,$nombre,$direccion){
        $this->set_Idteatro($idteatro);
        $this->set_Nombre($nombre);
        $this->set_Direccion($direccion);
    }
    
    public function get_Idteatro(){
        return $this->idteatro;
    }
    public function get_Nombre(){
        return $this->nombre;
    }
    
    public function get_Direccion(){
        return $this->direccion;
    }
    public function getColObjFunciones(){
            $idTeatro = $this->get_Idteatro();
            $condicion = "idteatro=".$idTeatro;
            $funcine=new Funcion_Cine();
            $funmusical=new Funcion_Musicales();
            $funteatro=new Funcion_Teatro();
            $funcines = $funcine->listar($condicion);
            $funmusicales = $funmusical->listar($condicion);
            $funteatros = $funteatro->listar($condicion);
            $colFunciones = array_merge($funcines,$funmusicales,$funteatros);
            $this->setColObjFunciones($colFunciones);

        return $this->colObjFunciones;
    }
    public function getmensajeoperacion(){
        return $this->mensajeoperacion ;
    }

    public function set_Idteatro($idteatro){
        $this->idteatro=$idteatro;
    }
    public function set_Nombre($nombre_Nuevo){
        return $this->nombre=$nombre_Nuevo;
    }
    public function set_Direccion($direccion_Nueva){
        return $this->direccion=$direccion_Nueva;
    }
    public function setColObjFunciones($colObjFunciones){
        $this->colObjFunciones = $colObjFunciones;
    }
    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion=$mensajeoperacion;
    }
    
    public function Buscar($id){
        $base=new BaseDatosTeatro();
        $consultaTeatro="Select * from teatro where idteatro=".$id;
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaTeatro)){
                if($row2=$base->Registro()){
                    $this->set_Idteatro($id);
                    $this->set_Nombre($row2['nombre']);
                    $this->set_Direccion($row2['direccion']);
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
        $arregloTeatro = null;
        $base=new BaseDatosTeatro();
        $consultaTeatro="Select * from teatro ";
        if ($condicion!=""){
            $consultaTeatro=$consultaTeatro.' where '.$condicion;
        }
        $consultaTeatro.=" order by idteatro ";
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaTeatro)){
                $arregloTeatro= array();
                while($row=$base->Registro()){
                    $teatro=new Teatro();
                    $teatro->Buscar($row['idteatro']);
                    array_push($arregloTeatro,$teatro);
                }
                }	else {
                $error=$base->getError();
                $this->setmensajeoperacion($error);
                
            }
        }	else {
            $this->setmensajeoperacion($base->getError());
            
        }
        return $arregloTeatro;
    }
    
    public function insertar(){
        $base=new BaseDatosTeatro();
        $resp= false;
        $consultaInsertar="INSERT INTO teatro(nombre,direccion)
				VALUES ('".$this->get_Nombre()."','".$this->get_Direccion()."')";
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaInsertar)){
                $resp=  true;
            }	else {
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
        $consultaModifica="UPDATE teatro SET nombre='".$this->get_Nombre()."',direccion='".$this->get_Direccion().
        "'WHERE idteatro=". $this->get_Idteatro();
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
            $consultaBorra="DELETE FROM teatro WHERE idteatro=".$this->get_Idteatro();
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
    
   /*
    ------------------------------------------------------------------------------------------------------------------------------------------------------
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ------------------------------------------------------------------------------------------------------------------------------------------------------
    */
    
    /** funcion para saber si hay solapamientao
     * 
     */
    public function arrayFunciones(){
        $fun=new Funcion();
        $funciones=$fun->listar();
        return $funciones;
    }

    /**calcular el fin de una funcion
     * @return array
     */
    public function arrayHora($horainicio){
        $horario=$horainicio;
        $array=["h"=>$horario[0].$horario[1],"m"=>$horario[3].$horario[4]];
        return $array;
    }
    public function finFuncion($horainicio,$duracion){
        $finFuncion=array();
        $inicioFuncion=$this->arrayHora($horainicio);
        
        if(($duracion+$inicioFuncion["m"])>59){
            $min=($duracion+$inicioFuncion["m"])%60;
            $hs=$inicioFuncion["h"]+intval(($duracion+$inicioFuncion["m"])/60);
            $finFuncion=["h"=>$hs,"m"=>$min];
        }elseif(($duracion+$inicioFuncion["m"])<59){
            $finFuncion=["h"=>$inicioFuncion["h"],"m"=>$duracion+$inicioFuncion["m"]];
        }
        if($finFuncion["h"]>23){
            $hs=intval(($duracion+$inicioFuncion["m"])/60);
            $min=($duracion+$inicioFuncion["m"])%60;
            $finFuncion=["h"=>$hs,"m"=>$min];
        }
        return $finFuncion;
    }

    // public function agregarFuncion($funcion){
    public function solapamiento($nombre,$duracion,$horainicio){
        $agregado=false;
        $arrayFunciones=$this->arrayFunciones();
        $nombreFuncion=$nombre;
        $finFuncion=$this->finFuncion($horainicio,$duracion);
        $inicioFuncion=$this->arrayHora($horainicio);
        $i=0;
        if(count($arrayFunciones)>0){
            foreach($arrayFunciones as $funciones){
                
                $finFunciones=$this->finFuncion($funciones->getHoraInicio(),$funciones->getDuracion());
                $inicioFunciones=$this->arrayHora($funciones->getHoraInicio());
            
                if(!($funciones->getNombre()==$nombreFuncion)){
                    if(($finFuncion["h"]<$inicioFunciones["h"]&&$inicioFuncion["h"]<$inicioFunciones["h"])||
                        (($finFuncion["h"]==$inicioFunciones["h"])&&$finFuncion["m"]<$inicioFunciones["m"])||
                                    ($inicioFuncion["h"]>$finFunciones["h"])||($inicioFuncion["h"]==$finFunciones["h"]&&$inicioFuncion["m"]>$finFunciones["m"])){
                        $i++;
                    }   
                }
            }
        }
        if(count($arrayFunciones)==$i){
            $agregado=true;
        }
        return $agregado;
    }

    public function agregarFuncionTeatro($id,$nFuncion,$horario,$duracion,$precio,$objteatro){
        $funcion=new Funcion_Teatro();
        $insert=false;
        $funcion->cargar($id,$nFuncion,$horario,$duracion,$precio,$objteatro);
        if($this->solapamiento($nFuncion,$duracion,$horario)){
            $insert=$funcion->insertar();
        }
        return $insert;
    }
    public function agregarFuncionCine($id,$nFuncion,$horario,$duracion,$precio,$objteatro,$genero,$pais){
        $funcion=new Funcion_Cine();
        $insert=false;
        $funcion->cargar($id,$nFuncion,$horario,$duracion,$precio,$objteatro,$genero,$pais);
        if($this->solapamiento($nFuncion,$duracion,$horario)){
        $insert=$funcion->insertar();
        }
        return $insert;
    }
    public function agregarFuncionMusicales($id,$nFuncion,$horario,$duracion,$precio,$objteatro,$director,$cant){
        $funcion=new Funcion_Musicales();
        $insert=false;
        $funcion->cargar($id,$nFuncion,$horario,$duracion,$precio,$objteatro,$director,$cant);
        if($this->solapamiento($nFuncion,$duracion,$horario)){
        $insert=$funcion->insertar();
        }
        return $insert;
    }
    

    public function modificarFuncionTeatro($nombre,$horario,$duracion,$precio,$objteatro,$idfuncion){
        $resultado = false;
        $funcion=new Funcion_Teatro();
        $funcion->setNombre($nombre);
        $funcion->setHoraInicio($horario);
        $funcion->setDuracion($duracion);
        $funcion->setPrecio($precio);
        $funcion->setObjTeatro($objteatro);
        $funcion->setIdfuncion($idfuncion);
        if($this->solapamiento($nombre,$duracion,$horario)){
            $resultado = $funcion->modificar();
            echo "hola";
        }
        //if($resultado){
            return $resultado;
        //}
    }
    public function modificarFuncionCine($nombre,$horario,$duracion,$precio,$objteatro,$genero,$pais,$id){
        $resultado = false;
        $funcion=new Funcion_Cine();
        $funcion->setNombre($nombre);
        $funcion->setHoraInicio($horario);
        $funcion->setDuracion($duracion);
        $funcion->setPrecio($precio);
        $funcion->setObjTeatro($objteatro);
        $funcion->setGenero($genero);
        $funcion->setPais($pais);
        $funcion->setIdfuncion($id);
        if($this->solapamiento($nombre,$duracion,$horario)){
            $resultado = $funcion->modificar();
        }
        if($resultado){
            return $resultado;
        }
    }
    public function modificarFuncionMusicales($nombre,$horario,$duracion,$precio,$objteatro,$director,$cant,$id){
        $resultado = false;
        $funcion=new Funcion_Musicales();
        $funcion->setNombre($nombre);
        $funcion->setHoraInicio($horario);
        $funcion->setDuracion($duracion);
        $funcion->setPrecio($precio);
        $funcion->setObjTeatro($objteatro);
        $funcion->setDirector($director);
        $funcion->setCantidad_actores($cant);
        $funcion->setIdfuncion($id);
        if($this->solapamiento($nombre,$duracion,$horario)){
            $resultado = $funcion->modificar();
        }
        if($resultado){
            return $resultado;
        }
    }

    public function eliminarFuncion($id,$tipo){
        $delete=false;
        if($tipo==1){
            $fun=new Funcion_Teatro();
            $fun->setIdfuncion($id);
            $delete=$fun->eliminar();
        }
        if($tipo==2){
            $fun=new Funcion_Cine();
            $fun->setIdfuncion($id);
            $delete= $fun->eliminar();
        }
        if($tipo==3){
            $fun=new Funcion_Musicales();
            $fun->setIdfuncion($id);
            $delete= $fun->eliminar();
        }
        return $delete;
    }
    
    public function calcularCostoFunciones($idTeatro){
        $funcion= new Funcion();
        $funciones=$funcion->listar();
        $costo=0;
        foreach($funciones as $fun){
            if($idTeatro==$fun->getObjTeatro()->get_Idteatro()){
            $costo+=$fun->getPrecio();          
            }
        }
        return $costo;
    }
    
    /*Recorre coleccion y lo concatena en una variable
     * @return string
     */
    public function verColeccion($coleccion){
        $cadena = "";
        for ($i = 0; $i < count($coleccion); $i++){
            $cadena.= $coleccion[$i];
        }
        return $cadena;
    }
    
    public function __toString(){
        return 
        "\nID Teatro: ".$this->get_Idteatro().
        "\nNombre: ".$this->get_Nombre().
        "\nDireccion: ".$this->get_Direccion().
        "\nFunciones:\n".$this->verColeccion($this->getColObjFunciones());
    }
}
?>