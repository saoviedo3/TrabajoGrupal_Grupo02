<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<?php
class especialidad
{
	private $IdEsp;
	private $Descripcion;
	private $Dias;
	private $Franja_HI;
	private $Franja_HF;
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
                        <li class="nav-item active">
						<a class="nav-link" href="../Especialidades/index.php">Especialidades<span class="sr-only">(current)</span></a>						
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



	public function update_especialidad()
	{
		$this->IdEsp = $_POST['IdEsp'];
		$this->Descripcion = $_POST['Descripcion'];
		$this->Dias = $_POST['Dias'];
		$this->Franja_HI = $_POST['Franja_HI'];
		$this->Franja_HF = $_POST['Franja_HF'];

		$sql = "UPDATE especialidades SET
									Descripcion='$this->Descripcion',
									Dias='$this->Dias',
									Franja_HI='$this->Franja_HI',
									Franja_HF='$this->Franja_HF'
                        WHERE IdEsp='$this->IdEsp';";

		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó");
		} else {
			echo $this->_message_error("al modificar");
		}

	}


	//*********************** 3.2 METODO save_vehiculo() **************************************************	

	public function save_especialidad()
	{

		$this->IdEsp = $_POST['IdEsp'];
		$this->Descripcion = $_POST['Descripcion'];
		$this->Dias = $_POST['Dias'];
		$this->Franja_HI = $_POST['Franja_HI'];
		$this->Franja_HF = $_POST['Franja_HF'];


		$sql = "INSERT INTO especialidades VALUES(NULL,
											'$this->Descripcion',
											'$this->Dias',
											'$this->Franja_HI',
											'$this->Franja_HF');";

						
		//echo $sql;
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

	
	public function get_form($IdEsp = NULL)
	{

		if ($IdEsp == NULL) {
			$this->Descripcion = NULL;
			$this->Dias = NULL;
			$this->Franja_HI = NULL;
			$this->Franja_HF =  NULL;

			$flag = "enabled";
			$op = "new";

		} else {

			$sql = "SELECT * FROM especialidades WHERE IdEsp=$IdEsp;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar la especialidad con id= " . $IdEsp;
				echo $this->_message_error($mensaje);
			} else {


				$this->Descripcion = $row['Descripcion'];
				$this->Dias = $row['Dias'];
				$this->Franja_HI = $row['Franja_HI'];
				$this->Franja_HF = $row['Franja_HF'];

				$flag = "disabled";
				$op = "update";
			}
		}


		$html = '
		' . $this->header() . '
				<form name="consulta" method="POST" action="index.php" enctype="multipart/form-data">
					<input type="hidden" name="IdEsp" value="' . $IdEsp . '">
					<input type="hidden" name="op" value="' . $op . '">
					<div class="container">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
			<table class="table table-bordered table-striped table-hover mx-auto" style="max-width: 800px;">
				<thead class="thead-dark">
					<tr>
							<th colspan="2" class="text-center">Datos de la Especilidad</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Especialidad:</td>
								<td><input type="text" name="Descripcion" value="' . $this->Descripcion . '" required></td>
								</tr>
							<tr>
								<td>Días:</td>
								<td><input type="text" name="Dias" value="' . $this->Dias . '" required></td>
							</tr>
							<tr>
								<td>Franja de Hora de Inicio:</td>
								<td><input type="time" name="Franja_HI" value="' . $this->Franja_HI . '" required class="form-control"> </td>
							</tr>							
							<tr>
								<td>Franja de Hora Final:</td>
								<td><input type="time" name="Franja_HF" value="' . $this->Franja_HF . '" required class="form-control"> </td>
							</tr>						
							<tr>
								<th colspan="2" class="text-center"><input type="submit" align="center" name="Guardar" value="GUARDAR" class="btn btn-primary"></th>
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
						<th colspan="10" class="text-center">Especialidades</th>
					</tr>
					<tr>
						<th colspan="10" class="text-center">
							<a href="index.php?d=' . $d_new_final . '" class="btn btn-primary">
								<i class="fas fa-plus"></i> Nuevo
							</a>
						</th>
					</tr>
					<tr>
						<th class="text-center">Especialidad</th>
						<th colspan="3" class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>';
	
		$sql = "SELECT IdEsp, Descripcion
        FROM especialidades ORDER BY IdEsp ASC;";

		$res = $this->con->query($sql);

		while ($row = $res->fetch_assoc()) {
			$d_del = "del/" . $row['IdEsp'];
			$d_del_final = base64_encode($d_del);
	
			$d_act = "act/" . $row['IdEsp'];
			$d_act_final = base64_encode($d_act);
	
			$d_det = "det/" . $row['IdEsp'];
			$d_det_final = base64_encode($d_det);
	

			$html .= '
			<tr>
				<td class="text-center">' . $row['Descripcion'] . '</td>
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

	

	public function get_detail_especialidad($IdEsp)
	{
		$sql = "SELECT IdEsp, Descripcion, Dias, Franja_HI, Franja_HF
        FROM especialidades 
        WHERE IdEsp=$IdEsp;";

		$res = $this->con->query($sql);
	
		if ($res === false) {
			$mensaje = "tratar de editar la especialidad con id= " . $IdEsp;
			echo $this->_message_error($mensaje);
		} else {
			$row = $res->fetch_assoc();
	
			$html = '
				' . $this->header() . '
				<div class="container">
					<table class="table table-bordered table-striped mx-auto" style="max-width: 800px;">
						<thead class="thead-dark">
							<tr>
								<th colspan="2" class="text-center">Datos de la Especilidad</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Descripción: </td>
								<td>' . $row['Descripcion'] . '</td>
							</tr>
							<tr>
								<td>Dias: </td>
								<td>' . $row['Dias'] . '</td>
							</tr>
							<tr>
								<td>Franja de la Hora de Inicio: </td>
								<td>' . $row['Franja_HI'] . '</td>
							</tr>
							<tr>
								<td>Franja de la Hora Final: </td>
								<td>' . $row['Franja_HF'] . '</td>
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
	



	public function delete_especialidad($IdEsp)
	{
		$sql = "DELETE FROM especialidades WHERE IdEsp=$IdEsp;";
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