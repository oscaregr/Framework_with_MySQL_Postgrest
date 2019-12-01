<?php
    $base = 'cpremier';
   if(isset($_POST['cons'])){
       $sql = $_POST['cons'];
    $conexion = mysqli_connect("127.0.0.1",'root','',$base);  /// conexion a BD  
    $result = mysqli_query($conexion, $sql);
   }
       
  

?>

<div id="consola1">
    <form action=sistema_bd.php + method='POST'>
    <input type="long-text" value = "" name = "cons" id="con">
    <input type = "submit" id="ejecutar" value = "Ejecutar">
    </form>
</div>
<div id="resultado">
    <?php 
        
        if(!$result) {    /// ejecucion del query  
        echo "<h5>error en SQL, no regreso resultados!</h3>";
        die();
        }
        $rawdata = array();   
        $i=0;

        /// recuperacion fila x fila del resulset 
        while($row = mysqli_fetch_array($result))  
        {   $rawdata[$i] = $row;  // almacen en vector de cada registro  
            $i++;
        }

        $columnas = count($rawdata[0])/2;
        $filas = count($rawdata);
        echo "<h5>Filas: ".$filas.", Columnas: ".$columnas."</h3>";

        echo '<table wbaseh="90%" border="1" style="text-align:center;">';   //// inicio de la tabla  
        echo "<th><b>#</b></th>";   /// primer ciclo para imprimir cabeceras   
        for($i=1;$i<count($rawdata[0]);$i=$i+2){
        next($rawdata[0]);
        echo "<th><b>".key($rawdata[0])."</b></th>";
        next($rawdata[0]);
        }
        for($i=0;$i<$filas;$i++){   /// segundo ciclo para enviar los datos de cada registro 
        echo "<tr><td>".($i+1)."</td>";   /// inicio del renglon 
        for($j=0;$j<$columnas;$j++){
            echo "<td>".$rawdata[$i][$j]."</td>";  /// columna x columna   matriz[fila i,columna j] 
        }
        echo "</tr>\n";   /// fin del renglon  
        }
        echo "</table><HR/>\n\n\n";   ///fin de la tabla 
    ?>  
</div>