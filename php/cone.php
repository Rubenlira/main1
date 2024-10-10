<?php
    $host="sql312.byetcluster.com";
    $usuario="if0_37022647";
    $password="0sqvhf7d";
    $bd="if0_37022647_sec_263";
    
    $tablas="posts";
    $tablas1="usuario";
    $tablas2="categoria";
    $tablas3="alumnos";
    $tablas4="citatorios";
    $tablas5="calificaciones";
    function Conectarse()
    {
        global $host, $usuario, $password, $bd;
        if(!($link=mysqli_connect($host, $usuario, $password)))
        {
            echo "Error al conectarse a la Base de datos";
            exit();
        }

        if(!mysqli_select_db($link, $bd))
        {
            echo "Error al seleccionar la Base de Datos";
            exit();
        }
        return $link;
    }
    $link = Conectarse();
?>