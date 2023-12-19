<!-- Agrega el enlace al CSS de Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<?php
class pacientes
{
	private $IdPaciente;
	private $IdUsuario;
	private $Nombre;
	private $Cedula;
	private $Edad;
	private $Genero;
	private $Estatura;
	private $Peso;
	private $Foto;
	private $con;

	function __construct($cn)
	{
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
						<li class="nav-item">
						<a class="nav-link" href="../Usuarios/index.php">Usuarios</a>						
						</li>
						<li class="nav-item">
						<a class="nav-link" href="../Roles/index.php">Roles</a>						
						</li>
                        <li class="nav-item">
						<a class="nav-link" href="../Especialidades/index.php">Especialidades</a>						
						</li>
						<li class="nav-item">
						<a class="nav-link" href="../Medicamentos/index.php">Medicamentos</a>						
						</li>
                        <li class="nav-item">
						<a class="nav-link" href="../Medicos/index.php">Medicos</a>						
						</li>
						<li class="nav-item active">
						<a class="nav-link" href="../Pacientes/index.php">Pacientes<span class="sr-only">(current)</span></a>						
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

	public function update_paciente()
	{
		$this->IdPaciente = $_POST['IdPaciente'];
		$this->IdUsuario = $_POST['IdUsuario'];
		$this->Nombre = $_POST['Nombre'];
		$this->Cedula = $_POST['Cedula'];
		$this->Edad = $_POST['Edad'];
		$this->Genero = $_POST['generoRBT'];
		$this->Estatura = $_POST['Estatura'];
		$this->Peso = $_POST['Peso'];


		$sql = "UPDATE pacientes SET
									IdUsuario='$this->IdUsuario',
									Nombre='$this->Nombre',
									Cedula='$this->Cedula',
									Edad='$this->Edad',
									Genero='$this->Genero',
									Estatura='$this->Estatura',
									Peso='$this->Peso'

				WHERE IdPaciente=$this->IdPaciente;";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó");
		} else {
			echo $this->_message_error("al modificar");
		}

	}


	//*********************** 3.2 METODO save_vehiculo() **************************************************	

	public function save_paciente()
	{

		$this->IdUsuario = $_POST['IdUsuario'];
		$this->Nombre = $_POST['Nombre'];
		$this->Cedula = $_POST['Cedula'];
		$this->Edad = $_POST['Edad'];
		$this->Genero = $_POST['generoRBT'];
		$this->Estatura = $_POST['Estatura'];
		$this->Peso = $_POST['Peso'];

		/*
					  echo "<br> FILES <br>";
					  echo "<pre>";
						  print_r($_FILES);
					  echo "</pre>";
				  */
		//exit;
		$sql = "INSERT INTO pacientes VALUES(NULL,
											'$this->IdUsuario',
											'$this->Nombre',
											'$this->Cedula',
											'$this->Edad',
											'$this->Genero',
											'$this->Estatura',
											'$this->Peso');";

						
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("guardó");
		} else {
			echo $this->_message_error("guardar");
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

	private function _get_combo_dbp($tabla,$valor,$etiqueta,$nombre,$defecto){
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla WHERE Rol=3;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor])?'<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}

	private function _get_radio($arreglo,$nombre,$defecto){
		
		$html = '
		<table border=0 align="left">';
				
		foreach($arreglo as $etiqueta){
			$html .= '
			<tr>
				<td>' . $etiqueta . '</td>
				<td>';
				
				if($defecto == NULL){
					$html .= '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>';
				
				}else{
					$html .= ($defecto == $etiqueta)? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>' : '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';
				}
			
			$html .= '</tr>';
		}
		$html .= '
		</table>';
		return $html;
	}

	
	public function get_form($IdPaciente = NULL)
	{

		if ($IdPaciente == NULL) {
			$this->IdUsuario = NULL;
			$this->Nombre = NULL;
			$this->Cedula = NULL;
			$this->Edad = NULL;
			$this->Genero = NULL;
			$this->Estatura = NULL;
			$this->Peso = NULL;
			$this->Foto = NULL;

			$flag = "enabled";
			$op = "new";

		} else {

			$sql = "SELECT * FROM pacientes WHERE IdPaciente=$IdPaciente;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar la marca con IdPaciente= " . $IdPaciente;
				echo $this->_message_error($mensaje);
			} else {

				/* echo "<br>TUPLA <br>";
				echo "<pre>";
				print_r($row);
				echo "</pre>"; */

				$this->IdUsuario = $row['IdUsuario'];
				$this->Nombre = $row['Nombre'];
				$this->Cedula = $row['Cedula'];
				$this->Edad = $row['Edad'];
				$this->Genero = $row['Genero'];
				$this->Estatura = $row['Estatura'];
				$this->Peso = $row['Peso'];
				$flag = "disabled";
				$op = "update";
			}
		}

		$Generos = ["Masculino",
						 "Femenino"
						 ];

		$html = '
		' . $this->header() . '
				<form name="pacientes" method="POST" action="index.php" enctype="multipart/form-data">
					<input type="hidden" name="IdPaciente" value="' . $IdPaciente . '">
					<input type="hidden" name="op" value="' . $op . '">
					
					<div class="container">
					<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
						<table class="table table-bordered table-striped table-hover mx-auto" style="max-width: 800px;">
							<thead class="thead-dark">
								<tr>
							<th colspan="2" class="text-center">DATOS PACIENTES</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Nombre:</td>
								<td><input type="text" size="6" name="Nombre" value="' . $this->Nombre . '" required class="form-control"> </td>
							</tr>
							<tr>
								<td>Usuario:</td>
								<td>' . $this->_get_combo_dbp("usuarios", "IdUsuario", "nombre", "IdUsuario", $this->IdUsuario) . '</td>
							</tr>
							<tr>
								<td>Cedula:</td>
								<td><input type="text" size="6" name="Cedula" value="' . $this->Cedula . '"  required class="form-control"> </td>
							</tr>
							<tr>
								<td>Edad:</td>
								<td><input type="text" size="6" name="Edad" value="' . $this->Edad . '" required class="form-control"> </td>
							</tr>

							<div class="form-group">
							<tr>
								<td>Genero:</td>
								<td>' . $this->_get_radio($Generos, "generoRBT",$this->Genero) . '</td>
							</tr>
						</div>

							<tr>
								<td>Estatura (cm):</td>
								<td><input type="text" size="15" name="Estatura" value="' . $this->Estatura . '" required></td>
							</tr>
							<tr>
								<td>Peso (kg):</td>
								<td><input type="text" size="15" name="Peso" value="' . $this->Peso . '" required></td>
							</tr>
							<tr>
								<th colspan="2" class="text-center"><input type="submit" class="btn btn-primary" name="Guardar" value="GUARDAR"></th>
							</tr>
							<tr>
                            <th colspan="2"><a href="index.php" class="btn btn-secondary">Regresar</a>
                            </th>
                            </tr>
						</tbody>												
					</table>
				</form>
			</div>';
		return $html;
	}



	public function get_list()
	{
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
						<th colspan="10" class="text-center">Paciente</th>
					</tr>
					<tr>
						<th colspan="10" class="text-center">
							<a href="index.php?d=' . $d_new_final . '" class="btn btn-primary">
								<i class="fas fa-plus"></i> Nuevo
							</a>
						</th>
					</tr>
					<tr>
						<th class="text-center">Nombre</th>
						<th class="text-center">Cedula</th>
						<th colspan="3" class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>';
	
		$sql = "SELECT IdPaciente, Nombre, Cedula FROM pacientes;";
		$res = $this->con->query($sql);
	
		while ($row = $res->fetch_assoc()) {
			$d_del = "del/" . $row['IdPaciente'];
			$d_del_final = base64_encode($d_del);
	
			$d_act = "act/" . $row['IdPaciente'];
			$d_act_final = base64_encode($d_act);
	
			$d_det = "det/" . $row['IdPaciente'];
			$d_det_final = base64_encode($d_det);

			$html .= '
			<tr>
				<td class="text-center">' . $row['Nombre'] . '</td>
				<td class="text-center">' . $row['Cedula'] . '</td>
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
	
		$html .= '</tbody></table></div>';
		return $html;
	}

	

	public function get_detail_paciente($IdPaciente)
	{
		$sql = "SELECT p.IdPaciente, p.IdUsuario, p.Nombre, p.Cedula, p.Edad, p.Genero, p.Estatura, p.Peso, u.Nombre as NombreUsuario, u.Foto FROM pacientes p, usuarios u WHERE p.IdUsuario=u.IdUsuario AND IdPaciente = $IdPaciente;";
	
		$res = $this->con->query($sql);
	
		if ($res === false) {
			$mensaje = "tratar de editar la marca con IdPaciente= " . $IdPaciente;
			echo $this->_message_error($mensaje);
		} else {
			$row = $res->fetch_assoc();
	
			$html = '
			' . $this->header() . '
				<div class="container">
					<table class="table table-bordered table-striped mx-auto" style="max-width: 800px;">
						<thead class="thead-dark">
							<tr>
								<th colspan="2" class="text-center">DATOS DEL PACIENTE</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Nombre: </td>
								<td>' . $row['Nombre'] . '</td>
							</tr>
							<tr>
								<td>Usuario: </td>
								<td>' . $row['NombreUsuario'] . '</td>
							</tr>
							<tr>
								<td>Cedula: </td>
								<td>' . $row['Cedula'] . '</td>
							</tr>
							<tr>
								<td>Edad: </td>
								<td>' . $row['Edad'] . '</td>
							</tr>
							<tr>
								<td>Genero: </td>
								<td>' . $row['Genero'] . '</td>
							</tr>
							<tr>
								<td>Estatura (cm): </td>
								<td>' . $row['Estatura'] . '</td>
							</tr>
							<tr>
								<td>Peso (kg): </td>
								<td>' . $row['Peso'] . '</td>
							</tr>            
							<tr>
								<th colspan="2" class="text-center"><img src="' . PATH . '/' . $row['Foto'] . '" width="300px" class="img-fluid" alt="Foto del Paciente"/></th>
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
	



	public function delete_paciente($IdPaciente)
	{
		$sql = "DELETE FROM pacientes WHERE IdPaciente=$IdPaciente;";
		if ($this->con->query($sql)) {
			echo $this->_message_ok("ELIMINÓ");
		} else {
			echo $this->_message_error("eliminar");
		}
	}

	//*************************************************************************	

	private function _message_error($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th class="text-center"><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}


	private function _message_ok($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th class="text-center"><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}

	//****************************************************************************	

} // FIN SCRPIT
?>