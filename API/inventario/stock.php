<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

    	$servername = "localhost";
				$username = "root";
				$password = "";

				$conn = mysqli_connect($servername, $username, $password,'stockapp');

				if (!$conn) {
				    die("Connection failed: " . mysqli_connect_error());
				}


function mostrar_articulos($con,$detalle){
        $allArticles; 

          if ($detalle=='lista') {
                    
        $sql = "SELECT art_nom FROM articulo";
        $resultados = mysqli_query($con,$sql);
          } else {
            $sql = "SELECT art_nom FROM articulo where art_id='".$detalle."'";
          $resultados = mysqli_query($con,$sql);
          }
          while($fila = mysqli_fetch_array($resultados,MYSQLI_ASSOC)) {
             $allArticles[]=$fila;
          }
          return $allArticles;
  }

    function mostrar_categorias($con,$detalle){
        $allCategories;
        if ($detalle=='lista') {
            $sql = "SELECT cat_name from categoria";
          $resultados = mysqli_query($con,$sql);
        }else {
            $sql = "SELECT cat_name from categoria where cat_id='".$detalle."'";
          $resultados = mysqli_query($con,$sql);
          }


          while($fila = mysqli_fetch_array($resultados,MYSQLI_ASSOC)) {
             $allCategories[]=$fila;
        }
        return $allCategories;
    }

    //Cambiar nuevo autor por nueva categoria o articulo junto con la SQL
    function guardar_nuevo_autor($con){
      $sql="insert into libros(autor,titulo) values('".$_POST['autor']."','".$_POST['titulo']."')";
      mysqli_query($con,$sql);
      #echo $sql;
      #echo "guardado".mysqli_error($con);
      header('Location: ../../../');
      exit;
   }
  
   function login($con){
   	$res;
	$user = mysqli_real_escape_string($con, $_POST["user"]);
  	$pass = mysqli_real_escape_string($con, $_POST["pass"]);
	$sql="select * from usuario where us_email='".$user."' and us_pass='".$pass."'";
	$resultados = mysqli_query($con,$sql);
	$num_row = mysqli_num_rows($resultados);
  if ($num_row == "1") {
      $fila = mysqli_fetch_array($resultados,MYSQLI_ASSOC);
     		$res = array("login"=>true, "id"=>$fila['us_id'],"user"=>$fila['us_nom']);
        return $res;
  } else {
    $res = array("login"=>false, "msj"=>"Los Datos Ingresados no son Correctos");
    return $res;
    }
  }
  
   switch ($_GET['peticion']) {
   	case 'login':
   		$resultados=login($conn);
   		break;
    case 'articulo':
      $resultados=mostrar_articulos($conn,$_GET['detalle']);
      break;
    case 'categoria':
      $resultados=mostrar_categorias($conn,$_GET['detalle']);
      break;
   	default:
   		header('HTTP/1.1 405 Method Not Allowed');
    	exit;
   		break;
   }
    echo json_encode($resultados);
    
?>

