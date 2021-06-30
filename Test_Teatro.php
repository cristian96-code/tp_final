<?php
include_once "BaseDatosTeatro.php";
include_once "Teatro.php";
include_once "Funcion.php";
include_once "Funcion_Musicales.php";
include_once "Funcion_Cine.php";
include_once "Funcion_Teatro.php";

function eliminarFuncion(){
    $objteatro=listaTeatros();
    $id = $objteatro->get_Idteatro();
    $funcine=new Funcion_Cine();
    $funmusical=new Funcion_Musicales();
    $funteatro=new Funcion_Teatro();
    $funcines = $funcine->listar("idteatro=".$id); 
    $funmusicales = $funmusical->listar("idteatro=".$id);
    $funteatros = $funteatro->listar("idteatro=".$id);
    //$colFunciones = array_merge($funteatros,$funcines,$funmusicales);
    $lista="";
    echo 
    "\n--------------------------------------\n
    Ingrese tipo de funcion a eliminar:
    1) Funcion de Teatro
    2) Funcion de Cine
    3) Funcion Musical
    \n--------------------------------------\n
    Ingrese una opcion: ";
    $tipo_funcion=trim(fgets(STDIN));
    while(!(ctype_digit($tipo_funcion)&&$tipo_funcion<=3&&$tipo_funcion>=1)){
        echo "opcion incorrecta vuelva a ingresar 1 , 2, o 3: ";
        $tipo_funcion=trim(fgets(STDIN));
    }
    if($tipo_funcion==1){
        foreach ($funteatros as $fun){
            $lista.=$fun."\n";
        }
    }elseif($tipo_funcion==2){
        foreach ($funcines as $fun){
            $lista.=$fun."\n";
        }
    }elseif($tipo_funcion==3){
        foreach ($funmusicales as $fun){
            $lista.=$fun."\n";
        }
    }
    echo 
    "\nSELECCIONE FUNCION.".$lista."
    Ingrese ID de la Funcion: ";
    $id=trim(fgets(STDIN));
    $eliminado=$objteatro->eliminarFuncion($id,$tipo_funcion)? "Se elimno la funcion seleccionada": "no se elimino";
    
    return $eliminado;
}

function crearFuncion(){
    $objteatro=listaTeatros();
    echo 
    "\n--------------------------------------\n
    Ingrese la opcion deseada:
    1) Funcion de Teatro
    2) Funcion de Cine
    3) Funcion Musical
    \n--------------------------------------\n
    Ingrese una opcion: "; 
    $tipo_funcion=trim(fgets(STDIN));
    while(!(ctype_digit($tipo_funcion)&&$tipo_funcion<=3&&$tipo_funcion>=1)){
        echo "opcion incorrecta vuelva a ingresar 1 , 2, o 3: ";
        $tipo_funcion=trim(fgets(STDIN));
    }
    echo "ingrese nombre de funcion: ";
    $nFuncion=trim(fgets(STDIN));
    echo "ingrese hora de inicio: ";
    $h=trim(fgets(STDIN));
    while(!($h<=23&&$h>=0&&ctype_digit($h))){
        echo "error ingrese una hora entre 0 y 23: ";
        $h=trim(fgets(STDIN));
    }
    echo "ingrese minutos de inicio: ";
    $m=trim(fgets(STDIN));
    while(!($m<=59&&$m>=0&&ctype_digit($m))){
        echo "error ingrese minutos en el rango de 0 a 59: ";
        $m=trim(fgets(STDIN));
    }
    $horario=$h.":".$m;
    echo "ingreses duracion de la funcion: ";
    $duracion=trim(fgets(STDIN));
    while(!ctype_digit($duracion)){
        echo "error ingrese numeros: ";
        $duracion=trim(fgets(STDIN));
    }
    echo "ingrese precio de la funcion: ";
    $precio=trim(fgets(STDIN));
    while(!ctype_digit($precio)){
        echo "error ingrese numeros: ";
        $precio=trim(fgets(STDIN));
    }

    if($tipo_funcion==1){

        $insert=$objteatro->agregarFuncionTeatro(null,$nFuncion,$horario,$duracion,$precio,$objteatro);
        
    }elseif($tipo_funcion==2){
        echo "ingrese Genero de Pelicula: ";
        $genero=trim(fgets(STDIN));
        echo "ingrese Pais de Origen: ";
        $pais=trim(fgets(STDIN));
        $insert=$objteatro->agregarFuncionCine(null,$nFuncion,$horario,$duracion,$precio,$objteatro,$genero,$pais);
    
    }elseif($tipo_funcion==3){
        echo "Ingrese Nombre de director del Musical: ";
        $director=trim(fgets(STDIN));
        echo "ingrese cantidad de personas en escena: ";
        $cant=trim(fgets(STDIN));
        $insert=$objteatro->agregarFuncionMusicales(null,$nFuncion,$horario,$duracion,$precio,$objteatro,$director,$cant);
    }
    return $insert;
}

function seleccionarFunciones(){
    $objteatro=listaTeatros();
    $id = $objteatro->get_Idteatro();
    $funcine=new Funcion_Cine();
    $funmusical=new Funcion_Musicales();
    $funteatro=new Funcion_Teatro();
    $funcines = $funcine->listar("idteatro=".$id); 
    $funmusicales = $funmusical->listar("idteatro=".$id);
    $funteatros = $funteatro->listar("idteatro=".$id);
    $colFunciones = array_merge($funteatros,$funcines,$funmusicales);
    $lista="";
    foreach ($colFunciones as $fun){
        $lista.=$fun."\n";
    }
    echo 
    "\nSELECCIONE FUNCION.".$lista."
    Ingrese ID de la Funcion: ";
    $id=trim(fgets(STDIN));
    return $id;
}

function listaFunciones(){
    $objteatro=listaTeatros();
    $id = $objteatro->get_Idteatro();
    echo $objteatro;
}
/////////////////////////////////////////////
/////////////////////////////////////////////
function listaTeatros(){
    $teatro=new Teatro();
    $teatros =$teatro->listar();
    $lista="";
    foreach ($teatros as $teatro){
        $lista.=$teatro."\n";
    }
    echo 
    "\nSELECCIONE TEATRO.\n".$lista."
    Ingrese ID del Teatro : ";
    $id=trim(fgets(STDIN));
    $teatro->Buscar($id);
    return $teatro;
}
///////////////////////////////////////////////
//////////////////////////////////////////////

function listaTeatrosModificar(){
    $teatro=new Teatro();
    $teatros =$teatro->listar();
    $lista="";
    foreach ($teatros as $teatro){
        $lista.=$teatro."\n";
    }
    echo 
    "\nSELECCIONE TEATRO.\n".$lista."
    Ingrese ID del Teatro : ";
    $id=trim(fgets(STDIN));
    $teatro->Buscar($id);
    return $teatro;
}

function seleccionarFuncionesModificar($objteatro){
    $id = $objteatro->get_Idteatro();
    $funcine=new Funcion_Cine();
    $funmusical=new Funcion_Musicales();
    $funteatro=new Funcion_Teatro();
    $funcines = $funcine->listar("idteatro=".$id); 
    $funmusicales = $funmusical->listar("idteatro=".$id);
    $funteatros = $funteatro->listar("idteatro=".$id);
    $colFunciones = array_merge($funteatros,$funcines,$funmusicales);
    $lista="";
    foreach ($colFunciones as $fun){
        $lista.=$fun."\n";
    }
    echo 
    "\nSELECCIONE FUNCION.".$lista."
    Ingrese ID de la Funcion: ";
    $id=trim(fgets(STDIN));
    return $id;
}

do{
    echo 
    "\n--------------------------------------\n
    BASE DE DATOS TEATRO

    1) Crear TEATRO?
    2) Modificar
    3) Eliminar
    4) Menu de Funciones
    5) Listar Funciones
                                                    
    6) Salir
    \n--------------------------------------\n
    Ingrese una opcion: ";
    $inicioMenu=trim(fgets(STDIN));
    while(!ctype_digit($inicioMenu)){
        echo "error ingrese numeros: ";
        $inicioMenu=trim(fgets(STDIN));
    }

    //crear teatro
    if($inicioMenu==1){
    echo "Ingrese Nombre de Teatro: ";
    $nombre=trim(fgets(STDIN));
    echo "ingrese Direccion de Teatro: ";
    $direccion=trim(fgets(STDIN));
    $teatro=new Teatro();
    $teatro->cargar(null,$nombre,$direccion);
    echo $teatro->insertar()?"Teatro creado con exito\n": "no se pudo crear el teatro\n";
    }

    //modificar teatro
    if($inicioMenu==2){
        $objteatro=listaTeatros();
        $id = $objteatro->get_Idteatro();
        echo "ingrese nombre nuevo: ";
        $nombre=trim(fgets(STDIN));
        echo "ingrese nueva direccion: ";
        $direccion=trim(fgets(STDIN));
        $objteatro->set_Nombre($nombre);
        $objteatro->set_direccion($direccion);
        $objteatro->set_Idteatro($id);
        echo $objteatro->modificar()? "Actualizacion realizada con exito\n": "no se pudo actualizar datos\n";
    }
    
    //Eliminar Teatro
    if($inicioMenu==3){
        $objteatro=listaTeatros();
        $id = $objteatro->get_Idteatro();
        $objteatro->set_Idteatro($id);
        echo $objteatro->eliminar()?"Teatro eliminado con exito":"No se pudo eliminar Teatro";
    }

    //Listar funciones
    if($inicioMenu==5){
        $verFunciones = listaFunciones();
        echo $verFunciones;
    }
}while($inicioMenu!=4 &&$inicioMenu!=6);
    
if($inicioMenu!=6){
    do{
        echo 
        "\n--------------------------------------\n
        1) Agregar Funcion
        2) Cambiar los datos de las Obras
        3) Cambiar los datos delos cines
        4) Cambiar los datos de los musicales
        5) Eliminar Funcion
        6) Dar COSTO TOTAL DE FUNCIONES
        7) SALIR
        \n--------------------------------------\n
        Ingrese una opcion: ";
        $opcion=trim(fgets(STDIN));
        while ($opcion<1||$opcion>7){
            echo "Ingrese una opcion valida: ";
            $opcion=trim(fgets(STDIN));
        }

        switch ($opcion){
            case 1:
                do{
                    echo crearFuncion()? "\nfuncion creada con exito\n":"\nno se pudo crear la funcion\n";
                    echo "ingresar otra Funcion?: S o cualquier letra para salir: ";
                    $seguir=strtolower(trim(fgets(STDIN)));
                    
                }while($seguir=="s");
            break;
            case 2:
                // modificar obra
                $teatro = new Teatro();
                $objteatro = listaTeatrosModificar();
                $idFuncion = seleccionarFuncionesModificar($objteatro);
                //$id=seleccionarFunciones();
                echo "ingrese el Nuevo Nombre: ";
                $nombreNuevo=trim(fgets(STDIN));
                echo "ingrese hora de inicio: ";
                $h=trim(fgets(STDIN));
                while(!($h<=23&&$h>=0&&ctype_digit($h))){
                    echo "error ingrese una hora entre 0 y 23: ";
                    $h=trim(fgets(STDIN));
                }
                echo "ingrese minutos de inicio: ";
                $m=trim(fgets(STDIN));
                while(!($m<=59&&$m>=0&&ctype_digit($m))){
                    echo "error ingrese minutos en el rango de 0 a 59: ";
                    $m=trim(fgets(STDIN));
                }
                $horario=$h.":".$m;
                echo "ingreses duracion de la funcion: ";
                $duracion=trim(fgets(STDIN));
                while(!ctype_digit($duracion)){
                    echo "error ingrese numeros: ";
                    $duracion=trim(fgets(STDIN));
                }
                echo "ingrese precio de la funcion: ";
                $precio=trim(fgets(STDIN));
                while(!ctype_digit($precio)){
                    echo "error ingrese numeros: ";
                    $precio=trim(fgets(STDIN));
                }
                echo $teatro->modificarFuncionTeatro($nombreNuevo,$horario,$duracion,$precio,$objteatro,$idFuncion)? "\nSe cambio":"\nNo se cambio";
            break;
            case 3:
                //modificar cine
                $teatro=new Teatro();
                $objteatro = listaTeatrosModificar();
                $idFuncion = seleccionarFuncionesModificar($objteatro);
                //$id=seleccionarFunciones();
                echo "ingrese el Nuevo Nombre: ";
                $nombreNuevo=trim(fgets(STDIN));
                echo "ingrese hora de inicio: ";
                $h=trim(fgets(STDIN));
                while(!($h<=23&&$h>=0&&ctype_digit($h))){
                    echo "error ingrese una hora entre 0 y 23: ";
                    $h=trim(fgets(STDIN));
                }
                echo "ingrese minutos de inicio: ";
                $m=trim(fgets(STDIN));
                while(!($m<=59&&$m>=0&&ctype_digit($m))){
                    echo "error ingrese minutos en el rango de 0 a 59: ";
                    $m=trim(fgets(STDIN));
                }
                $horario=$h.":".$m;
                echo "ingreses duracion de la funcion: ";
                $duracion=trim(fgets(STDIN));
                while(!ctype_digit($duracion)){
                    echo "error ingrese numeros: ";
                    $duracion=trim(fgets(STDIN));
                }
                echo "ingrese precio de la funcion: ";
                $precio=trim(fgets(STDIN));
                while(!ctype_digit($precio)){
                    echo "error ingrese numeros: ";
                    $precio=trim(fgets(STDIN));
                }
                echo "ingrese Genero de Pelicula: ";
                $genero=trim(fgets(STDIN));
                echo "ingrese Pais de Origen: ";
                $pais=trim(fgets(STDIN));
                echo $teatro->modificarFuncionCine($nombreNuevo,$horario,$duracion,$precio,$objteatro,$genero,$pais,$idFuncion)? "\nSe cambio":"\nNo se cambio";
            break;
            case 4:
                //modificar musical
                $teatro=new Teatro();
                $objteatro = listaTeatrosModificar();
                $idFuncion = seleccionarFuncionesModificar($objteatro);
                //$id=seleccionarFunciones();
                echo "ingrese el Nuevo Nombre: ";
                $nombreNuevo=trim(fgets(STDIN));
                echo "ingrese hora de inicio: ";
                $h=trim(fgets(STDIN));
                while(!($h<=23&&$h>=0&&ctype_digit($h))){
                    echo "error ingrese una hora entre 0 y 23: ";
                    $h=trim(fgets(STDIN));
                }
                echo "ingrese minutos de inicio: ";
                $m=trim(fgets(STDIN));
                while(!($m<=59&&$m>=0&&ctype_digit($m))){
                    echo "error ingrese minutos en el rango de 0 a 59: ";
                    $m=trim(fgets(STDIN));
                }
                $horario=$h.":".$m;
                echo "ingreses duracion de la funcion: ";
                $duracion=trim(fgets(STDIN));
                while(!ctype_digit($duracion)){
                    echo "error ingrese numeros: ";
                    $duracion=trim(fgets(STDIN));
                }
                echo "ingrese precio de la funcion: ";
                $precio=trim(fgets(STDIN));
                while(!ctype_digit($precio)){
                    echo "error ingrese numeros: ";
                    $precio=trim(fgets(STDIN));
                }
                echo "Ingrese Nombre de director del Musical: ";
                $director=trim(fgets(STDIN));
                echo "ingrese cantidad de personas en escena: ";
                $cant=trim(fgets(STDIN));
                while(!ctype_digit($cant)){
                    echo "error ingrese numeros: ";
                    $cant=trim(fgets(STDIN));
                }
                echo $teatro->modificarFuncionMusicales($nombreNuevo,$horario,$duracion,$precio,$objteatro,$director,$cant,$idFuncion)? "\nSe cambio":"\nNo se cambio";
            break;
            case 5:
                echo eliminarFuncion()? "Se elimno la funcion seleccionada": "no se elimino";
                break;
            case 6:
                $objteatro=listaTeatros();
                $id = $objteatro->get_Idteatro();
                $costo=$objteatro->calcularCostoFunciones($id);
                echo "\nEl costo total de las funciones del Teatro Seleccionado es de: $ $costo.\n";
            break;
        }
    }while($opcion!=7);
}
?>