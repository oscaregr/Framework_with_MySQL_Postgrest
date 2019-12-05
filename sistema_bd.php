<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel = "stylesheet" href = "di.css">
</head>
<body>
    <div class = "encavesado"></div>
    <div class= "Tree1">

        <form action="sistema_bd.php" method="POST">
           
                <?php 
                     
                    if (isset($_POST['motor'])){
                        $motor = $_POST['motor'];
                        $My = $_POST['m'];
                        $Po = $_POST['p'];
                       
                    }else{$motor='';}
                    $base = isset($_POST['base']) ? $_POST['base'] : '';


                    echo "<select name = 'motor'>";
                    
                    
                    
                    if($My === "1"){
                    echo "<option value = 'mysql'";
                        if($motor === "mysql"){
                            echo " selected";
                        }
                    echo ">MYSQL</option>";}

                    if($Po === "1"){
                    echo "<option value = 'posgres'";
                        if($motor === "posgres"){
                            echo " selected";
                        }
                    echo ">POSTGRES</option>";}
                    echo "</select>";
                    
                    echo "<input type='hidden' name='p' value='{$Po}'>";
                    echo "<input type='hidden' name='m' value='{$My}'>";
                    echo "<input type='submit' value='Usar'>";
                  
               if($motor === "mysql"){
                $base = "cpremier";
               
           echo "<div>
                <ul id='MySQL'>
                  <li><span class='caret'>MySQL</span>
                    <ul class='nested'>
                            <li><span class='caret'>Bases</span>
                                        <ul class='nested'>
                                            <li>Cpremier</li>
                                          
                                    <li><span class='caret'>Tablas</span>
                                        <ul class='nested'>
                                        <li>Asignación</li>
                                        <li>Trabajador</li>
                                        <li>Edificio</li>                       
                                  </ul>
                                </li>
                             </ul>
                            </li>    
                        </ul>
                    </li>
                </ul>
            </div>";
           
                }
            if($motor==="posgres"){
                $base = "Cpremier";
            
            echo "<div>
                        <ul id='Post'>
                                <li><span class='caret'>Posgres</span>
                                  <ul class='nested'>
                                          <li><span class='caret'>Bases</span>
                                                      <ul class='nested'>
                                                          <li>Cpremier</li>
                                                  <li><span class='caret'>Tablas</span>
                                                      <ul class='nested'>
                                                      <li>Asignación</li>
                                                      <li>Trabajador</li>
                                                      <li>Edificio</li>                       
                                                </ul>
                                              </li>
                                           </ul>
                                          </li>    
                                      </ul>
                                  </li>
                              </ul>

                </div>";
                
            }
              
                
                ?>
        
        </form>
                <script>
                    var toggler = document.getElementsByClassName("caret");
                    var i;
                    
                    for (i = 0; i < toggler.length; i++) {
                      toggler[i].addEventListener("click", function() {
                        this.parentElement.querySelector(".nested").classList.toggle("active");
                        this.classList.toggle("caret-down");
                      });
                    }
                </script>
    </div>
    <div class="consola">
        <?php require("consola.php");?>
    </div>
    <div class= "opciones">
    
    <a href="grafico.php"> Insert</a>
    <a href="Update.php"> Update</a>
    <a href="Delete.php"> Delete</a>
    <a href="Select.php"> Select</a>
    </div>
</body>
</html>