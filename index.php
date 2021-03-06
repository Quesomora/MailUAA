﻿<!DOCTYPE html>
<html>
    <head>
        <title>Formulario</title>
        <style type='text/css' rel='stylesheet'>
            body { width:100%; height:100%; margin:0px; font-family:Tahoma; }
            .menu { width:32px; height:32px; padding:8px; }
            form { text-align:center; }
            input[type=submit], input[type=reset] { width:80px; height:25px; border-radius:5px; border:0; }
            .default { background-color:#f0a54a; }
            header { width:auto; height:6%; text-align:right; padding:10px; background-color:#e8e8e8; overflow:hidden; position:absolute; z-index:100; top:0; left:0; right:0; }
            #search { width:300px; height:40px; background:#2b303b; color:#63717f; border:none; font-size:10pt; padding-left:15px; margin-right:25px; }
            #section { width:92.4%; height:90%; text-align:center; position:fixed; left:7%; top:8%; z-index:98; border:1% solid gray; border-radius:1%; overflow:hidden; }
            #nuevo, #visualizar, #recibidos, #enviados, #papelera, #configuracion{ width:100%; height:100%; overflow:auto; display:block; padding:2%; }
            //----------------------------------------------------------------------
            a div { display:flex; text-decoration:none; }
            nav { width:5%; height:auto; top:7%; bottom:0; left:0; position:fixed; transition-duration:0.5s; background-color:#e8e8e8; padding:1%; z-index:99; box-shadow:4px 0 6px -2px black; overflow-x:hidden; }
            nav:hover  { width: 16%; }
            div label{ transform:translateY(75%); position: absolute; color: black; left: -200%; }
            nav:hover a div label{ left: 38%; }
            //---------------------------------------------------------------------
	        tr{ background: #b8d1f3; }
            tr:hover { background-color: #BDBDBD; color:#FFFFFF}
        </style>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $('table tr').click(function(){
                    window.location = $(this).attr('href');
                });
            });
        </script>
<?php
    //mysqli_query($conn, "CREATE TABLE `DATOSUSUARIOS` (name VARCHAR(30), last VARCHAR(30), birth DATETIME, sex CHAR(1), user VARCHAR(26), pass VARCHAR(16))");
    //mysqli_query($conn, "INSERT INTO DATOSUSUARIOS (name, last, sex, user, pass) VALUES ('$users', 'Mundo', 'H', 'Usuario', '****')");
    //$query=mysqli_query($conn,"SELECT * FROM DATOSUSUARIOS");
    //while($row = mysqli_fetch_assoc($query)) {
    //    echo "Nombre: " . $row["names"]. " - Apellido: " . $row["last"]. " - Sexo: " . $row["sex"]. " - Usuario: " . $row["user"]. " - Password: " . $row["pass"]. "<br>";
    //}
    //mysqli_query($conn,"DELETE FROM `DATOSUSUARIOS`");
    //mysqli_query($conn, "DROP TABLE DATOSUSUARIOS");
    //echo "Error: " . mysqli_error($conn);
    //mysqli_close($conn);

    header('Content-Type: text/html; charset=ISO-8859-1');
    $db_host="us-cdbr-azure-southcentral-e.cloudapp.net";
    $db_user="b4ddc5a8a06088";
    $db_pass="ce243693";
    $db_name="acsm_fd504d999e3283b";
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    

    /*$query =  mysqli_query($conn, "SHOW TABLES");
    while ($row = mysqli_fetch_row($query)){ echo "<br>{$row[0]}"; 
        $resp = mysqli_query($conn, "SELECT * FROM {$row[0]}");
        while($fila = mysqli_fetch_assoc($resp)){ echo "<br>inf: ".$fila['inf']." ind: ".$fila['ind']." ins: ".$fila['ins']." int: ".$fila['int']." inm: ".$fila['inm']." outf: {$fila['outf']} outd: {$fila['outd']} outs: {$fila['outs']} outt: {$fila['outt']} outm: {$fila['outm']} delf: {$fila['delf']} deld: {$fila['deld']} dels: {$fila['dels']} delt: {$fila['delt']} delm: {$fila['delm']}";}
    }
    
    $query=mysqli_query($conn,"SELECT * FROM `datosusuarios`");
    while($row = mysqli_fetch_assoc($query)) {
        echo "<br>Nombre: {$row["name"]} - Apellido: {$row["last"]} - Sexo: {$row["sex"]} - Usuario: {$row["user"]} - Password: {$row["pass"]}";
    }*/
    if(isset($_POST["register"])){
        if(mysqli_num_rows(mysqli_query($conn, "SELECT `user` FROM `datosusuarios` WHERE user='{$_POST['user']}'"))>0){ $err="El usuario ya existe"; }
        elseif(!preg_match("/^[a-zA-Z]*$/",$_POST["user"])){ $err="Tu usuario no puede contener espacios"; }
        elseif(!preg_match("/^[a-zA-Z ]*$/",$_POST["name"]) || !preg_match("/^[a-zA-Z ]*$/",$_POST["last"])){ $err="Tanto tu nombre como tu apellido no pueden contener carácteres especiales"; }
        elseif($_POST["user"]=="" || $_POST["pass"]=="" || $_POST["name"]=="" || $_POST["last"]==""){ $err="Te faltan campos por completar"; }
        elseif($_POST["pass"]!=$_POST["pass2"]){ $err="Las contraseñas no coinciden"; }
        else{
            mysqli_query($conn, "INSERT INTO `datosusuarios` (`name`, `last`, `sex`, `user`, `pass`) VALUES ('{$_POST['name']}', '{$_POST['last']}', '{$_POST['sex']}', '{$_POST['user']}', '{$_POST['pass']}')");
            mysqli_query($conn, "CREATE TABLE {$_POST["user"]} (`inf` VARCHAR(40), `ind` VARCHAR(19), `ins` VARCHAR(60), `int` TINYTEXT, `inm` TEXT, `outf` VARCHAR(40), `outd` VARCHAR(19), `outs` VARCHAR(60), `outt` TINYTEXT, `outm` TEXT, `delf` VARCHAR(40), `deld` VARCHAR(19), `dels` VARCHAR(60), `delt` TINYTEXT, `delm` TEXT)");
            $err="";
        }
    }
    if(isset($_POST["update"])){
        if(mysqli_num_rows(mysqli_query($conn, "SELECT `user` FROM `datosusuarios` WHERE user='{$_POST['user']}'"))>0){ $err="El usuario ya existe"; }
        elseif(!preg_match("/^[a-zA-Z]*$/",$_POST["user"])){ $err="Tu usuario no puede contener espacios"; }
        elseif(!preg_match("/^[a-zA-Z ]*$/",$_POST["name"]) || !preg_match("/^[a-zA-Z ]*$/",$_POST["last"])){ $err="Tanto tu nombre como tu apellido no pueden contener carácteres especiales"; }
        elseif($_POST["user"]=="" || $_POST["pass"]=="" || $_POST["name"]=="" || $_POST["last"]==""){ $err="Te faltan campos por completar"; }
        elseif($_POST["pass"]!=$_POST["pass2"]){ $err="Las contraseñas no coinciden"; }
        else{
            mysqli_query($conn, "UPDATE `datosusuarios` SET name='{$_POST['name']}', last='{$_POST['last']}', pass='{$_POST['pass']}' WHERE user='{$_POST['user']}'");
            $err="";
        }
    }
    if(isset($_POST["trash"])){
        /*$row=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM {$_POST['user']} WHERE ind={$_GET['ind']} OR outd={$_GET['outd']}"));
        mysqli_query($conn, "UPDATE `{$_POST['user']}` SET delf='{$row['inf']}', deld='{$row['ind']}', dels='{$row['ins']}', delt='{$row['int']}', delm='{$row['inm']}' WHERE ind='{$_GET['ind']}'");
        mysqli_query($conn, "UPDATE `{$_POST['user']}` SET delf='{$row['outf']}', deld='{$row['outd']}', dels='{$row['outs']}', delt='{$row['outt']}', delm='{$row['outm']}' WHERE outd='{$_GET['outd']}'");
        mysqli_query($conn, "UPDATE `{$_POST['user']}` SET inf='', ind='', ins='', int='', inm='' WHERE ind='{$_GET['ind']}'");
        mysqli_query($conn, "UPDATE `{$_POST['user']}` SET outf='', outd='', outs='', outt='', outm='' WHERE outd='{$_GET['out']}'");*/
    }
    if(isset($_POST["delete"])){
        mysqli_query($conn, "DROP TABLE {$_POST['user']}");
        mysqli_query($conn, "DELETE FROM `datosusuarios` WHERE user='{$_POST['user']}'");
        unset($_POST);
        $_POST = array();
    }
    if(isset($_GET["user"])){
        $_POST["user"]=$_GET["user"];
    }
    if(isset($_POST["send"])){
        $date=date('Y-m-d H:i:s');
        mysqli_query($conn, "INSERT INTO `{$_POST['user']}` (`outf`, `outd`, `outs`, `outt`, `outm`) VALUES ('{$_POST['user']}', '$date', '{$_POST['subject']}', '{$_POST['to']}', '{$_POST['message']}')");
        mysqli_query($conn, "INSERT INTO `{$_POST['to']}` (`inf`, `ind`, `ins`, `int`, `inm`) VALUES ('{$_POST['user']}', '$date', '{$_POST['subject']}', '{$_POST['to']}', '{$_POST['message']}')");
    }
    /*if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `datosusuarios` WHERE user='{$_POST['user']}' AND pass='{$_POST['pass']}'"))==0){
        $_POST = array();
    }*/
?>
    </head>
    <body><!--------------------------------------BODY------------------------------------------>
<?php   if(isset($_POST["signin"]) || $err!=""){ ?>
        <div text-align="left"><br><br><br><br><h1 align="center">Registro</h1><br><br>
            <form method="post">
                Nombre(s): <input type="text" name="name"><br>
                Apellido(s): <input type="text" name="last"><br>
                    Fecha de nacimiento: <input type="date" name="birth" min="1940-01-01" max="2002-12-31"><br>
                Sexo:   <input type="radio" name="sex" value="H" checked> Hombre
                        <input type="radio" name="sex" value="M"> Mujer<br><br>
                Usuario: <input type="text" name="user"><br>
                Contraseña: <input type="password" name="pass"><br>
                Confirmar contraseña: <input type="password" name="pass2"><br>
                <p style="color:red"><?php echo $err; ?></p>
                <input type="submit" name="cancel" value="Cancelar" onclick="location.href=".">
                <input type="submit" name="register" value="Aceptar" id="ingresar" class="default"> <!--REGISTER-->
            </form>
        </div>

<?php   }elseif(mysqli_num_rows(mysqli_query($conn, "SELECT `user` FROM `datosusuarios` WHERE user='{$_POST['user']}' AND pass='{$_POST['pass']}'"))>0 || $_REQUEST["user"]!=""){ ?>
        <header><img src='https://siuaaxt.uaa.mx/siima/IMW_Mdi/recursos/imgs/login/logo.png' width='100px' height='40px' align='left'>
            <input type="search" id="search" placeholder="Buscar..." />
            Bienvenido(a) <b> <?php echo $_POST["user"]; ?>   </b>
            <a href='#personalitation'><img src='<?php echo $_POST["sex"]=="H"?"http://cdn.flaticon.com/png/256/17797.png" : "http://cdn.flaticon.com/png/256/18014.png" ?>' width='40px' height='40px' align='right'/></a>
        </header>

        <nav><img src='https://www.dittomusic.com/img/menuv1.png' class='menu' id="menu"/><hr>
            <a href='#nuevo'><div><img src='http://cdn.flaticon.com/png/256/8820.png' class='menu'/><label>Nuevo</label></div></a>
            <a href='#recibidos'><div><img src='http://cdn.flaticon.com/png/512/34164.png' class='menu'/><label>Recibidos</label></div></a>
            <a href='#enviados'><div><img src='http://cdn.flaticon.com/png/256/33941.png' class='menu'/><label>Enviados</label></div></a>
            <a href='#papelera'><div><img src='http://plainicon.com/dboard/userprod/2805_fce53/prod_thumb/plainicon.com-48711-128px-559.png' class='menu'/><label>Papelera</label></div></a>
            <a href='#configuracion'><div><img src='http://cdn.flaticon.com/png/256/60473.png' class='menu'/><label>Configuracion</label></div></a>
            <a href='.' onclick="window.location.reload(true);"><div><img src='http://cdn.flaticon.com/png/256/25706.png' class='menu'/><label>Salir</label></div></a>
        </nav>

        <div id="section">
            <div id="recibidos"><h2>Recibidos</h2><hr>
                <table width="95%" height="auto">
                    <tr style=" background:#2b303b; color:white">
                        <td><b> Remitente </b></td>
                        <td><b> Asunto </b></td>
                        <td><b> Fecha </b></td>
                    </tr>
<?php               $query=mysqli_query($conn, "SELECT `inf`, `ind`, `ins` FROM `{$_POST['user']}` WHERE NOT ind=''");
                    while($row = mysqli_fetch_assoc($query)) { echo "<tr href='?user={$_POST['user']}&ind={$row['ind']}#visualizar'><td>{$row['inf']}</td><td>{$row['ins']}</td><td>{$row['ind']}</td></tr>"; }
?>
		        </table>
		    </div>

            <div id="visualizar"><h2></h2><hr><div align="left">
                <form method="post">
                    <!-- <input type="hidden" name="" value="
<?php /*echo $_POST["user"]; */?>
                    <!--"> 
                    <input type="submit" name="trash" value="Eliminar">
                    <input type="submit" name="reenv" value="Reenviar">
                    <input type="submit" name="resp" value="Responder"> -->
                </form>
<?php           $row=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `{$_POST["user"]}` WHERE ind='{$_GET['ind']}'")); 
                echo "<br><b>De: </b>".$row['inf']."<br><b>Fecha: </b>".$row['ind']."<br><b>Asunto: </b>".$row['ins']."<br><b>Para: </b>".$row['int']."<br><b>Mensaje: </b>".$row['inm'];
?>
                </div>
            </div>

            <div id="nuevo"><h2>Enviar a:</h2><hr>
                <form method="post">
                    Para:<br><input type="text" name="to" style="width:90%;"><br>
                    Asunto:<br><input type="text" name="subject" style="width:90%;"><br><br>
                    Mensaje:<br><textarea name="message" rows=12 style="width:90%;"></textarea><br><br>
                    <input type="hidden" name="user" value="<?php echo $_POST["user"]; ?>">
                    <input type="reset" value="Limpiar">
                    <input type="submit" value="Enviar" class="default" name="send"><br><br><br><br>
                </form>
            </div>

            <div id="enviados"><h2>Enviados</h2><hr>
                <table width="95%" height="auto"> <!-- CODIGO EN PHP -->
                    <tr style=" background:#2b303b; color:white">
                        <td><b> Destinatario </b></td>
                        <td><b> Asunto </b></td>
                        <td><b> Fecha </b></td>
                    </tr>
<?php       $query=mysqli_query($conn,"SELECT `outd`, `outs`, `outt` FROM `{$_POST['user']}` WHERE NOT outd=''");
            while($row = mysqli_fetch_assoc($query)) { echo"<tr href='?user={$_POST['user']}&outd={$row['outd']}#visualizar'><td>{$row['outt']}</td><td>{$row['outs']}</td><td>{$row['outd']}</td></tr>"; }
?>
		    	</table>
		    </div>

		    <div id="papelera"><h2>Papelera</h2><hr>
		        <table width="95%" height="auto"> <!-- CODIGO EN PHP -->
		    	    <tr style=" background:#2b303b; color:white">
		    		    <td><b> Remitente </b></td>
		    		    <td><b> Asunto </b></td>
		    		    <td><b> Destinatario </b></td>
		    		    <td><b> Fecha </b></td>
		    		</tr>
<?php       $query=mysqli_query($conn,"SELECT `delf`, `deld`, `dels`, `delt` FROM `{$_POST['user']}` WHERE NOT deld=''");
            while($row = mysqli_fetch_assoc($query)) { echo"<tr><td>".$row["delf"]."</td><td>".$row["dels"]."</td><td>".$row["delt"]."</td><td>".$row["deld"]."</td></tr>"; }
?>
		    	</table>
		    </div>
            
<?php       $row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `datosusuarios` WHERE user='{$_POST['user']}'")); ?>
		    <div id="configuracion"><h2>Cambiar información personal</h2><hr>
                <form method="post">
                    Nombre(s): <input type="text" name="name" value="<?php echo $row["name"]; ?>"><br>
                    Apellido(s): <input type="text" name="last" value="<?php echo $row["last"]; ?>"><br>
                    Fecha de nacimiento: <input type="date" name="birth" min="1940-01-01" max="2002-12-31"><br>
                    Contraseña: <input type="password" name="pass"><br>
                    Confirmar contraseña: <input type="password" name="pass2"><br>
                    <p style="color:red"><?php echo $err; ?></p>
                    <input type="submit" name="cancel" value="Cancelar" onclick="location.href='.'">
                    <input type="submit" name="update" value="Aceptar" id="ingresar" class="default"> <!--REGISTER-->
                </form>
                <br><br><h2>Otros recursos</h2><hr>
                <form method="post">
                    <input type="hidden" name="user" value="<?php echo $_POST["user"]; ?>">
                    Eliminar cuenta: <input type="submit" value="Aceptar" name="delete" onclick="location.href='.'""><br>
                </form>
		    </div>
        </div>

<?php   }else{/*---------------------------------PANTALLA DE INICIO--------------------------------------*/ ?>
            <div id="home" align="center" style="top:50%; position:relative; transform: translateY(75%);">
                <img src="https://siuaaxt.uaa.mx/siima/IMW_Mdi/recursos/imgs/login/logo.png"><br><br>
                <form method="post">
                    Usuario:       <input type="text" name="user" maxlength=26> <br><br>
                    Contraseña:      <input type="password" name="pass"maxlength=16 ><br><br>
                    <input type="submit" name="signin" value="Registrar">
                    <input type="submit" name="login" value="Ingresar" class="default">
                </form>
            </div>

<?php   }mysqli_close($conn); ?>
    </body>
</html>