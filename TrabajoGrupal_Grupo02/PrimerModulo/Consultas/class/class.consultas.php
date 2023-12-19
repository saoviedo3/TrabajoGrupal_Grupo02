<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<?php
class consultas
{
	private $IdConsulta;
	private $IdMedico;
	private $IdPaciente;
	private $FechaConsulta;
	private $HI;
	private $HF;
	private $Diagnostico;
	private $NombreP;
	private $NombreM;
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
						<li class="nav-item active">
						<a class="nav-link" href="../Consultas/index.php">Consultas <span class="sr-only">(current)</span></a>						
						</li>
						<li class="nav-item">
						<a class="nav-link" href="../Recetas/index.php">Recetas</a>						
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
			';
			return $html;
		}
		

	public function update_consulta()
	{
		$this->IdConsulta = $_POST['IdConsulta'];
		$this->IdMedico = $_POST['IdMedicoCMB'];
		$this->IdPaciente = $_POST['IdPacienteCMB'];
		$this->FechaConsulta = $_POST['FechaConsulta'];
		$this->HI = $_POST['HI'];
		$this->HF = $_POST['HF'];
		$this->Diagnostico = $_POST['Diagnostico'];

		$sql = "UPDATE consultas SET
									IdMedico='$this->IdMedico',
									IdPaciente='$this->IdPaciente',
									FechaConsulta='$this->FechaConsulta',
									HI='$this->HI',
									HF='$this->HF',
									Diagnostico='$this->Diagnostico'

				WHERE IdConsulta=$this->IdConsulta;";

		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó");
		} else {
			echo $this->_message_error("al modificar");
		}

	}


	public function save_consulta()
	{
		echo "<br>PETICION POST <br>";
				echo "<pre>";
					print_r($_POST);
				echo "</pre>";

		$this->IdConsulta = $_POST['IdConsulta'];
		$this->IdMedico = $_POST['IdMedicoCMB'];
		$this->IdPaciente = $_POST['IdPacienteCMB'];
		$this->FechaConsulta = $_POST['FechaConsulta'];
		$this->HI = $_POST['HI'];
		$this->HF = $_POST['HF'];
		$this->Diagnostico = $_POST['Diagnostico'];

		$sql = "INSERT INTO consultas VALUES(NULL,
											'$this->IdMedico',
											'$this->IdPaciente',
											'$this->FechaConsulta',
											'$this->HI',
											'$this->HF',
											'$this->Diagnostico');";

						
		echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("guardó");
		} else {
			echo $this->_message_error("guardar");
		}

	}


	private function _get_combo_db($tabla, $valor, $etiqueta, $nombre, $defecto)
	{
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT DISTINCT $valor, $etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		while ($row = $res->fetch_assoc()) {
			$html .= ($defecto == $row[$valor]) ? '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>';
		}
		$html .= '</select>';
		return $html;
	}

	private function _get_combo_dbm($tabla, $valor, $etiqueta, $nombre, $defecto)
	{
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT DISTINCT $valor, $etiqueta FROM $tabla WHERE $valor=$defecto;";
		$res = $this->con->query($sql);
		while ($row = $res->fetch_assoc()) {
			$html .= ($defecto == $row[$valor]) ? '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>';
		}
		$html .= '</select>';
		return $html;
	}

	private function _get_combo_dbmn($tabla, $valor, $etiqueta, $nombre, $defecto)
	{
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor, $etiqueta FROM $tabla WHERE IdUsuario=$defecto;";
		$res = $this->con->query($sql);
		while ($row = $res->fetch_assoc()) {
			$html .= ($defecto == $row[$valor]) ? '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>';
		}
		$html .= '</select>';
		return $html;
	}

	
	public function get_form($IdConsulta = NULL)
	{
		/* echo "<br>PETICION POST <br>";
				echo "<pre>";
					print_r($_SESSION);
				echo "</pre>"; */

		$usuario=$_SESSION['usuario'] ;

			/* echo $usuario; */

			$sql = "SELECT IdUsuario, Nombre as NombreM, IdMedico FROM medicos WHERE IdUsuario=$usuario;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar la consulta con id= " . $usuario;
				echo $this->_message_error($mensaje);
			} else {

			$this->NombreM = $row['NombreM'];
			$this->IdMedico = $row['IdMedico'];
			$idm=$this->IdMedico;

				
			}

		if ($IdConsulta == NULL) {
			

			$this->IdMedico = NULL;
			$this->IdPaciente = NULL;
			$this->FechaConsulta = NULL;
			$this->HI =  NULL;
			$this->HF = NULL;
			$this->DIagnostico = NULL;

			$flag1 = "disabled";
				$flag = "enabled";
				$op = "new";


		} else {

			$sql = "SELECT c.IdConsulta, c.IdMedico, c.IdPaciente, c.FechaConsulta, c.HI, c.HF, c.Diagnostico, p.Nombre as NombreP FROM consultas c, pacientes p, medicos m WHERE c.IdPaciente=p.IdPaciente AND c.IdMedico=m.IdMedico AND IdConsulta=$IdConsulta;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar la consulta con id= " . $IdConsulta;
				echo $this->_message_error($mensaje);
			} else {

				// ***** TUPLA ENCONTRADA *****
				/* echo "<br>TUPLA <br>";
				echo "<pre>";
				print_r($row);
				echo "</pre>"; */

				$this->IdMedico = $row['IdMedico'];
				$this->IdPaciente = $row['IdPaciente'];
				$this->NombreP = $row['NombreP'];
				$this->FechaConsulta = $row['FechaConsulta'];
				$this->HI = $row['HI'];
				$this->HF = $row['HF'];
				$this->Diagnostico = $row['Diagnostico'];

				$flag = "disabled";
				$flag1 = "disabled";
				$op = "update";
			}
		}


		$html = '
		'. $this->header() .'	
			<div class="container">
				<form name="consulta" method="POST" action="index.php" enctype="multipart/form-data">
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
					<input type="hidden" name="IdConsulta" value="' . $IdConsulta . '">
					<input type="hidden" name="op" value="' . $op . '">
					<input type="hidden" name="IdMedicoCMB" value="' . $idm . '">
					<br>
  					<table align="center" class="table table-bordered table-striped">
						<thead class="thead-dark">
							<tr>
							<th colspan="2" class="text-center">DATOS DE LA CONSULTA</th>
							</tr>
						</thead>
						<tbody>
						<tr>
						<td>Medico:</td>
						<td><input type="text" name="IdMedicoCMB" value="' . $this->NombreM . '" '. $flag1. ' required class="form-control"> </td>
					</tr>';

							if($op == "new"){
								$html .= '
								<tr>
									<td>Paciente:</td>
									<td>' . $this->_get_combo_db("pacientes", "IdPaciente", "Nombre", "IdPacienteCMB", $this->IdPaciente) . '</td>
								</tr>';
							}else{
								$html .= '
								<tr>
									<td>Paciente:</td>
									<td><input type="text" name="IdPacienteCMB" value="' . $this->NombreP . '" '. $flag. ' required class="form-control"> </td>
								</tr>
								<input type="hidden" name="IdPacienteCMB" value="' . $this->IdPaciente . '">
								';
							}

							$html .= '
								
							<tr>
								<td>Fecha de la Consulta:</td>
								<td><input type="date" name="FechaConsulta" value="' . $this->FechaConsulta . '"  required class="form-control"> </td>
							</tr>
							<tr>
								<td>Hora de Inicio:</td>
								<td><input type="time" size="6" name="HI" value="' . $this->HI . '" required class="form-control"> </td>
							</tr>							
							<tr>
								<td>Hora Final:</td>
								<td><input type="time" size="6" name="HF" value="' . $this->HF . '" required class="form-control"> </td>
							</tr>						
							<tr>
								<td>Diagnóstico:</td>
								<td><input type="text" name="Diagnostico" value="' . $this->Diagnostico . '" required></td>
							</tr>
							<tr>
								<th colspan="2" class="text-center"><input type="submit" name="Guardar" value="GUARDAR" class="btn btn-primary"></th>
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
		'. $this->header() .'
		<br>
		<div class="container">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
		<style>
			.deshabilitado { 
				pointer-events: none; 
				cursor: default; 
			} 
			</style>
			<table class="table table-bordered table-striped table-hover mx-auto" style="max-width: 800px;">
				<thead class="thead-dark">
					<tr>
						<th colspan="10" class="text-center">Consultas</th>
					</tr>
					<tr>
						<th colspan="10" class="text-center">
							<a href="index.php?d=' . $d_new_final . '" class="btn btn-primary">
								<i class="fas fa-plus"></i> Nuevo
							</a>
						</th>
					</tr>
					<tr>
						<th class="text-center">Paciente</th>
						<th class="text-center">Medico</th>
						<th class="text-center">Fecha de la Consulta</th>
						<th colspan="3" class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>';
	
		$sql = "SELECT C.IdConsulta, M.Nombre as Medico, P.Nombre as Paciente, C.FechaConsulta 
		FROM consultas c
		JOIN medicos m ON c.IdMedico = m.IdMedico
		JOIN pacientes p ON c.IdPaciente = p.IdPaciente
		JOIN usuarios u ON m.IdUsuario = u.IdUsuario
		WHERE u.IdUsuario = " . $_SESSION['usuario'] . "
		ORDER BY C.FechaConsulta ASC;";

		$res = $this->con->query($sql);

		while ($row = $res->fetch_assoc()) {
			$d_del = "del/" . $row['IdConsulta'];
			$d_del_final = base64_encode($d_del);
	
			$d_act = "act/" . $row['IdConsulta'];
			$d_act_final = base64_encode($d_act);
	
			$d_det = "det/" . $row['IdConsulta'];
			$d_det_final = base64_encode($d_det);
	

			$html .= '
			<tr>
				
				<td class="text-center">' . $row['Paciente'] . '</td>
				<td class="text-center">' . $row['Medico'] . '</td>
				<td class="text-center">' . $row['FechaConsulta'] . '</td>
				<td>
					<a href="index.php?d=' . $d_del_final . '" class="btn btn-danger deshabilitado">
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

	

	public function get_detail_consulta($IdConsulta)
	{
		$sql = "SELECT C.IdConsulta, M.Nombre as Medico, P.Nombre as Paciente, c.FechaConsulta, c.HI, c.HF, c.Diagnostico	
				FROM consultas c
				JOIN medicos m ON c.IdMedico = m.IdMedico
				JOIN pacientes p ON c.IdPaciente = p.IdPaciente
				WHERE IdConsulta = $IdConsulta;";

	$res = $this->con->query($sql);
	
		if ($res === false) {
			$mensaje = "tratar de editar la consulta con id= " . $IdConsulta;
			echo $this->_message_error($mensaje);
		} else {
			$row = $res->fetch_assoc();
	
			$html = '
			'. $this->header() .'	

			<br>
				<div class="container">
					<table class="table table-bordered table-striped mx-auto" style="max-width: 800px;">
						<thead class="thead-dark">
							<tr>
								<th colspan="2" class="text-center">DATOS DE LA CONSULTA</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Médico: </td>
								<td>' . $row['Medico'] . '</td>
							</tr>
							<tr>
								<td>Paciente: </td>
								<td>' . $row['Paciente'] . '</td>
							</tr>
							<tr>
								<td>Fecha de la Consulta: </td>
								<td>' . $row['FechaConsulta'] . '</td>
							</tr>
							<tr>
								<td>Hora de Inicio: </td>
								<td>' . $row['HI'] . '</td>
							</tr>
							<tr>
								<td>Hora Final: </td>
								<td>' . $row['HF'] . '</td>
							</tr>
							<tr>
								<td>Diagnóstico: </td>
								<td>' . $row['Diagnostico'] . '</td>
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
	



	public function delete_consulta($IdConsulta)
	{
		$sql = "DELETE FROM consultas WHERE IdConsulta=$IdConsulta;";
		if ($this->con->query($sql)) {
			echo $this->_message_ok("ELIMINÓ");
		} else {
			echo $this->_message_error("eliminar");
		}
	}

		

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


} // FIN SCRPIT
?>