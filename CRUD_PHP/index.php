<?php
    include_once "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Referencia a Bootstrap core CSS --> 
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <!-- Referencia a la librería de JQuery --> 
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function(){
                $(".content").fadeOut(1500);
            },3000);
        })
    </script>
    <title>Crud con PHP y MySQL</title>
</head>
<body>
    <div class="container md-5">
        <?php
            if(isset($_POST['eliminar'])){

                $consulta = "DELETE FROM `tbl_personal` WHERE `id`=:id";
                $sql = $connect->prepare($consulta);
                $sql->bindParam(':id', $id, PDO::PARAM_INT);
                $id=trim($_POST['id']);
                $sql->execute();
                
                if($sql->rowCount() > 0){
                    $count = $sql->rowCount();
                    echo "<div class='content alert alert-primary' style='position:absolute; top:0px;'>Gracias: $count registro ha sido eliminado</div>";

                }else{
                    echo "<div class='content alert alert-danger' style='position: absolute; top: 0px;'> No se pudo eliminar el registro</div>";
                }
            }

            if(isset($_POST['insertar'])){

                $nombres = $_POST['nombres']; 
                $apellidos = $_POST['apellidos']; 
                $profesion = $_POST['profesion']; 
                $estado = $_POST['estado']; 
                $fregis = date('Y-m-d');


                $sql="insert into tbl_personal(nombres,apellidos,profesion,estado,fregis) values(:nombres,:apellidos,:profesion,:estado,:fregis)";
                $sql = $connect->prepare($sql);

                $sql->bindParam(':nombres',$nombres,PDO::PARAM_STR, 25); 
                $sql->bindParam(':apellidos',$apellidos,PDO::PARAM_STR, 25); 
                $sql->bindParam(':profesion',$profesion,PDO::PARAM_STR,25); 
                $sql->bindParam(':estado',$estado,PDO::PARAM_STR,25); 
                $sql->bindParam(':fregis',$fregis,PDO::PARAM_STR); 
                $sql->execute(); 
                $lastInsertId = $connect->lastInsertId();

                if($lastInsertId>0){ 
                    echo "<div class='content alert alert-primary' style='position: absolute; top: 0px;'> Gracias .. Tu Nombre es : $nombres  </div>"; 

                }else{ 
                    echo "<div class='content alert alert-danger' style='position: absolute; top: 0px;'> No se pueden agregar datos, comuníquese con el administrador </div>"; 
                } 
            }

            if(isset($_POST['actualizar'])){

                $id = trim($_POST['id']); 
                $nombres = trim($_POST['nombres']); 
                $apellidos = trim($_POST['apellidos']); 
                $profesion = trim($_POST['profesion']); 
                $estado = trim($_POST['estado']); 
                $fregis = date('Y-m-d');

                $consulta = "UPDATE tbl_personal SET `nombres`= :nombres, `apellidos` = :apellidos, `profesion` = :profesion, `estado` = :estado, `fregis` = :fregis WHERE `id` = :id"; 

                $sql = $connect->prepare($consulta); 
                $sql->bindParam(':nombres',$nombres,PDO::PARAM_STR, 25); 
                $sql->bindParam(':apellidos',$apellidos,PDO::PARAM_STR, 25); 
                $sql->bindParam(':profesion',$profesion,PDO::PARAM_STR,25);
                $sql->bindParam(':estado',$estado,PDO::PARAM_STR,25); 
                $sql->bindParam(':fregis',$fregis,PDO::PARAM_STR); 
                $sql->bindParam(':id',$id,PDO::PARAM_INT); 
                $sql->execute();

                if($sql->rowCount() > 0){ 
                    $count = $sql -> rowCount(); 
                    echo "<div class='content alert alert-primary' style='position: absolute; top: 0px;'>Gracias: $count registro ha sido actualizado</div>"; 

                  }else{ 
                    echo "<div class='content alert alert-danger' style='position: absolute; top: 0px;'> No se pudo actulizar el registro  </div>"; 
                  } 
            }
        ?>
        <h3 class="mt-5" style="color: tomato;">CRUD PDO PHP y MySQL</h3> 
        <hr> 
        <div class="row">
            <?php
                if (isset($_POST['formInsertar'])){
            ?>

        <div class="col-12 col-md-12">  
            <form action="" method="POST"> 
            <div class="form-row"> 
                <div class="form-group col-md-6"> 
                    <label for="nombres">Nombres</label> 
                    <input name="nombres" type="text" class="form-control" placeholder="Nombres"> 
                </div> 
                <div class="form-group col-md-6"> 
                    <label for="edad">Apellidos</label> 
                    <input name="apellidos" type="text" class="form-control" id="edad" placeholder="Apellidos"> 
                </div> 
            </div> 
            <div class="form-row">   
                <div class="form-group col-md-6"> 
                <label for="profesion">Profesión</label> 
                <input name="profesion" type="text" class="form-control" id="profesion" placeholder="Profesion"> 
                </div> 
        
            <div class="form-group col-md-6"> 
                <label for="Estado">Estado</label> 
                <select required name="estado" class="form-control" id="Estado"> 
                    <option value=""><< >></option> 
                    <option value="El Salvador">El Salvador</option> 
                    <option value="Guatemala">Guatemala</option> 
                    <option value="Honduras">Honduras</option> 
                    <option value="Nicaragua">Nicaragua</option> 
                    <option value="Costa Rica">Costa Rica</option> 
                    <option value="Panamá">Panamá</option> 
                </select> 
            </div> 

            </div> 
            <div class="form-group"> 
                <button name="insertar" type="submit" class="btn btn-info">Guardar</button> 
            </div> 
            </form> 
            </div>  
            <?php  
            }   
            ?> 
    
    <?php  //Editar
        if (isset($_POST['editar'])){ 
        $id = $_POST['id']; 
        $sql= "SELECT * FROM tbl_personal WHERE id = :id";  
        $stmt = $connect->prepare($sql); 
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);  
        $stmt->execute(); 
        $obj = $stmt->fetchObject(); 
    ?> 
    <div class="col-12 col-md-12">  
        <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
            <input value="<?php echo $obj->id;?>" name="id" type="hidden"> 
        <div class="form-row"> 
            <div class="form-group col-md-6"> 
            <label for="nombres">Nombres</label> 
            <input value="<?php echo $obj->nombres;?>" name="nombres" type="text" class="form-control" placeholder="Nombres"> 
        </div>
        <div class="form-group col-md-6"> 
          <label for="edad">Apellidos</label> 
          <input value="<?php echo $obj->apellidos;?>" name="apellidos" type="text" class="form-control" id="edad" placeholder="Apellidos">
          </div> 
        </div> 
        <div class="form-row">   
        <div class="form-group col-md-6"> 
          <label for="profesion">Profesión</label> 
          <input value="<?php echo $obj->profesion;?>" name="profesion" type="text" class="form-control" id="profesion" placeholder="Profesion"> 
        </div> 
        <div class="form-group col-md-6"> 
            <label for="Estado">Estado</label> 
            <select required name="estado" class="form-control" id="Estado"> 
            <option value="<?php echo $obj->estado;?>"><?php echo $obj->estado;?><option>         
            <option value=""><< >></option> 
            <option value="El Salvador">El Salvador</option> 
            <option value="Guatemala">Guatemala</option> 
            <option value="Honduras">Honduras</option> 
            <option value="Nicaragua">Nicaragua</option> 
            <option value="Costa Rica">Costa Rica</option> 
            <option value="Panamá">Panamá</option> 
            </select> 
        </div> 
        </div> 
        <div class="form-group"> 
          <button name="actualizar" type="submit" class="btn btn-info">Guardar Cambios</button> 
        </div> 
        </form> 
        </div>   
    <?php  
    } 
    ?> 

    <?php
        if (isset($_POST['buscar'])) {
            //Recogemos las claves enviadas
            $buscar = $_POST['buscar'];
    ?>

        <div class="container">
        <div class="col-12 col-md-12 jumbotron">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class='thead-dark'>
                        <th width='18%'>Nombres</th> 
                        <th width='22%'>Apellidos</th> 
                        <th width='22%'>Profesión</th> 
                        <th width='14%'>Estado</th> 
                        <th width='13%'>Fecha registro</th> 
                        <th width='13%' colspan='2'></th> 
                    </thead>
                    <tbody>
                    <?php 
                    
                        $sql = "SELECT * FROM tbl_personal WHERE MATCH(nombres, apellidos, profesion, estado) AGAINST ('$buscar')";
                        $stat = $connect->prepare($sql); 
                        $stat->execute();
                        $resultado = $stat->fetchAll(PDO::FETCH_OBJ);

                        //Si ha resultados
                        if ($stat->rowCount() > 0) {

                            echo "<h2>Registros Encontrados:</h2>";
                            foreach($resultado as $resultados){
                                echo "
                                <tr> 
                                <td>".$resultados->nombres."</td> 
                                <td>".$resultados->apellidos."</td> 
                                <td>".$resultados->profesion."</td> 
                                <td>".$resultados->estado."</td> 
                                <td>".$resultados->fregis."</td> 
                                <td> 
                                <form method='POST' actino='".$_SERVER['PHP_SELF']."'> 
                                <input type='hidden' name='id' value='".$resultados -> id."'> 
                                <button name='editar' class='btn btn-info btn-sm'>Editar</button> 
                                </form> 
                                </td> 

                                <td> 
                                <form  onsubmit=\"return confirm('¿Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'> 
                                <input type='hidden' name='id' value='".$resultados -> id."'> 
                                <button name='eliminar' class='btn btn-danger btn-sm'>Eliminar</button> 
                                </form> 
                                </td> 
                                </tr>";
                            }
                        }
                        else {
                            //Si no hay registros encontrados
                            echo '<h2>No se encuentran resultados con los criterios de búsqueda.</h2>';
                        }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
        </div>
    <?php
        }
    ?>


        
        

        <div class="col-12 col-md-12">  
            
            <div class="container">
                <div class="row">
                    <div class="col-4">
                    <div style="float:left; margin-bottom:5px;"> 
                        <form action="" method="post"> 
                            <button class="btn btn-success" name="formInsertar">Nuevo registro</button>   
                            <a href="index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
                        </form>
                    </div> 
                    </div>
                    <div class="col-4">
                        
                    </div>
                    <div class="col-4">
                        <form action="index.php" method="post" class="d-flex" class="ml-auto">
                            <input class="form-control ml-auto" type="search" name="buscar" id="buscar" placeholder="Buscar" aria-label="Search">
                            <button class="btn btn-outline-success ml-auto" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        <div class="table-responsive"> 
            <table class="table table-bordered table-striped"> 
            <thead class="thead-dark">
                <th width="18%">Nombres</th> 
                <th width="22%">Apellidos</th> 
                <th width="22%">Profesión</th> 
                <th width="14%">Estado</th> 
                <th width="13%">Fecha registro</th> 
                <th width="13%" colspan="2"></th> 
            </thead>
            <tbody> 
                <?php 
                /*$sql = "SELECT * FROM tbl_personal";  
                $query = $connect -> prepare($sql);  
                $query->execute();  
                $results = $query->fetchAll(PDO::FETCH_OBJ);*/

                /*if($query->rowCount() > 0)   {  */

                    // cuantas filas quiere ver por página
                    $registrosPorPagina = 4;

                    // por defecto estamos en la 1; si se envía otra página tomamos esa
                    $pagina = 1;
                    if (isset($_GET["pagina"])) {
                        # tomamos esa
                        $pagina = $_GET["pagina"];
                    }

                    // el límite define el número de productos por página 
                    $limit = $registrosPorPagina;

                    // el offset saltar x cantidad de registros. Multiplicamos la pagina -1
                    $offset = ($pagina - 1) * $registrosPorPagina;

                    // contar las fila de la tabla
                    $sentencia = $connect->query("SELECT count(*) AS conteo FROM tbl_personal");
                    $conteo = $sentencia->fetchObject()->conteo;

                    // obtener la cantidad de páginas a mostrar
                    $paginas = ceil($conteo / $registrosPorPagina); //3.33333

                    // para obtener los productos (aplicando limit y offset) - preparamos
                    $sentencia = $connect->prepare("SELECT * FROM tbl_personal LIMIT ? OFFSET ?");
                    // ejecutamos
                    $sentencia->execute([$limit, $offset]);
                    // obtener la colección de filas del select
                    $registro = $sentencia->fetchAll(PDO::FETCH_OBJ); // ESTÁ LLENO
                    // con $productos vamos a mostrar las filas en la tabla
                    foreach($registro as $registros) {  
                        echo "<tr> 
                        <td>".$registros->nombres."</td> 
                        <td>".$registros->apellidos."</td> 
                        <td>".$registros->profesion."</td> 
                        <td>".$registros->estado."</td> 
                        <td>".$registros->fregis."</td> 
                        <td> 
                        <form method='POST' actino='".$_SERVER['PHP_SELF']."'> 
                        <input type='hidden' name='id' value='".$registros->id."'> 
                        <button name='editar' class='btn btn-info btn-sm'>Editar</button> 
                        </form> 
                        </td> 

                        <td> 
                        <form  onsubmit=\"return confirm('¿Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'> 
                        <input type='hidden' name='id' value='".$registros->id."'> 
                        <button name='eliminar' class='btn btn-danger btn-sm'>Eliminar</button> 
                        </form> 
                        </td> 
                        </tr>"; 
               /* } */
            } 
            ?> 
            </tbody> 
            </table> 

            <nav>
                <div class="col-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">

                        <p>Mostrando <?php echo $registrosPorPagina ?> de <?php echo $conteo ?> registros</p>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <p>Página <?php echo $pagina ?> de <?php echo $paginas ?> </p>
                    </div>
                </div>  
                <ul class="pagination">
                    <!-- Si la página actual es mayor a uno, mostramos el botón para ir una página atrás -->
                    <?php if ($pagina > 1) { ?>
                        <li>
                            <a href="index.php?pagina=<?php echo $pagina - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- Mostramos enlaces para ir a todas las páginas. Es un simple ciclo for-->
                    <?php for ($x = 1; $x <= $paginas; $x++) { ?>
                        <li class="<?php if ($x == $pagina) echo "active" ?>">
                            <a href="index.php?pagina=<?php echo $x ?>">
                                <?php echo $x ?></a>
                        </li>
                    <?php } ?>

                    <!-- Si la página actual es menor al total de páginas, mostramos un botón para ir una página adelante -->
                    <?php if ($pagina < $paginas) { ?>
                        <li>
                            <a href="index.php?pagina=<?php echo $pagina + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>     
                </div> 
            </nav>

            </div> 
            </div>   
        </div> 
    </div>

    <footer class="footer"> 
        <div class="container">  
            <span class="text-muted" style="text-align: center;"> 
            <p>ITCA-FEPADE <?php echo date('Y'); ?></p> 
            </span> 
        </div> 
    </footer> 
</body>
</html>