<?php 
/* -- Codigo para generar formulario dinamico de BD con PHP   */ 

//$base= $_GET['bd'];         /* lectura de datos via GET/queryString/URL  */
//$tabla= $_GET['tabla'];     /*   http://localhost/directorio/generaFormulario.php?bd=cpremier&tabla=asignacion   */

/*if (!isset($tabla))
   {echo "<h3>IMPORTANTE:  Se espera recibir 2 parametros via GET. Uno es la 'bd' y otro es la 'tabla'...</h3>";
    die();
};	*/

if (isset($_POST['base'])) {
    $base = $_POST['base'];
    
} else {
    $base = "cpremier";
}
if(isset($_POST['tabla'])){
    $tabla = $_POST['tabla'];
}else {$tabla = null;}
if(isset($_POST['motor'])){
    $motor = $_POST['motor'];

}else{
    $motor = "mysql";
}
?> 


<html>
<head>
<title>Formulario Dinamico de</title>
</head>
<body>

<?php   
    //############ seleccionar motor   
    echo "<h3>Motores de bases de datos: </h3>";
    echo "<form action= Update.php + method='POST'>";
    echo "<select name = 'motor'>";
    echo "<option value = 'mysql'";
    if($motor === "mysql"){
        echo " selected";
    }
    echo ">MYSQL</option>";
    echo "<option value = 'posgres'";
    if($motor === "posgres"){
        echo " selected";
    }
    echo ">POSTGRES</option>";
    echo "</select>";
   //############ seleccionar base de datos y tabla
   echo "<h3>\n Base de datos: </h3>";
    $sql_bd = "SELECT SCHEMA_NAME FROM schemata ;";
    
    $conexion_info = mysqli_connect("127.0.0.1:3307",'root','','information_schema');  /* conexion a BD  */
    if(!$result_inf = mysqli_query($conexion_info, $sql_bd)) {    /* ejecucion del query  */
        echo "<h5>error en SQL, no regreso resultados!</h3>";
        die();
      }
      $rawdata_inf = array();   
      $i_inf=0;
      /* recuperacion fila x fila del resulset */
   while($row_inf = mysqli_fetch_array($result_inf))  
   {   $rawdata_inf[$i_inf] = $row_inf;  /* almacen en vector de cada registro  */
       $i_inf++;
   }
   
   $fila_inf = count($rawdata_inf);
   echo "<select name='base'>";
   for($i_inf = 0;$i_inf<$fila_inf;$i_inf++){
   echo "<option value ='".$rawdata_inf[$i_inf][0]."'";
   if($rawdata_inf[$i_inf][0]===$base){echo " selected>";}else{echo "><h4>";}
    echo $rawdata_inf[$i_inf][0]."</option>";
    }   
    echo "</select>";
    ///echo "<input type=submit value=Usar>";
    //echo "</form>";
   
    $close_info = mysqli_close($conexion_info);  /* cierre de conexion a mySQL  */

    //// tablas %%%%%%%%%%%%%
    echo "<h3>\n Tablas: </h3>";
	//echo "<form action= generaFormulario.php + method='POST'>";
	
    $sql_bd = "SELECT table_name FROM tables where table_schema ='{$base}';";
    $conexion_info = mysqli_connect("127.0.0.1:3307",'root','','information_schema'); 
    if(!$result_inf = mysqli_query($conexion_info, $sql_bd)) {    
        echo "<h5>error en SQL, no regreso resultados!</h3>";
        die();
      }
      $rawdata_inf = array();   
      $i_inf=0;
 
   while($row_inf = mysqli_fetch_array($result_inf))  
   {   $rawdata_inf[$i_inf] = $row_inf; 
       $i_inf++;
   }
   
   $fila_inf = count($rawdata_inf);
   echo "<select name='tabla'>";
   for($i_inf = 0;$i_inf<$fila_inf;$i_inf++){
   echo "<option  value ='".$rawdata_inf[$i_inf][0]."'";
   if($rawdata_inf[$i_inf][0]===$tabla){echo " selected>";}else{echo ">";}
    echo $rawdata_inf[$i_inf][0]."</option>";
    }   
    echo "</select>";
    echo "<br><br> <input type=submit value=Usar>";
    echo "</form>";
   
    $close_info = mysqli_close($conexion_info);
    
    ///##########


   ///  ejemplo de SQL para extraer los metadatos de los campos de una tabla especifica  
   $sql="SELECT column_name,data_type,is_nullable,character_maximum_length,column_key 
         FROM   information_schema.columns 
         WHERE  Table_schema='".$base."' AND table_name='".$tabla."';";
		 
 
   
   $conexion = mysqli_connect("127.0.0.1:3307",'root','',$base);  /// conexion a BD  

   if(!$result = mysqli_query($conexion, $sql)) {    /// ejecucion del query  
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

   
  
   
   /// ********** parte de generacion del formulario dinamico  *************************   
   
   echo "<h3>Formulario de captura - ".$tabla."</h3>\n";
   echo "<FORM name='formulario' action='grabaupdate.php' method='POST'>\n";
   echo "<table id='form1' border='0' style='border-style:none'>\n";
   

////semamo el profe

   /// por cada campo se genera una etiqeuta y textBox, ademas de un campo oculto para heredar el dataType  
   for($i=0;$i<$filas;$i++){
       echo "<tr><td align='right'>".$rawdata[$i][0].":</td>";
       echo "<td><input type = '";
       if(strval($rawdata[$i][1]) === "int"){ echo 'number';
    }elseif (strval($rawdata[$i][1]) === "date") {echo 'date';
    }else {echo 'text';}
       echo "' name='campo_".$rawdata[$i][0]."' value=''  maxlength = '";
       if($rawdata[$i][3] != null){echo $rawdata[$i][3];}
       echo "' size='10'/>\n";
	   echo "  <input type='hidden' name='TipoDato_Campo".($i+1)."' value='".$rawdata[$i][1]."'/></td>";
       echo "</tr>\n";
   }
 


   ///algunos campos ocultos para enviar datos via POST 
   echo "<tr><td/><td><input type='hidden' name='bd' value='".$base."'/></td></tr>\n";  
   echo "<tr><td/><td><input type='hidden' name='tabla' value='".$tabla."'/></td></tr>\n";
   echo "<tr><td/><td><input type='hidden' name='num_campos' value='".$filas."'/></td></tr>\n";
   echo "<tr><td/><td><input type='submit' name='botonUpdate' value='Actualizar registro'/></td></tr>\n";   ///boton del form
   echo "</table></FORM><HR/>\n";   /// cierre de tabla y del formulario 
   
   echo "<br/><a href='##' onClick='history.go(-1); return false;'>Regresar</a>";
    $close = mysqli_close($conexion);  /// cierre de conexion a mySQL  

    
?> 
 </body>
</html>



<!--   
Ejemplos de Sentencias para extraer de INFORMATION_SCHEMA la informacion sobre las Claves Primarias y Foraneas de 
cada tabla de una cierta BD seleccionada en MySQLServer


para las PKs

SELECT TC.TABLE_SCHEMA as BD, TC.Table_name as TablaBASE, TC.constraint_name as CName,  
       TC.CONSTRAINT_TYPE as TipoC, 
	   KC.COLUMN_NAME as CampoBASE, 
       NULL as TablaREF, NULL as CampoREF  
FROM information_schema.table_constraints as TC INNER JOIN 
     information_schema.KEY_COLUMN_USAGE as KC
       ON (KC.TABLE_SCHEMA=TC.TABLE_SCHEMA  
	       AND TC.constraint_name=KC.constraint_name 
		   AND KC.Table_name=TC.Table_name)
WHERE TC.TABLE_SCHEMA='cpremier' AND TC.CONSTRAINT_NAME='PRIMARY';


para los FKs

SELECT RC.CONSTRAINT_SCHEMA as BD, RC.Table_Name as TablaBASE, RC.constraint_name as CName,
       'FOREIGN KEY' as TipoC,
	   KC.COLUMN_NAME as CampoBASE,  
       KC.REFERENCED_TABLE_NAME as TablaREF, 
	   KC.REFERENCED_COLUMN_NAME as CampoREF
FROM information_schema.REFERENTIAL_CONSTRAINTS as RC INNER JOIN  
     information_schema.KEY_COLUMN_USAGE as KC
      ON (KC.TABLE_SCHEMA=RC.CONSTRAINT_SCHEMA 
          AND RC.Table_Name=KC.TABLE_NAME 
          AND RC.constraint_name=KC.constraint_name )
WHERE RC.CONSTRAINT_SCHEMA='cpremier' AND KC.CONSTRAINT_NAME<>'PRIMARY';

->



