<!-- Agrega el enlace al CSS de Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<?php
class recetas
{
	private $IdReceta;
	private $IdConsulta;
	private $IdMedicamento;
	private $Cantidad;
	private $NombreM;
	private $NombreP;
	private $IdMedico;
	private $FechaConsulta;
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
						<li class="nav-item ">
						<a class="nav-link" href="../Consultas/index.php">Consultas</a>						
						</li>
						<li class="nav-item active">
						<a class="nav-link" href="../Recetas/index.php">Recetas <span class="sr-only">(current)</span></a>						
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


	//*********************** 3.1 METODO update_() *****marca*********************************************	

	public function update_receta()
	{
		$this->IdReceta = $_POST['IdReceta'];
		$this->IdConsulta = $_POST['IdConsulta'];
		$this->IdMedicamento = $_POST['IdMedicamento'];
		$this->Cantidad = $_POST['Cantidad'];


		$sql = "UPDATE recetas SET 
									IdConsulta='$this->IdConsulta',
									IdMedicamento='$this->IdMedicamento',
									Cantidad='$this->Cantidad'
								
				WHERE IdReceta=$this->IdReceta;";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó");
		} else {
			echo $this->_message_error("al modificar");
		}

	}


	//*********************** 3.2 METODO save_vehiculo() **************************************************	

	public function save_receta()
	{

		$this->IdConsulta = $_POST['IdConsulta'];
		$this->IdMedicamento = $_POST['IdMedicamento'];
		$this->Cantidad = $_POST['Cantidad'];


		/*
					  echo "<br> FILES <br>";
					  echo "<pre>";
						  print_r($_FILES);
					  echo "</pre>";
				  */
/*
		//exit;
		if (!move_uploaded_file($_FILES['foto']['tmp_name'], $path)) {
			$mensaje = "Cargar la imagen";
			echo $this->_message_error($mensaje);
			exit;
		}
*/
		$sql = "INSERT INTO recetas VALUES(NULL,
											'$this->IdConsulta',
											'$this->IdMedicamento',
											'$this->Cantidad');";
						

		echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("guardó");
		} else {
			echo $this->_message_error("guardar");
		}

	}

	//*************************************** PARTE I ************************************************************


	/*Aquí se agregó el parámetro:  $defecto*/
	private function _get_combo_db($tabla, $valor, $etiqueta, $nombre, $defecto)
	{
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		while ($row = $res->fetch_assoc()) {
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor]) ? '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}
	private function _get_combo_consulta($tabla1, $tabla2, $valor1, $valor2, $etiqueta1, $etiqueta2, $nombre, $defecto, $cuando)
	{
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT a.$valor1, b.$valor2, a.$etiqueta1, b.$etiqueta2 FROM $tabla1 a, $tabla2 b WHERE a.$valor2=b.$valor2 AND a.IdMedico=$cuando;";
		$res = $this->con->query($sql);
		while ($row = $res->fetch_assoc()) {
			//ImpResultQuery($row);

			$html .= ($defecto == $row[$valor1]) ? '<option value="' . $row[$valor1] . '" selected>' . $row[$etiqueta1] . ' ' . $row[$etiqueta2] . '</option>' . "\n" : '<option value="' . $row[$valor1] . '">' . $row[$etiqueta1] . ' ' . $row[$etiqueta2] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}


	public function get_form($IdReceta = NULL)
	{
		$usuario=$_SESSION['usuario'] ;

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

		if ($IdReceta == NULL) {
		
			$this->IdConsulta = NULL;
			$this->IdMedicamento = NULL;
			$this->Cantidad = NULL;

			$flag = "enabled";
			$op = "new";

		} else {

			$sql = "SELECT r.IdConsulta, r.IdMedicamento, r.Cantidad, c.IdConsulta, c.IdPaciente, c.FechaConsulta, p.IdPaciente, P.Nombre as NombreP FROM recetas r, consultas c, pacientes p WHERE c.IdPaciente=p.IdPaciente AND r.IdConsulta=C.IdConsulta AND IdReceta=$IdReceta;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar la agencia con id= " . $IdReceta;
				echo $this->_message_error($mensaje);
			} else {

				// ***** TUPLA ENCONTRADA *****
				/* echo "<br>TUPLA <br>";
				echo "<pre>";
				print_r($row);
				echo "</pre>";
 */

		
				$this->IdConsulta = $row['IdConsulta'];
				$this->NombreP = $row['NombreP'];
				$this->FechaConsulta = $row['FechaConsulta'];
				$this->IdMedicamento = $row['IdMedicamento'];
				$this->Cantidad = $row['Cantidad'];

	
				$flag = "enabled";
				$op = "update";
			}
		}


		$html = '
		'. $this->header() .'	
			<div class="container">
				<form name="recetas" method="POST" action="index.php" enctype="multipart/form-data">
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
					<input type="hidden" name="IdReceta" value="' . $IdReceta . '">
					<input type="hidden" name="op" value="' . $op . '">
					<br>		
  					<table class="table table-bordered table-striped mx-auto" style="max-width: 800px;">
						<thead class="thead-dark">
							<tr>
							<th colspan="2" class="text-center">Recetas</th>
							</tr>
						</thead>
						<tbody>	
							';

								if($op == "new"){
									$html .= '
									<tr>
								<td>Consulta:</td> 

								<td>' . $this->_get_combo_consulta("consultas", "pacientes", "IdConsulta", "IdPaciente", "FechaConsulta", "Nombre", "IdConsulta", $this->IdConsulta, $idm ) . '</td>
								</tr>';
								}else{
									$html .= '
									<tr>
										<td>Consulta:</td>
										<td><input type="text" name="IdConsulta" value="' . $this->NombreP . ' ' . $this->FechaConsulta . '" '. $flag. ' required class="form-control"> </td>
									</tr>
									<input type="hidden" name="IdConsulta" value="' . $this->IdConsulta . '">
									';
								}
	
								$html .= '
									
								<tr>
								<td>Medicamento:</td>
								<td>' . $this->_get_combo_db("medicamentos", "IdMedicamento", "Nombre", "IdMedicamento", $this->IdMedicamento) . '</td>
							</tr>
							<tr>
								<td>Cantidad:</td>
								<td><input type="text" size="6" name="Cantidad" value="' . $this->Cantidad. '" required class="form-control"> </td>
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
		$usuario=$_SESSION['usuario'];
		$d_new = "new/0";                          
		$d_new_final = base64_encode($d_new);       
	
		$html = '
		' . $this->header() . '
		<br>
		<div class="container">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
			<table class="table table-bordered table-striped table-hover mx-auto" style="max-width: 800px;">
				<thead class="thead-dark">
					<tr>
						<th colspan="8" class="text-center">Recetas</th>
					</tr>
					<tr>
						<th colspan="10" class="text-center">
							<a href="index.php?d=' . $d_new_final . '" class="btn btn-primary">
								<i class="fas fa-plus"></i> Nuevo
							</a>
						</th>
					</tr>
					<tr>		
						<th class="text-center">Nombre Paciente</th>
						<th class="text-center">Nombre Medico</th>				
						<th class="text-center">Medicamento</th>			
						<th colspan="3" class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>';
	
		$sql = "SELECT r.IdReceta, r.IdConsulta, r.IdMedicamento, r.Cantidad, m.Nombre as NombreM, c.IdPaciente, p.Nombre as NombreP, c.IdMedico, me.Nombre as NombreME, u.IdUsuario
		FROM recetas r, medicamentos m, consultas c, pacientes p, medicos me, usuarios u 
		WHERE r.IdMedicamento=m.IdMedicamento AND r.IdConsulta=c.IdConsulta AND c.IdPaciente=p.IdPaciente AND c.IdMedico=me.IdMedico AND me.IdUsuario=u.IdUsuario AND u.IdUsuario = ". $usuario . "
		ORDER BY r.IdReceta ASC;";
		$res = $this->con->query($sql);
			
		while ($row = $res->fetch_assoc()) {
	
			$d_del = "del/" . $row['IdReceta'];
			$d_del_final = base64_encode($d_del);
	
			$d_act = "act/" . $row['IdReceta'];
			$d_act_final = base64_encode($d_act);
	
			$d_det = "det/" . $row['IdReceta'];
			$d_det_final = base64_encode($d_det);
	
			$html .= '
			<tr>
				<td class="text-center">' . $row['NombreP'] . '</td>
				<td class="text-center">' . $row['NombreME'] . '</td>
				<td class="text-center">' . $row['NombreM'] . '</td>
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
	


	public function get_detail_receta($IdReceta)
	{
		$sql_receta = "SELECT r.IdReceta, r.IdConsulta, r.IdMedicamento, r.Cantidad, m.Nombre as NombreM, m.Tipo as Tipo, c.IdPaciente, c.FechaConsulta, c.Diagnostico, p.Nombre as NombreP, c.IdMedico, me.Nombre as NombreME 
						FROM recetas r, medicamentos m, consultas c, pacientes p, medicos me 
						WHERE r.IdMedicamento=m.IdMedicamento AND r.IdConsulta=c.IdConsulta AND c.IdPaciente=p.IdPaciente AND c.IdMedico=me.IdMedico AND r.IdReceta = $IdReceta;";
	
		$res_receta = $this->con->query($sql_receta);
	
		$num_receta = $res_receta->num_rows;
	
		if ($num_receta == 0) {
			$mensaje = "Intento de editar la receta con ID= " . $IdReceta;
			echo $this->_message_error($mensaje);
		} else {
			$row_receta = $res_receta->fetch_assoc();  // Obtener la primera fila de resultados
	
			// Construir el HTML
			$html = '
				' . $this->header() . '
			<br>
				<div class="container">
					<table class="table table-bordered table-striped mx-auto" style="max-width: 800px;">
						<thead class="thead-dark">
							<tr>
								<th colspan="2" class="text-center">DATOS DE LA RECETA</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Nombre Paciente: </td>
								<td>' . $row_receta['NombreP'] . '</td>
							</tr>
							<tr>
								<td>Nombre Médico: </td>
								<td>' . $row_receta['NombreME'] . '</td>
							</tr>
							<tr>
								<td>Nombre Medicamento: </td>
								<td>' . $row_receta['NombreM'] . '</td>
							</tr>
							<tr>
								<td>Tipo del Medicamento: </td>
								<td>' . $row_receta['Tipo'] . '</td>
							</tr>
							<tr>
								<td>Fecha de la Consulta: </td>
								<td>' . $row_receta['FechaConsulta'] . '</td>
							</tr>
							<tr>
								<td>Diagnóstico: </td>
								<td>' . $row_receta['Diagnostico'] . '</td>
							</tr>
							<tr>
								<td>Cantidad: </td>
								<td>' . $row_receta['Cantidad'] . '</td>
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
	
	
	
	



	public function delete_receta($IdReceta)
	{
		$sql = "DELETE FROM recetas WHERE IdReceta=$IdReceta;";
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