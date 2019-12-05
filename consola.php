<?php
    ///$base = 'cpremier';
    ///if($motor= isset($_POST['motor']));
    if($motor === "mysql"){
        if(isset($_POST['cons'])){
            $sql = $_POST['cons'];
            $p1 = $_COOKIE['p1'];
            $u1 = $_COOKIE['u1'];
        
         $conexion = mysqli_connect("127.0.0.1:{$p1}",$u1,'',$base);  /// conexion a BD  
         $result = mysqli_query($conexion, $sql);
         $result = isset($result) ? $result: '';
        }
    }else if($motor === "posgres"){
        if(isset($_POST['cons'])){
            $sql = $_POST['cons'];
            $conn_string = "host=127.0.0.1 port={$_COOKIE['p2']} dbname={$base} user={$_COOKIE['u2']} password={$_COOKIE['c2']}"; 
         $conexion = pg_connect($conn_string);  /// conexion a BD  
         $result = pg_query($conexion, $sql);
         $result = isset($result) ? $result: '';}
    }
    $result = isset($result) ? $result: '';
       
  

?>

<div id="consola1">
    <form action=sistema_bd.php + method='POST'>
    <textarea value = "" name = "cons" id="con" rows ="40" cols="20"></textarea>
  
    <input type ="hidden" name ="motor"  value = <?php echo $motor; ?>>
    <input type="hidden" name = "base"   value = <?php echo $base; ?>>
    <input type ="hidden" name ="m"  value = "<?php echo isset($_POST['m']) ? $_POST['m'] : ''; ?>">
    <input type ="hidden" name ="p"  value = "<?php echo isset($_POST['p']) ? $_POST['p'] : ''; ?>">
    <br>
    <input type = "submit" id="ejecutar" value = "Ejecutar">
    </form>
</div>
<div id="resultado">
    <?php 
        
        if(!$result){    /// ejecucion del query  
        echo "<h5>error en SQL, no regreso resultados!</h3>";
        
        }
        $rawdata = array();   
        $i=0;

        /// recuperacion fila x fila del resulset 
      
        if($motor === "mysql"){
            while($row = mysqli_fetch_array($result))  
                {   $rawdata[$i] = $row;  // almacen en vector de cada registro  
                    $i++;
                }
        }else if ($motor === "posgres"){
            while($row = pg_fetch_array($result))  
                {   $rawdata[$i] = $row;  // almacen en vector de cada registro  
                    $i++;
                }
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