<div class = "login">
    <td>    
        Motores de Bases de Datos
    </td>
    
    <?php
        $bs = null;
        $b2 = null;
    ?>

    <form action= "index.php" method="post">
    <div class="regis">
        <input type="checkbox" class="log" id="login" name="mysql" <?php if(isset($_POST['mysql'])){echo "checked";}?> value = "1">
        <label for ="mysql">MySQL</label>
        <?php 
        if (isset($_POST['mysql'])) {
            if($_POST['mysql'] === "1"){
                $bs = 1;
                echo "<p>Puerto: </p><input type='text' name = 'puerto1'>
                <p>Usuario: </p><input type='text' name = 'usu1'>
                <p>Contraseña: </p><input type='text' name = 'con1'>
            ";
            }else{$bs=0;}
           
        }
        ?>
    </div>


    <div class="regis">
        <input type="checkbox" class="log" id="login" name="posgres" <?php if(isset($_POST['posgres'])){echo "checked";}?> value="1">
        <label  for="posgres">Posgres</label>

        <?php 
        ///rel="active" 
        if (isset($_POST['posgres'])) {
            if($_POST['posgres'] === "1"){
                $b2=1;
                echo "<p>Puerto: </p><input type='text' name = 'puerto2'>
                <p>Usuario: </p><input type='text' name = 'usu2'>
                <p>Contraseña: </p><input type='text' name = 'con2'>
            ";
            }else{$b2=0;}
           
        }
        ?>
    </div>

    <input type="submit" class="but" name="sendForm" value="Enviar"/>


    </form>
</div>