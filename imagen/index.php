<?php
header('Content-type: image/png');

class makeImage
{
    public static function CargarDatosaImagen($estado, $casos, $nacional, $semaforo, $nombre, $id)
    {
        try {
            
            $imgs = sprintf('covid/imagen/%s', str_replace(".png", ($id.".png"), $nombre));

            if (file_exists($imgs)) {
                //header('Content-type: image/png');

                // Load And Create Image From Source
                $our_image = imagecreatefrompng($imgs);

                // Set Path to Font File
                $font_path = 'fonts/static/Karla-Bold.ttf';

                // Set Text to Be Printed On Image
                $text1 = "Casos de COVID";
                $text2 = sprintf("en %s", $estado);
                $text3 = $casos;
                $text4 = "Casos de COVID";
                $text5 = "a nivel Nacional";
                $text6 = $nacional;

                $r1 = 0;
                $g1 = 0;
                $b1 = 0;

                $r2 = 0;
                $g2 = 0;
                $b2 = 0;

                switch ($semaforo) {
                    case "verde";
                    case "amarillo";
                        $r1 = 0;
                        $g1 = 0;
                        $b1 = 0;

                        $r2 = 0;
                        $g2 = 130;
                        $b2 = 255;
                        break;
                    case "naranja":
                    case "rojo":
                        $r1 = 0;
                        $g1 = 0;
                        $b1 = 0;

                        $r2 = 255;
                        $g2 = 255;
                        $b2 = 255;
                        break;
                    default:
                        $r1 = 0;
                        $g1 = 0;
                        $b1 = 0;

                        $r2 = 255;
                        $g2 = 255;
                        $b2 = 255;
                        break;
                }

                $size1 = 22;
                $angle1 = 0;
                $left1 = 50;
                $top1 = 120;

                $white_color = imagecolorallocate($our_image, $r1, $g1, $b1);
                imagettftext($our_image, $size1, $angle1, $left1, $top1, $white_color, $font_path, $text1);

                $size2 = 22;
                $angle2 = 0;
                $left2 = 50;
                $top2 = 155;

                $white_color = imagecolorallocate($our_image, $r1, $g1, $b1);
                imagettftext($our_image, $size2, $angle2, $left2, $top2, $white_color, $font_path, $text2);

                $size2 = 60;
                $angle2 = 0;
                $left2 = 50;
                $top2 = 230;

                $white_color = imagecolorallocate($our_image, $r2, $g2, $b2);
                imagettftext($our_image, $size2, $angle2, $left2, $top2, $white_color, $font_path, $text3);


                $size1 = 22;
                $angle1 = 0;
                $left1 = 50;
                $top1 = 330;

                $white_color = imagecolorallocate($our_image, $r1, $g1, $b1);
                imagettftext($our_image, $size1, $angle1, $left1, $top1, $white_color, $font_path, $text4);

                $size1 = 22;
                $angle1 = 0;
                $left1 = 50;
                $top1 = 370;

                $white_color = imagecolorallocate($our_image, $r1, $g1, $b1);
                imagettftext($our_image, $size1, $angle1, $left1, $top1, $white_color, $font_path, $text5);


                $size1 = 70;
                $angle1 = 0;
                $left1 = 50;
                $top1 = 470;

                $white_color = imagecolorallocate($our_image, $r2, $g2, $b2);
                imagettftext($our_image, $size1, $angle1, $left1, $top1, $white_color, $font_path, $text6);

                $nombre = sprintf("covid/imagen/%s", str_replace(".png", ($id.".png"), $nombre));

                imagepng($our_image, $nombre);

                echo sprintf("La imagen se creo en %s\n", $nombre);

                // Clear Memory
                imagedestroy($our_image);
            }
            else{
                echo "El archivo ".$nombre." no existe \n";
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function CrearTransparencia($semaforo, $nombre, $id)
    {
        try {
            $r = 0;
            $g = 0;
            $b = 0;

            switch ($semaforo) {
                case "verde":
                    $r = 137;
                    $g = 238;
                    $b = 133;
                    break;
                case "amarillo":
                    $r = 255;
                    $g = 213;
                    $b = 0;
                    break;
                case "naranja":
                    $r = 255;
                    $g = 128;
                    $b = 0;
                    break;
                case "rojo":
                    $r = 255;
                    $g = 0;
                    $b = 76;
                    break;
            }

            $a = sprintf("covid/%s", $nombre);

            if (file_exists($a)) {

                //Cargamos la dos imagenes ambas de 128x128px
                $img1 = imagecreatefrompng($a);

                //Creamos el lienzo con el tamaño para contener las 2 imagenes, y le asignamos transparencia
                $image = imagecreatetruecolor(831, 548);
                imagesavealpha($image, true);
                $alpha = imagecolorallocatealpha($image, $r, $g, $b, 50);
                imagefill($image, 0, 0, $alpha);

                //Guardamos y leberamos el objeto
                $c = sprintf('covid/newimg/%s.png', $semaforo);
                imagepng($image, $c);

                $marca = imagecreatefrompng($c);

                imagecopy($img1, $marca, 0, 0, 0, 0, 831, 548);
                imagepng($img1, 'covid/imagen/' . str_replace(".png", ($id.".png"), $nombre));

                imagedestroy($image);
                imagedestroy($img1);

                echo "Se creo la transparencia \n";
            }
            else{
                echo "El archivo ".$nombre." no existe \n";
            }

            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function listFiles($directorio){ //La función recibira como parametro un directorio
        if (is_dir($directorio)) { //Comprovamos que sea un directorio Valido
            if ($dir = opendir($directorio)) {//Abrimos el directorio

                while (($archivo = readdir($dir)) !== false){ //Comenzamos a leer archivo por archivo

                    if ($archivo != '.' && $archivo != '..'){//Omitimos los archivos del sistema . y ..

                        $nuevaRuta = $directorio.$archivo.'/';//Creamos unaruta con la ruta anterior y el nombre del archivo actual 

                            if (is_dir($nuevaRuta)) { //Si la ruta que creamos es un directorio entonces:
                                echo $nuevaRuta."\n"; //Imprimimos la ruta completa resaltandola en negrita
                                    
                                self::listFiles($nuevaRuta);//Volvemos a llamar a este metodo para que explore ese directorio.

                            } else { //si no es un directorio:
                                echo $archivo . "\n"; //simplemente imprimimos el nombre del archivo actual
                            }
                    }

                }//finaliza While

                closedir($dir);//Se cierra el archivo
            }
        }else{//Finaliza el If de la linea 12, si no es un directorio valido, muestra el siguiente mensaje
            echo "No Existe el directorio\n";
        }				
    }//Fin de la Función	 

}

//makeImage::listFiles("./covid");

// /img/covid/imagen/....
$imagenes = json_decode(json_encode(array(
    ["id" => "20201222", "estado" => "Aguascalientes", "imagen" => "img-covid-aguasc.png", "semaforo" => "verde", "casos" => "20000", "nacional" => "10,000,000"],
    ["id" => "20201222", "estado" => "Baja California Norte", "imagen" => "img-covid-bcn.png", "semaforo" => "amarillo", "casos" => "40000", "nacional" => "20,000,000"],
    ["id" => "20201222", "estado" => "Baja California Sur", "imagen" => "img-covid-bcs.png", "semaforo" => "rojo", "casos" => "60000", "nacional" => "30,000,000"],
    ["id" => "20201222", "estado" => "Campeche", "imagen" => "img-covid-campeche.png", "semaforo" => "naranja", "casos" => "80000", "nacional" => "40,000,000"],
)));

$getData = @file_get_contents("https://api.pre.codigopostal.com/api/v1/get/updateinfoimage");
$jsonData = json_decode($getData);

//var_dump($jsonData); exit;

foreach ($jsonData as $item) {
    // Primero Creamos la transparencia y se la agregamos a la imagen
    makeImage::CrearTransparencia($item->semaforo, $item->imagen, $item->id);
}

foreach ($jsonData as $item) {
    // Segundo Tomamos la imagen con la transparencia y le agregamos los datos
    makeImage::CargarDatosaImagen($item->estado, $item->casos, $item->nacional, $item->semaforo, $item->imagen, $item->id);
}


