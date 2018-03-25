<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Despliega formulario
function registrositio_form() {
	?>

		<center><form method="POST">
		<h2><em>Formulario de Registro</em></h2>
			<br><br><br><br>
			<?php
			if ( !isset( $_POST['email'] ) ) {
				if ( !file_exists( "email.txt" ) ) {
			?>
			<label for="email">Email Administrador<span><em>(requerido)</em></span></label>
			<input type="email" name="email" class="form-input" /> 
			<br><br>
			<?php
				}
			}
			?>
			<label for="nombre">Nombre del sitio<span><em>(requerido)</em></span></label>
			<input type="text" name="nombre" class="form-input" required/>   
			<br><br>
			<label for="apellido">Direcci&oacute;n sitio <span><em>(requerido)</em></span></label>
			<input type="text" name="url" class="form-input" required/>         
			<br><br>
		<center> <input class="form-btn" name="submit" type="submit" value="Registrar" /></center>
		</p>
		</form></center>

<?php

}

// Procesa el env�o del formulario
function consultar_estadoSitio() {
	if ( isset( $_POST['email'] ) ) {
		if($archivo = fopen("email.txt", "a"))
		{
			if(fwrite($archivo, $_POST['email']))
			{
				echo "Se ha ejecutado correctamente";
				//header("location:versitio.php");
			}
			else
			{
				echo "Ha habido un problema al registrar el sitio";
			}
	 
			fclose($archivo);
		}
	}
	if ( isset( $_POST['url'] ) ) {
		$url = sanitize_text_field( $_POST[ 'url' ] );
		$nombre = sanitize_text_field( $_POST[ 'nombre' ] );
		$site = $_POST["nombre"]."#|#".$_POST["url"].":80";
		$esValido = true;
		$mensajeValidacion ="";
		
		$nombre_archivo = "sitio.txt"; 
		
		   if(file_exists($nombre_archivo))
		   {
			   $mensaje = "Los cambios fueron realizados!!!";
		   }
		
		   else
		   {
			   $mensaje = "Sitio registrado";
		   }
		
		   if($archivo = fopen($nombre_archivo, "a"))
		   {
			   if(fwrite($archivo, $site. "\n"))
			   {
				   echo "Se ha ejecutado correctamente";
				   //header("location:versitio.php");
			   }
			   else
			   {
				   echo "Ha habido un problema al registrar el sitio";
			   }
		
			   fclose($archivo);
		   }

		
	}
}

function consultar_verestadoSitio() {
	$diremail="";
	$message="";
	$nombre_archivo_email = "email.txt"; //variable con el nombre del archivo que vamos a crear
	if ( file_exists( $nombre_archivo_email ) ) {
		$file = fopen($nombre_archivo_email, "r");
		while(!feof($file))
		{
			$diremail = fgets($file);
			/*if($var[0]!="") 
			{	*/			
				echo "<center>Se mandará un email al Administrador: <b>".$diremail."</b></center><br>";
			//}
		}
	}
	$nombre_archivo = "sitio.txt"; //variable con el nombre del archivo que vamos a crear
	if ( file_exists( $nombre_archivo ) ) {
		$file = fopen($nombre_archivo, "r");
		while(!feof($file))
		{
			$var = fgets($file);//. "<br />";
			$returnValue = explode('#|#', $var);
			if($returnValue[0]!="") 
			{
				$oldurl = $returnValue[1];
				$nuevaurl = explode(':',nowww($oldurl));
				/*if ($nuevaurl[1]!='80')
					$nuevaurl[0]=$nuevaurl[0].":".$nuevaurl[1];*/
					//echo $nuevaurl[0]." - ".$nuevaurl[1];
				$evento = "El sitio ".$returnValue[0]." ".$nuevaurl[0]." ".sitiostatus($returnValue[1]). "<br />";
				echo $evento;
				$message = $message."".$evento;
				
			}			
		}
			echo "<script>alert('Se enviará un email a: $diremail con el siguiente mensaje: $message');</script>";
			//"<script language='JavaScript'>alert('Se enviará un email a: '.$diremail.' con el siguiente mensaje: '.$message);<script>";
			//wp_mail( $diremail, "Estado", $message, $headers, $attachments );
			fclose($file);		
		}
	}
	   function nowww($text) {
		$word = array(
		"http://" => "",
		 "www." => "",
		);
	  
		foreach ($word as $bad => $good) {
		  $text = str_replace($bad, $good, $text);
		}
		$oldurl = explode("/", $text);
		$newurl = $oldurl[0];
		$text = "$newurl";
		$text = strip_tags(addslashes($text));
		return $text;
	  }
	//url que queremos saber si esta up o down
	   //$url = "http://localhost:8089";
	   function sitiostatus($url) {
  
	   $site = nowww("$url"); 
	   $check = @fsockopen($site, 80); 
	
	   if ($check) { 
		  return "Online";  
		//echo "la pagina $site esta online"; 
	   } 
	   else { 
		  return "Offline";
		  //echo "la pagina $site esta caida"; 
	   }
	  }



// Despliega la configuraci�n de la p�gina
function controlsitios_display_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">

		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<?php registrositio_form(); ?>
		<?php consultar_estadoSitio(); ?>
		<?php consultar_verestadoSitio(); ?>
		
	</div>

<?php

}
