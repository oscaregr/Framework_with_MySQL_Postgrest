<?php 
$base= $_POST['bd'];     /*   recuperar cierta info con POST - */ 
$tabla= $_POST['tabla'];
$num_campos = $_POST['num_campos'];
?>
<html>
<head>
<title>Datos de Formulario Dinamico </title>
</head>
<body>

<?php   
   echo "<h3>Datos de Formulario Dinamico de " . $tabla."</h3>";
   $listaCampos[]="";  /*  vector para Nombre campos */
   $listaValores[]="";  /*  vector para valores campos */
   
   $i=0;
   foreach($_POST as $nombre_campo => $valor)   /* barrido a todos los objetos cachados con POST */
   {
      if(strpos($nombre_campo, "campo_") === 0) {   /* de interes solo con prefijo "campo_"  */
			$listaCampos[$i]=substr($nombre_campo,6);   /* obtner nombre del campo*/
			$listaValores[$i]=$valor;
			$i++;
	  }
	  else {
     	  echo "> ". $nombre_campo . "=" . $valor . "<br/>";  /* solo se imprime en pantalla, de aqui se rescataria 
		                                                         a los que tienen prefijo "TipoDato_Campo"  */
	  }
	}
	
	for ($j=0;$j<$i;$j++)   /* para formar la cadena SQL para insertar el registro  */
	{
		if ($j<>0) 
		{
			  $strCampos= $strCampos . "," . $listaCampos[$j];   /* lista de campos, separada por ","   */
			  $strValores=$strValores . ",'" . $listaValores[$j] . "'";  /* lista de valores */
		}
		else {
				$strCampos= $listaCampos[$j];
				$strValores="'" . $listaValores[$j] . "'";
		}
		/// puto profe quiere que se aplique la limitacion por caracteres, que se almacenan
		/// en dicho campo, si pasa marcar error
		 /* aun faltaria procesar la listaValores para que dependiendo del tipodeDato del campo, 
		    se le agregue o no el respectivo Delimitador   */
   }  

    $insertSQL = "INSERT INTO ".$tabla. " (" . $strCampos . ") VALUES (" . $strValores . ");";
	echo "<h3>SQL resultante:</h3>" . $insertSQL;
	
	/* se insertaria el registro, notificando exito o mensaje de error  */

	///$sql_bd = "SELECT SCHEMA_NAME FROM schemata";
    $conexion_info = mysqli_connect("127.0.0.1:3306",'root','',$base);  /* conexion a BD  */
    if(!$result_inf = mysqli_query($conexion_info, $insertSQL)) {    /* ejecucion del query  */
		echo "<h2>Error al introducir los datos, <br>favor de verificar la informacion conforme a los tipos de datos, o <br> pude que el registro ya exista</h2>";
		 ///"<h5>error en SQL, no regreso resultados!</h3>";
        
      }else{
		echo "<h3>La informacion se guardo de manera exitosa</h3>";
	  }


	$rawdata = array();   
	$i=0;
	$insertSQL_2 = "SELECT * FROM ".$tabla.";";
	if(!$result_inf_2 = mysqli_query($conexion_info, $insertSQL_2)) {    /* ejecucion del query  */
		echo "<h2>Error</h2>"; ///"<h5>error en SQL, no regreso resultados!</h3>";
      }else{
		echo "<h3>conectado</h3>";
	  }
	 
   /// recuperacion fila x fila del resulset 
	while($row = mysqli_fetch_array($result_inf_2)){ 
	$rawdata[$i] = $row;  // almacen en vector de cada registro  
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
   $close_info = mysqli_close($conexion_info);

?> 
 </body>
</html>  

