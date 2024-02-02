





<?php  



$servidor="localhost";
           $user="root";
           $password="";
           $db="todolist";
   
           $conexion = new mysqli($servidor,$user,$password,$db);
           if($conexion-> connect_error) {
               die("Conexion Fallida".$conexion -> connect_error);
               }
      

/*Creacion de TABLAS

        $sql ="CREATE TABLE todotable( 
        id INT (11) AUTO_INCREMENT PRIMARY KEY,
        descripcion varchar(100) NOT NULL,
        completado boolean not null,
        timestamp TIMESTAMP
        )";
        if($conexion->query($sql) === true) {
            echo "lA TABLA SE CREO CORRECTAMENTE";
            } else {
                die ("Error al crear LA TABLA".$conexion-> error);
            }
            
      */     

  ?> 
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <title>Insertar datos</title>
</head>
 <body>
  
 <div id="main-container">
        <form id="nuevo-pendiente-container" action="cursosql.php" method="POST">
            <input type="text" name="descri" id="descripcion">
            <input type="submit" value="Añadir">
        </form>
        <div id="mostrar-todo-container">
            <form id="formularioMostrar" action="" method="POST">
                <input type="checkbox" name="mostrar" onchange="mostrarTodo(this)" 
                <?php if(isset($_POST['mostrar'])) {
                    if($_POST['mostrar']== "on"){
                        echo " checked";
                    }
                    } ?> > Mostrar todo
            </form>
        </div>

    <div id="todolist">
                  
   
      
        <?php   
        //conexcion
           $servidor="localhost";
           $user="root";
           $password="";
           $db="todolist";
   
           $conexion = new mysqli($servidor,$user,$password,$db);
           if($conexion-> connect_error) {
               die("Conexion Fallida".$conexion -> connect_error);
               }
               
           
               
                //VALIDACION PARA INGRESAR
 
                if(isset($_POST['descri'])){
                    $descripcion = $_POST['descri'];
                    if($descripcion !="") {
                        
                            $sql = "INSERT INTO todoTable(descripcion, completado)
                            VALUES('$descripcion', false)";

                            if($conexion->query($sql) === true){

                            }else{
                            die("Error al insertar datos: " . $conexion->error);
                            } }
                            }
            //validacion para actualizae
                else if(isset($_POST['completar'])){
                    $id = $_POST['completar'];
    
                    $sql = "UPDATE todotable SET completado = 1 WHERE id = $id";
    
                    if($conexion->query($sql) === true){
                        
                    }else{
                        die("Error al actualizar datos: " . $conexion->error);
                    } 
                 
                } 
                   //validacion para Eliminar
                
                else if(isset($_POST['eliminar'])){
                    $id = $_POST['eliminar'];
    
                    $sql = "DELETE FROM todotable  WHERE id = $id";
    
                    if($conexion->query($sql) === true){
                        
                    }else{
                        die("Error al eliminar datos: " . $conexion->error);
                    }
                }  
                // PARA MOSTRAR TODO
                $sql = "";
                if(isset($_POST['mostrar'])){
                    $orden = $_POST['mostrar'];

                    if($orden == "on"){
                        $sql = "SELECT * FROM todotable ORDER BY completado DESC";    
                    }
                }else{
                    $sql = "SELECT * FROM todotable WHERE completado = 0";
                }

            //OBTENCION DE LOS DATOS DE LA TABLA
         
            $resultado = $conexion->query($sql);

                if($resultado->num_rows > 0){
                    while($Fila = $resultado->fetch_assoc()){
                        ?>

     
<div class="pendiente">
            <form method="POST" class="form_actualizar" id="form<?php echo $Fila['id']; ?>" action="">
             <input name ="completar" value="<?php echo $Fila['id']; ?>" id="<?php echo $Fila['id']; ?>" type="checkbox" 
            onchange="completarPendiente(this)" <?php if($Fila['completado'] == 1) echo " checked disabled"; ?>
            >
            
            <div class="descripcion <?php if($Fila['completado'] == 1)
             echo " deshabilitado"; ?>"><?php echo $Fila['descripcion'];?>
             
            </div>
            </form>

            <form method="POST" class="form_eliminar" action="cursosql.php">
                <input type="hidden" name="eliminar" value="<?php echo $Fila['id']; ?>"  />
                <input type="submit" value="Eliminar">
            </form>
</div>
        <?php 
           }      
            }  
             $conexion->close();               


        ?> 


</div>

<script> 
function mostrarTodo(e){
            var formu = document.getElementById("formularioMostrar");
            formu.submit();
        }

        function completarPendiente(e){
        var id="form" +e.id;
        var formulario = document.getElementById(id);
        formulario.submit();
}
        

</script>
 </body>
 </html>      

