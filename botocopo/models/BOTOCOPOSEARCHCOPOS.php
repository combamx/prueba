<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

class BOTOCOPOSEARCHCOPOS
{
	private $urls = array(
		"http://api.codigopostal.com/api/v1/get/position/lastnews",
		"http://api.codigopostal.com/api/v1/find/guanajuato/leon/leon-centro",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico/cuauhtemoc/roma-condesa",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico/benito-juarez/del-valle",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico/cuauhtemoc/centro-cdmx",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico/miguel-hidalgo/polanco",
		"http://api.codigopostal.com/api/v1/find/puebla/san-pedro-cholula/cholula",
		"http://api.codigopostal.com/api/v1/find/puebla/puebla/puebla-centro",
		"http://api.codigopostal.com/api/v1/find/puebla/atlixco",
		"http://api.codigopostal.com/api/v1/find/jalisco/guadalajara/guadalajara-centro",
		"http://api.codigopostal.com/api/v1/find/jalisco/guadalajara/jardines-de-la-cruz",
		"http://api.codigopostal.com/api/v1/find/jalisco/guadalajara/magaña",
		"http://api.codigopostal.com/api/v1/find/guanajuato/irapuato/irapuato-centro",
		"http://api.codigopostal.com/api/v1/find/guanajuato/celaya/celaya-centro",
		"http://api.codigopostal.com/api/v1/find/guanajuato/salamanca/salamanca-centro",
		"http://api.codigopostal.com/api/v1/find/guanajuato/leon/leon-centro",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico",
		"http://api.codigopostal.com/api/v1/find/puebla",
		"http://api.codigopostal.com/api/v1/find/jalisco",
		"http://api.codigopostal.com/api/v1/find/guanajuato",
		"http://api.codigopostal.com/api/v1/find/queretaro",
		"http://api.codigopostal.com/api/v1/find/baja-california",
		"http://api.codigopostal.com/api/v1/find/oaxaca",
		"http://api.codigopostal.com/api/v1/find/michoacan",
		"http://api.codigopostal.com/api/v1/find/michoacan-de-ocampo/cuitzeo",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico/cuauhtemoc",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico/benito-juarez",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico/miguel-hidalgo",
		"http://api.codigopostal.com/api/v1/find/ciudad-de-mexico/azcapotzalco",
		"http://api.codigopostal.com/api/v1/find/puebla/san-pedro-cholula",
		"http://api.codigopostal.com/api/v1/find/puebla/puebla",
		"http://api.codigopostal.com/api/v1/find/puebla/san-pedro-cholula",
		"http://api.codigopostal.com/api/v1/find/jalisco/guadalajara",
		"http://api.codigopostal.com/api/v1/find/guanajuato/irapuato",
		"http://api.codigopostal.com/api/v1/find/guanajuato/leon",
		"http://api.codigopostal.com/api/v1/find/guanajuato/celaya",
		"http://api.codigopostal.com/api/v1/find/guanajuato/salamanca",
		"http://api.codigopostal.com/api/v1/find/guanajuato/guanajuato",
		"http://api.codigopostal.com/api/v1/find/nuevo-leon",
		"http://api.codigopostal.com/api/v1/find/nuevo-leon/monterrey",
		"http://api.codigopostal.com/api/v1/find/baja-california/tijuana",
		"http://api.codigopostal.com/api/v1/find/sonora/hermosillo",
		"http://api.codigopostal.com/api/v1/find/sonora/cananea",
		"http://api.codigopostal.com/api/v1/find/oaxaca/san-pedro-pochutla",
		"http://api.codigopostal.com/api/v1/find/morelos/ayala",
		"http://api.codigopostal.com/api/v1/find/morelos/tepoztlan",
		"http://api.codigopostal.com/api/v1/find/morelos/ayala",
		"http://api.codigopostal.com/api/v1/find/morelos/tepoztlan",
		"http://api.codigopostal.com/api/v1/find/aguascalientes",
		"http://api.codigopostal.com/api/v1/find/campeche",
		"http://api.codigopostal.com/api/v1/find/chiapas",
		"http://api.codigopostal.com/api/v1/find/chihuahua",
		"http://api.codigopostal.com/api/v1/find/coahuila-de-zaragoza",
		"http://api.codigopostal.com/api/v1/find/colima",
		"http://api.codigopostal.com/api/v1/find/durango",
		"http://api.codigopostal.com/api/v1/find/estado-de-mexico",
		"http://api.codigopostal.com/api/v1/find/hidalgo",
		"http://api.codigopostal.com/api/v1/find/nayarit",
		"http://api.codigopostal.com/api/v1/find/quintana-roo",
		"http://api.codigopostal.com/api/v1/find/san-luis-potosi",
		"http://api.codigopostal.com/api/v1/find/sinaloa",
		"http://api.codigopostal.com/api/v1/find/sonora",
		"http://api.codigopostal.com/api/v1/find/tabasco",
		"http://api.codigopostal.com/api/v1/find/tlaxcala",
		"http://api.codigopostal.com/api/v1/find/veracruz-de-ignacio-de-la-llave",
		"http://api.codigopostal.com/api/v1/find/yucatan",
		"http://api.codigopostal.com/api/v1/find/zacatecas",		
	);

	/*
	"https://api.codigopostal.com/api/v1/jalisco/44100/el-estado-de-jalisco-suma-ya-46-448-casos-de-covid-al-jueves-17-de-diciembre-de-2020?page=1",
	"https://api.codigopostal.com/api/v1/get/newsbymunicipality/72000",
	*/

	function __construct()
	{
	}

	public function start()
	{
		$ErrosArray = array();

		try {
			if (!file_exists('errors')) {
				mkdir('errors', 0777, true);
			}
			
			$getData = @file_get_contents("https://api.pre.codigopostal.com/api/v1/testing");

			if ($getData !== false) {
				$jsonData = json_decode($getData);
				$status = "OK";

				foreach($jsonData->data as $item){
					$url = "https://api.codigopostal.com/api/v1".$item->url;
					$getData = @file_get_contents($url);

					if ($getData !== false) {
						$jsonData = json_decode($getData);

						switch ($jsonData->status) {
							case 200:
								switch ($jsonData->action) {
									case "list":
										if (empty($jsonData->lastnews)) { // IMPORTANTE
											$this->setMessageToLog("ERROR lastnews no cantiene informacion, array vacio, url: " . $url);
											$status = "ERROR (lastnews)";
											array_push($ErrosArray, "ERROR lastnews no cantiene informacion, array vacio, url: " . $url);
										}

										if (empty($jsonData->data)) { // IMPORTANTE
											$this->setMessageToLog("ERROR data no cantiene informacion, array vacio, url: " . $url);
											$status = "ERROR (data)";
											array_push($ErrosArray, "ERROR data no cantiene informacion, array vacio, url: " . $url);
										}

										break;
									case "detail":
										if (empty($jsonData->data)) { // IMPORTANTE
											$this->setMessageToLog("ERROR data no cantiene informacion, array vacio, url: " . $url);
											$status = "ERROR (data)";
											array_push($ErrosArray, "ERROR data no cantiene informacion, array vacio, url: " . $url);
										}
										break;
								}

								break;
							case 301:
								$this->setMessageToLog("ERROR 301 La llamada realiza un status 301, url: " . $url);
								$status = "ERROR";
								array_push($ErrosArray, "ERROR 301 La llamada realiza un status 301, url: " . $url);
								break;
							case 404:
								$this->setMessageToLog("ERROR 404 La llamada realiza un status 404, url: " . $url);
								$status = "ERROR";
								array_push($ErrosArray, "ERROR 404 La llamada realiza un status 404, url: " . $url);
								break;
							case 500:
								break;
						}
					} else {
						echo "ERROR LA LLAMADA REGRESO FALSE (file_get_contents), url: " . $url . "\n";
						$this->setMessageToLog("LA LLAMADA REGRESO FALSE (file_get_contents), url: " . $url);
						array_push($ErrosArray, "ERROR LA LLAMADA REGRESO FALSE (file_get_contents), url: " . $url);
					}

					echo $status . " " . $url . "\n";
					
				}

				foreach ($this->urls as $url) {
					$status = "OK";
					$getData = @file_get_contents($url);

					if ($getData !== false) {
						$jsonData = json_decode($getData);

						switch ($jsonData->status) {
							case 200:
								switch ($jsonData->action) {
									case "list":
										if (empty($jsonData->lastnews)) { // IMPORTANTE
											$this->setMessageToLog("ERROR lastnews no cantiene informacion, array vacio, url: " . $url);
											$status = "ERROR (lastnews)";
											array_push($ErrosArray, "ERROR lastnews no cantiene informacion, array vacio, url: " . $url);
										}

										if (empty($jsonData->data)) { // IMPORTANTE
											$this->setMessageToLog("ERROR data no cantiene informacion, array vacio, url: " . $url);
											$status = "ERROR (data)";
											array_push($ErrosArray, "ERROR data no cantiene informacion, array vacio, url: " . $url);
										}

										break;
									case "detail":
										if (empty($jsonData->data)) { // IMPORTANTE
											$this->setMessageToLog("ERROR data no cantiene informacion, array vacio, url: " . $url);
											$status = "ERROR (data)";
											array_push($ErrosArray, "ERROR data no cantiene informacion, array vacio, url: " . $url);
										}
										break;
									case "position":
										if (empty($jsonData->data)) { // IMPORTANTE
											$this->setMessageToLog("ERROR data Home no cantiene informacion, array vacio, url: " . $url);
											$status = "ERROR (data Home)";
											array_push($ErrosArray, "ERROR data Home no cantiene informacion, array vacio, url: " . $url);
										}
										break;
								}

								break;
							
								case 301:
								$this->setMessageToLog("ERROR 301 La llamada realiza un status 301, url: " . $url);
								$status = "ERROR";
								array_push($ErrosArray, "ERROR 301 La llamada realiza un status 301, url: " . $url);
								break;
							case 404:
								$this->setMessageToLog("ERROR 404 La llamada realiza un status 404, url: " . $url);
								$status = "ERROR";
								array_push($ErrosArray, "ERROR 404 La llamada realiza un status 404, url: " . $url);
								break;
							case 500:
								break;
						}
					} else {
						echo "ERROR LA LLAMADA REGRESO FALSE (file_get_contents), url: " . $url . "\n";
						$this->setMessageToLog("LA LLAMADA REGRESO FALSE (file_get_contents), url: " . $url);
						array_push($ErrosArray, "ERROR LA LLAMADA REGRESO FALSE (file_get_contents), url: " . $url);
					}

					echo $status . " " . $url . "\n";
				}

			} else {
				echo "ERROR LA LLAMADA REGRESO FALSE (file_get_contents), url: https://api.pre.codigopostal.com/api/v1/testing\n";
				$this->setMessageToLog("LA LLAMADA REGRESO FALSE (file_get_contents), url: https://api.pre.codigopostal.com/api/v1/testing");
				array_push($ErrosArray, "ERROR LA LLAMADA REGRESO FALSE (file_get_contents), url: https://api.pre.codigopostal.com/api/v1/testing");
			}

			if (!empty($ErrosArray)) {
				$this->sendEmailError($ErrosArray);
			}
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}

	private function setMessageToLog($message)
	{
		try {
			$name = "errors/log-" . date("Y-m-d_h") . ".txt";
			$myfile = fopen($name, "a+") or die("Unable to open file!");
			$txt = date("Y-m-d H:i:s") . " : " . $message . "\n";

			fwrite($myfile, $txt);
			fclose($myfile);
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}

	private function sendEmailError($ErrosArray)
	{
		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = SMTP::DEBUG_OFF;//SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'omar@am.com.mx';                     // SMTP username
			$mail->Password   = 'AndroidMx@20';                               // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('omar@am.com.mx', 'codigopostal.com Testing');
			$mail->addAddress('jrodriguez@am.com.mx', 'Juan José Rodríguez Rangel');     // Add a recipient
			$mail->addAddress('reynaldo@am.com.mx', 'Reynaldo Verdugo');               // Name is optional
			$mail->addAddress('omar@am.com.mx', 'Omar Cortes Casillas');     // Add a recipient
			//$mail->addReplyTo('info@example.com', 'Information');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			// Attachments
			$nameFile = "errors/log-" . date("Y-m-d_h") . ".txt";
			$mail->addAttachment($nameFile);         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			$Body = "";
			$AltBody = "";
			foreach($ErrosArray as $item){
				$Body .= "<p>".$item."</p>";
				$AltBody .= $item."\n";
			}

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Testing site codigopostal.com';
			$mail->Body    = $Body;
			$mail->AltBody = $AltBody;

			$send = $mail->send();

			if($send !== false){
				echo "Message has been sent\n";
				unlink($nameFile);
				echo "Deleted file ".$nameFile."\n";
			}
			else{
				echo "Message dont has been sent\n";
			}
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
