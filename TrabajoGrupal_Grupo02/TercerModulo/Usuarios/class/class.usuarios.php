<?php
class rolpersona {
    private $IdUsuario;
    private $RolNombre;
    private $NombreUsuario;
    private $Password;
    private $Rol;
    private $Foto;
    private $con;

    function __construct($cn) {
        $this->con = $cn;
    }

    private function header(){
		$html = '

		<head>
		<!-- Basic -->
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!-- Site Metas -->
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="" />

		<title>Matriculacion Vehicular</title>

		<!-- slider stylesheet -->
		<link rel="stylesheet" type="text/css"
			href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

		<!-- bootstrap core css -->
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" />

		<!-- fonts style -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="../../css/style.css" rel="stylesheet" />
		<!-- responsive style -->
		<link href="../../css/responsive.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
		</head>

		<!-- header section strats -->
		<header class="header_section">
		<div class="container-fluid">
			<nav class="navbar navbar-expand-lg custom_nav-container ">
			<a class="navbar-brand" href="../../login/cerrar.php">
            <span>
			<img src="../../images/veris.png" alt="">
			VERIS
		  	</span>
			</a>
			
			<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
				data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<div class="d-flex flex-column flex-lg-row align-items-end ml-auto">
					<ul class="navbar-nav">
						<li class="nav-item active">
						<a class="nav-link" href="../Usuarios/index.php">Usuarios<span class="sr-only">(current)</span></a>						
						</li>
						<li class="nav-item">
						<a class="nav-link" href="../Roles/index.php">Roles</a>						
						</li>
                        <li class="nav-item">
						<a class="nav-link" href="../Especialidades/index.php">Especialidades </a>						
						</li>
						<li class="nav-item">
						<a class="nav-link" href="../Medicamentos/index.php">Medicamentos</a>						
						</li>
                        <li class="nav-item">
						<a class="nav-link" href="../Medicos/index.php">Medicos </a>						
						</li>
						<li class="nav-item">
						<a class="nav-link" href="../Pacientes/index.php">Pacientes</a>						
						</li>
						<li class="nav-item">
						<a class="nav-link" href="../../login/cerrar.php">Cerrar Sesion</a>						
						</li>
						
					</ul>
				</div>
			</div>


			</nav>
		</div>
		</header>
        <br>
			';
			return $html;
		}

    public function update_usuario(){
        $this->IdUsuario = $_POST['id'];
        $this->NombreUsuario = $_POST['Nombre'];
        $this->Password = $_POST['Password'];
        $this->Rol = $_POST['RolCMB'];
        $this->Foto = $_FILES['Foto']['name'];
    
        $sql = "UPDATE usuarios SET Nombre='$this->NombreUsuario',
                                    Password='$this->Password',
                                    Rol='$this->Rol',
                                    Foto='$this->Foto'
                WHERE IdUsuario=$this->IdUsuario;";
    
        if($this->con->query($sql)){
            echo $this->_message_ok("modificó");
        } else {
            echo $this->_message_error("al modificar");
        }
    }
    
    public function save_usuario() {
        $this->NombreUsuario = $_POST['Nombre'];
        $this->Password = $_POST['Password'];
        $this->Rol = $_POST['RolCMB'];
        $this->Foto = $_FILES['Foto']['name'];
    
        $sql = "INSERT INTO usuarios VALUES(NULL,
                                             '$this->NombreUsuario',
                                             '$this->Password',
                                             '$this->Rol',
                                             '$this->Foto');";
    
        if($this->con->query($sql)) {
            echo $this->_message_ok("guardó");
        } else {
            echo $this->_message_error("guardar");
        }
    }
    
    public function get_form($id = NULL) {
        if ($id === NULL) {
            $this->NombreUsuario = NULL;
            $this->Password = NULL;
            $this->Rol = NULL;
            $this->Foto = NULL;
    
            $flag = "disabled";
            $op = "new";
    
        } else {
            $sql = "SELECT * FROM usuarios WHERE IdUsuario = $id;";
            $res = $this->con->query($sql);
            $row = $res->fetch_assoc();
    
            $num = $res->num_rows;
            if ($num == 0) {
                $mensaje = "tratar de actualizar el usuario con el id = " . $id;
                echo $this->_message_error($mensaje);
            } else {
                // ***** TUPLA ENCONTRADA *****
                /* echo "<br>TUPLA <br>";
                echo "<pre>";
                print_r($row);
                echo "</pre>"; */
    
                $this->NombreUsuario = $row['Nombre'];
                $this->Password = $row['Password'];
                $this->Rol = $row['Rol'];
                $this->Foto = $row['Foto'];
    
                $flag = "disabled";
                $op = "update";
            }
        }
    
        $html = '
        ' . $this->header() . '
        <form name="rolpersona" method="POST" action="index.php" enctype="multipart/form-data">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th colspan="2" class="text-center">Datos del Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Usuario:</td>
                                <td><input type="text" name="Nombre" value="' . $this->NombreUsuario . '"></td>
                            </tr>
                            <tr>
                                <td>Password:</td>
                                <td><input type="text" name="Password" value="123' . $this->Password . '" ' . $flag . '></td>
                            </tr>
                            <tr>
                                <td>Rol:</td>
                                <td>' . $this->_get_combo_db("roles","IdRol","Nombre","RolCMB",$this->Rol) . '</td>
                            </tr>
                            <tr>
                                <td>Foto:</td>
                                <td><input type="file" name="Foto"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <input type="hidden" name="id" value="' . $id  . '">
                                    <input type="hidden" name="op" value="' . $op  . '">
                                    <input type="hidden" name="Password" value=123>
                                    <input type="submit" name="Guardar" value="GUARDAR" class="btn btn-primary">
                                    
                                </td>
                            </tr>
                            <tr>
						<th colspan="2"><a href="index.php" class="btn btn-secondary">Regresar</a>
						</th>
						</tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

					';
		return $html;
    }

    public function get_detail_usuario($id,$rol) {

        if($rol == 1){
            $path = PATH2;
        }elseif($rol == 2){
            $path = PATH1;
        }elseif($rol == 3){
            $path = PATH;
        }

        $sql = "SELECT u.IdUsuario, r.Nombre as RolNombre, r.Accion, u.Nombre AS NombreUsuario, u.Foto FROM usuarios u, roles r WHERE u.Rol=r.IdRol AND IdUsuario=$id;";
        $res = $this->con->query($sql);
        $row = $res->fetch_assoc();
    
        $num = $res->num_rows;
    
        if ($num == 0) {
            $mensaje = "tratar de editar el usaurio con el id= " . $id;
            echo $this->_message_error($mensaje);
        } else {
            $html = '
            ' . $this->header() . '
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
				   <div class="container">
				   <table class="table table-bordered">
				   <thead class="table-dark">
                <tr>
                <th colspan="8" class="text-center">Datos del Usuario</th>
                </tr>
				</thead>
                <tbody>
					<tr>
						<td>Nombre: </td>
						<td>'. $row['NombreUsuario'] .'</td>
					</tr>
                    <tr>
						<td>Rol: </td>
						<td>'. $row['RolNombre'] .'</td>
					</tr>
                    <tr>
						<td>Accion: </td>
						<td>'. $row['Accion'] .'</td>
					</tr>
                    <tr>
								<th colspan="2" class="text-center"><img src="' . $path . '/' . $row['Foto'] . '" width="300px" class="img-fluid" alt="Foto del Paciente"/></th>
							</tr>  
                            <tr>
                            <th colspan="2"><a href="index.php" class="btn btn-secondary">Regresar</a>
                            </th>
                            </tr>																						
                    </tbody>
					</table>
					</div>';
				

				return $html;
        }
    }
    
    
    public function get_list() {
        $d_new = "new/0";
        $d_new_final = base64_encode($d_new);
    
        $html = '
        ' . $this->header() . '

        <div class="container">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
			<table class="table table-bordered table-striped table-hover mx-auto" style="max-width: 800px;">
				<thead class="thead-dark">
					<tr>
						<th colspan="10" class="text-center">Usuarios</th>
					</tr>
					<tr>
						<th colspan="8" class="text-center">
							<a href="index.php?d=' . $d_new_final . '" class="btn btn-primary">
								<i class="fas fa-plus"></i> Nuevo
							</a>
						</th>
					</tr>
					<tr>
						<th>Usuario</th>
						<th colspan="3" class="text-center">Acciones</th>
					</tr>
				</thead>';
    
        $sql = "SELECT u.IdUsuario, u.Nombre as NombreUsuario, u.Foto, r.Nombre as RolNombre, r.IdRol FROM usuarios u, roles r WHERE u.Rol=r.IdRol ORDER BY u.IdUsuario ASC;";
        $res = $this->con->query($sql);
    
        while ($row = $res->fetch_assoc()) {
            $d_det = "det/" . $row['IdUsuario'] . "/" . $row['IdRol'];
			$d_det_final = base64_encode($d_det);
			$d_del = "del/" . $row['IdUsuario'];
            $d_del_final = base64_encode($d_del);
            $d_act = "act/" . $row['IdUsuario'];
            $d_act_final = base64_encode($d_act);
            $html .= '
                <tr>
                    <td>' . $row['NombreUsuario'] . '</td>
                    <td>
							<a href="index.php?d=' . $d_del_final . '" class="btn btn-danger">
								<i class="fas fa-trash"></i>
							</a>
						</td>
						<td>
							<a href="index.php?d=' . $d_act_final . '" class="btn btn-warning">
								<i class="fas fa-edit"></i>
							</a>
						</td>
						<td>
							<a href="index.php?d=' . $d_det_final . '" class="btn btn-info">
								<i class="fas fa-info"></i>
							</a>
						</td>
                </tr>';
        }
    
        $html .= '  
        </table>
        ';
    
        return $html;
    }
    
    public function delete_usuario($id) {
        $sql = "DELETE FROM usuarios WHERE IdUsuario=$id;";
        
        if ($this->con->query($sql)) {
            echo $this->_message_ok("ELIMINÓ");
        } else {
            echo $this->_message_error("eliminar");
        }
    }

    private function _get_combo_db($tabla,$valor,$etiqueta,$nombre,$defecto){
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor])?'<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
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
	

}
?>