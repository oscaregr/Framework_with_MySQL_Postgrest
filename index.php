<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
        <?php 
            
            $arr = false;
            $a = false;
            
            
                   
                    $My = isset($_POST['mysql']) ? $_POST['mysql']: '';
                    $Po = isset($_POST['posgres']) ? $_POST['posgres']: '';
                    
                    if($My === "1" && $Po ==="1" ){
                    if(isset($_POST['puerto1']) && isset($_POST['usu1'])){
                        if(isset($_POST['puerto2']) && isset($_POST['usu2']) && isset($_POST['con2'])){
                            $p2 = $_POST['puerto2']; $u2 = $_POST['usu2']; $c2 = $_POST['con2'];
                            $conn_string = "host=127.0.0.1 port={$p2} dbname=Cpremier user={$u2} password={$c2}"; 
                            $result = pg_connect($conn_string);;  /// conexion a BD  
                        
                            if($result){
                                $arr=true;
                            }
                            
                        }
                        $p1 = $_POST['puerto1']; $u1 = $_POST['usu1']; $c1 = $_POST['con1'];
                        $conexion = mysqli_connect("127.0.0.1:{$p1}",$u1,'','');  /// conexion a BD  
                        $result2 = mysqli_query($conexion,'use cpremier;');
                        if($result2 && $result){
                            $arr=true;
                            /*$_COOKIE['p1']=$p1;
                            $_COOKIE['u1']=$u1;
                            $_COOKIE['p2']=$p2;
                            $_COOKIE['u2']=$u2;
                            $_COOKIE['c2']=$c2;
                            $_COOKIE['My']=$My;
                            $_COOKIE['Po']=$Po;*/

                           
                            setcookie("p1", $p1, time()+1800, "/", "localhost");
                            setcookie("u1", $u1, time()+1800, "/", "localhost");
                            setcookie("Po", $Po, time()+1800, "/", "localhost");
                            setcookie("p2", $p2, time()+1800, "/", "localhost");
                            setcookie("u2", $u2, time()+1800, "/", "localhost");
                            setcookie("c2", $c2, time()+1800, "/", "localhost");
                            setcookie("My", $My, time()+1800, "/", "localhost");
                           
                        }else{$arr = false;}
                        
                    }
                    ///throw new Exception (' ');
                }else{
                    if($My === "1"){
                        if(isset($_POST['puerto1']) && isset($_POST['usu1'])){
                            $p1 = $_POST['puerto1']; $u1 = $_POST['usu1'];
                            $conexion = mysqli_connect("127.0.0.1:{$p1}",$u1,'','');  /// conexion a BD  
                            $result2 = mysqli_query($conexion,'use cpremier;');
                            if($result2){
                                $a=true;
                               /* $_COOKIE['My']=$My;
                                $_COOKIE['p1']=$p1;
                                $_COOKIE['u1']=$u1;*/
                                setcookie("My", $My, time()+1800, "/", "localhost");
                                setcookie("p1", $p1, time()+1800, "/", "localhost");
                                setcookie("u1", $u1, time()+1800, "/", "localhost");


                                ////eliminados
                              
                                setcookie("p2", '', time()+1800, "/", "localhost");
                                setcookie("u2", '', time()+1800, "/", "localhost");
                                setcookie("c2", '', time()+1800, "/", "localhost");
                                setcookie("Po", '', time()+1800, "/", "localhost");
                            }else{$a = false;}
                        }
                    }
                    if($Po === "1"){
                        if(isset($_POST['puerto2']) && isset($_POST['usu2']) && isset($_POST['con2'])){
                            $p2 = $_POST['puerto2']; $u2 = $_POST['usu2']; $c2 = $_POST['con2'];
                            $conn_string = "host=127.0.0.1 port={$p2} dbname=Cpremier user={$u2} password={$c2}"; 
                            $conexion = pg_connect($conn_string);
                            if($conexion){
                                $a=true;
                               /* $_COOKIE['Po']=$Po;
                                $_COOKIE['p2']=$p2;
                                $_COOKIE['u2']=$u2;
                                $_COOKIE['c2']=$c2;*/
                                setcookie("Po", $Po, time()+1800, "/", "localhost");
                                setcookie("p2", $p2, time()+1800, "/", "localhost");
                                setcookie("u2", $u2, time()+1800, "/", "localhost");
                                setcookie("c2", $c2, time()+1800, "/", "localhost");

                                ////eliminados
                               
                                setcookie("p1", '', time()+1800, "/", "localhost");
                                setcookie("u1", '', time()+1800, "/", "localhost");
                                setcookie("My", '', time()+1800, "/", "localhost");

                            }else{$a=false;}
                        }
                    }
                }
            
                
            ///if(){}

                if($a || $arr){
                    require("sistema_bd.php");
                }else{
                    echo "<div class = 'login'>";
                    require("login.php");
                    echo "</div>";
                }
                
        ?>
    
</body>
</html>