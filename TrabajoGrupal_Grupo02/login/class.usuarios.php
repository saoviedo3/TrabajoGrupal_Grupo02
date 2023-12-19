<?php
class usuario{
	private $IdUsuario;
	private $usuario;
	private $Nombre;
	private $Rol;
	private $NombreRol;

	private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}

		public function bienvenida_usuario(){

			$usuario = $_SESSION['usuario'];
			$Rol = $_SESSION['Rol'];

			$sql = "SELECT u.IdUsuario, u.Nombre, u.Rol, r.Nombre as NombreRol
			FROM usuarios u, roles r
			WHERE u.Rol=r.IdRol and IdUsuario = '$usuario';";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			
			$num = $res->num_rows;
            if($num==0){
                $mensaje = "tratar de enviar la consulta";
                echo $this->_message_error($mensaje);
            }else{   
				$this->IdUsuario = $row['IdUsuario'];
				$this->Nombre = $row['Nombre'];
				$this->NombreRol = $row['NombreRol'];
				$Rol = $row['Rol'];
			}
			
			if ($Rol == 1) {
				echo "Bienvenido $this->NombreRol";
				$html = "<script>alert('Bienvenido " . $this->Nombre . "');
                window.location.href = '../TercerModulo/Usuarios/index.php';
                </script>";
			} elseif ($Rol == 2) {
				echo "Bienvenido $this->NombreRol";
				$html = "<script>alert('Bienvenido " . $this->Nombre . "');
                window.location.href = '../PrimerModulo/Consultas/index.php';
                </script>";
			} elseif ($Rol == 3) {
				echo "Bienvenido $this->NombreRol";
				$html = "<script>alert('Bienvenido " . $this->Nombre . "');
                window.location.href = '../SegundoModulo/Pacientes/index.php';
                </script>";				
			} 

		
		echo $html;
		}

	private function _get_combo_db($tabla,$valor,$etiqueta,$nombre,$defecto, $rol){
		$html = '<select name="' . $nombre . '" class="form-control">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla WHERE Rol=$rol;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			$html .= ($defecto == $row[$valor])?'<option value="' . $row[$valor] . '" class="form-select" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}

	public function get_login_admin(){
		
		$this->Rol = $_GET['rol'];

		$sql = "SELECT IdUsuario
		FROM usuarios;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			
			$num = $res->num_rows;
            if($num==0){
                $mensaje = "tratar de enviar la consulta";
                echo $this->_message_error($mensaje);
            }else{   
			
				$this->IdUsuario = $row['IdUsuario'];

			}
		
			$flag = "disabled";

			$html = '
			<!DOCTYPE html>
			<html>
			<head>
				<title>Formulario de login</title>
				<!-- CSS de Bootstrap -->
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
				<style>
					body {
						background-color: #f8f9fa;
					}
					.card {
						box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
					}
					
				</style>
			</head>
			<body>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-6">
							<div class="card mt-5">
								<div class="card-body">
									<h2 class="card-title text-center text-primary">Formulario de login</h2>
									<form name="login" method="POST" action="validar.php" enctype="multipart/form-data">
										<div class="form-group ">
											<label for="usuario">Usuario</label>
											' . $this->_get_combo_db("usuarios", "IdUsuario", "Nombre", "usuario", $this->IdUsuario, $this->Rol) . '
										</div>
										
										<div class="form-group">
											<label for="clave">Contraseña</label>
											<input type="password" class="form-control" id="clave" placeholder="🔐 Contraseña" name="clave" value="123">
										</div>

										<div class="form-group">
											<label for="clave">2FA</label>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="customSwitch1" onchange="toggle2FA()">
											<label class="custom-control-label" for="customSwitch1">Encendido/Apagado</label>
										  </div>
										</div>
										<div class="form-group">
											<input type="text" class="form-control" id="2fa" name="2fa" value="L00381647" '.$flag.'>
										</div>
										
										<button class="btn btn-primary btn-block" type="submit" name="LOGIN">Iniciar sesión</button>
										<a href="../index.html" class="btn btn-danger btn-block">Cancelar</a>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
				<script>
					function toggle2FA() {
					var checkBox = document.getElementById("customSwitch1");
					var text = document.getElementById("2fa");
					if (checkBox.checked == true){
						text.disabled = false;
					} else {
						text.disabled = true;
					}
					}
					</script>
			</html>
			';

			return $html;

	}
	

	public function get_login(){
		
		$this->Rol = $_GET['rol'];

		$sql = "SELECT IdUsuario
		FROM usuarios;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			
			$num = $res->num_rows;
            if($num==0){
                $mensaje = "tratar de enviar la consulta";
                echo $this->_message_error($mensaje);
            }else{   
			
				$this->IdUsuario = $row['IdUsuario'];

			}
		

			$html = '
			<!DOCTYPE html>
			<html>
			<head>
				<title>Formulario de login</title>
				<!-- CSS de Bootstrap -->
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
				<style>
					body {
						background-color: #f8f9fa;
					}
					.card {
						box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
					}
					
				</style>
			</head>
			<body>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-6">
							<div class="card mt-5">
								<div class="card-body">
									<h2 class="card-title text-center text-primary">Formulario de login</h2>
									<form name="login" method="POST" action="validar.php" enctype="multipart/form-data">
										<div class="form-group ">
											<label for="usuario">Usuario</label>
											' . $this->_get_combo_db("usuarios", "IdUsuario", "Nombre", "usuario", $this->IdUsuario, $this->Rol) . '
										</div>
										
										<div class="form-group">
											<label for="clave">Contraseña</label>
											<input type="password" class="form-control" id="clave" placeholder="🔐 Contraseña" name="clave" value="123">
										</div>
										
										<button class="btn btn-primary btn-block" type="submit" name="LOGIN">Iniciar sesión</button>
										<a href="../index.html" class="btn btn-danger btn-block">Cancelar</a>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- JS de Bootstrap -->
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
			</body>
			</html>
			';

			return $html;

	}
	
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
	
	private function _message_ok($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
//****************************************************************************	
	
} // FIN SCRPIT
?>

