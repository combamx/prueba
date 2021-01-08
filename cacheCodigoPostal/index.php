<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

class Cache
{
    public static $Inicio;
    public static $Fin;

    public static $urlHome = array(
        "https://codigopostal.com/"
    );

    public static $urlCopos = array(
        "https://codigopostal.com/ciudad-de-mexico/cuauhtemoc/roma-condesa",
        "https://codigopostal.com/ciudad-de-mexico/cuauhtemoc/centro-cdmx",
        "https://codigopostal.com/puebla/san-pedro-cholula/cholula",
        "https://codigopostal.com/puebla/puebla/puebla-centro",
        "https://codigopostal.com/jalisco/guadalajara/guadalajara-centro",
        "https://codigopostal.com/jalisco/guadalajara/jardines-de-la-cruz",
        "https://codigopostal.com/jalisco/guadalajara/magaña",
        "https://codigopostal.com/guanajuato/irapuato/irapuato-centro",
        "https://codigopostal.com/guanajuato/celaya/celaya-centro",
        "https://codigopostal.com/guanajuato/leon/leon-centro",
    );

    public static $urlEstados = array(
        "https://codigopostal.com/guanajuato",
        "https://codigopostal.com/guanajuato/leon",
        "https://codigopostal.com/guanajuato/celaya",
        "https://codigopostal.com/guanajuato/guanajuato",
        "https://codigopostal.com/guanajuato/san-luis-de-la-paz",
        "https://codigopostal.com/guanajuato/celaya/capitales-de-europa",
        "https://codigopostal.com/guanajuato/san-miguel-de-allende",
    );

    public static $urlDetalle = array(
        "https://codigopostal.com/guanajuato/san-luis-de-la-paz/37900/atacan-a-balazos-a-seis-hombres-dentro-de-bar-en-san-luis-de-la-paz-mueren-tres",
        "https://codigopostal.com/guanajuato/san-luis-de-la-paz/37900/activan-alerta-amber-por-desaparicion-de-menor-en-guanajuato",
        "https://codigopostal.com/guanajuato/leon/leon-centro/37000/violencia-no-cesa-con-crecimiento-economico-ahi-esta-guanajuato-amlo",
        "https://codigopostal.com/guanajuato/leon/las-joyas/37669/roban-kinder-en-leon-se-llevaron-hasta-las-tazas-del-bano",
        "https://codigopostal.com/sonora/hermosillo/83070/hospitalizan-por-covid-19-a-monsea-or-ulises-maca-asa",
        "https://codigopostal.com/guanajuato/salamanca/36863/clausuran-feria-en-el-coecillo-para-evitar-contagios-de-covid-19",
        "https://codigopostal.com/puebla/puebla/puebla-centro/72000/hasta-10-mil-pesos-de-multa-a-los-vendedores-ambulantes-en-puebla",
        "https://codigopostal.com/guanajuato/leon/leon-centro/37000/radha-govinda-atrevete-a-probar-comida-vegetariana-en-leon",
        "https://codigopostal.com/chiapas/29000/chiapas-suma-ya-8-228-casos-y-1-198-muertos",
        "https://codigopostal.com/chihuahua/31000/chihuahua-suma-ya-36-032-casos-y-4-387-muertos",
        "https://codigopostal.com/ciudad-de-mexico/1000/ciudad-de-mexico-suma-ya-320-251-casos-y-16-385-muertos",
        "https://codigopostal.com/coahuila-de-zaragoza/25000/coahuila-de-zaragoza-suma-ya-48-772-casos-y-4-119-muertos",
        "https://codigopostal.com/colima/28000/colima-suma-ya-7-832-casos-y-795-muertos",
        "https://codigopostal.com/durango/34000/durango-suma-ya-24-893-casos-y-1-521-muertos",
        "https://codigopostal.com/guanajuato/36000/guanajuato-suma-ya-81-433-casos-y-5-198-muertos",
    );

    public static $urlPaginado = array(
        "http://codigopostal.com/guanajuato/leon?page=1",
        "http://codigopostal.com/guanajuato/leon?page=2",
        "http://codigopostal.com/guanajuato/leon?page=3",
        "http://codigopostal.com/guanajuato/leon?page=4",
        "http://codigopostal.com/guanajuato/leon?page=5",
        "http://codigopostal.com/guanajuato/leon?page=6",
        "http://codigopostal.com/guanajuato/leon?page=7",
        "http://codigopostal.com/guanajuato/leon?page=8",
        "http://codigopostal.com/guanajuato/leon?page=9",
    );

    function __construct()
    {
    }

    public static function DB()
    {
        $dbh = null;

        try {
            $dsn = "mysql:host=127.0.0.1;dbname=cacheCopo";
            $user = "root";
            $password = "";

            $dbh = new PDO($dsn, $user, $password);

            return $dbh;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function LimpiarSaltosLinea($cadena)
    {
        return trim(preg_replace('/\s+/', ' ', $cadena));
    }

    public static function TiempoEjecucion($Inicio, $Fin)
    {
        $f1 = new DateTime($Inicio);
        $f2 = new DateTime($Fin);

        $d = $f1->diff($f2);

        return $d->format('%H:%I:%S');
    }

    public static function RemplazaCaracteresEspeciales($str)
    {
        $unwanted_array1 = array("À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï");
        $unwanted_array2 = array("&#192;", "&#193;", "&#194;", "&#195;", "&#196;", "&#197;", "&#198;", "&#199;", "&#200;", "&#201;", "&#202;", "&#203;", "&#204;", "&#205;", "&#206;", "&#207;", "&#224;", "&#225;", "&#226;", "&#227;", "&#228;", "&#229;", "&#230;", "&#231;", "&#232;", "&#233;", "&#234;", "&#235;", "&#236;", "&#237;", "&#238;", "&#239;");

        str_replace($unwanted_array1, $unwanted_array2, $str);

        return $str;
    }

    public static function BuscarUrlCache($url){
        try{
            $dbh = self::DB();

            $query = sprintf("SELECT id, url, estatus, tipo FROM caches c WHERE c.url='%s' LIMIT 1;", $url);

            $stmt = $dbh->query($query);

            // Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
            $row = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $row = json_decode(json_encode($row));

            $cantidad = count($row);

            if($cantidad > 0){
                return $row[0];
            }
            else{
                return false;
            }

        }catch (\PDOException $ex) {
            echo $ex->getMessage();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function CargarHomeCache()
    {
        $query = null;
        $id = 0;
        $cantidad = 0;
        $estatus = 200;

        try {
            self::$Inicio = date("H:i:s");
            $a = self::$urlHome;

            $dbh = self::DB();

            foreach ($a as $item) {
                $query = sprintf("SELECT * FROM caches c WHERE c.url='%s';", $item);

                $stmt = $dbh->query($query);

                // Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
                $row = $stmt->fetchAll(PDO::FETCH_OBJ);
                $cantidad = count($row);

                $getData = @file_get_contents($item);
                $getData = self::RemplazaCaracteresEspeciales($getData);
                $getData = self::LimpiarSaltosLinea($getData);

                $getData = htmlspecialchars($getData, ENT_QUOTES);

                if ($getData == "") {
                    $estatus = 404;
                }

                self::$Fin = date("H:i:s");

                if ($cantidad == 0) {

                    $query = sprintf("INSERT INTO cacheCopo.caches(url, contenido, tipo, estatus) VALUES('%s', '%s', 1, %s);", trim($item), addslashes($getData), $estatus);


                    $file = "insert".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);


                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se agrego el registro " . $item . "\n";
                    } else {
                        echo "No se agrego el registro " . $item . "\n";
                    }
                } else {

                    foreach ($row as $i) {
                        $id = $i->id;
                    }

                    $query = sprintf("UPDATE cacheCopo.caches SET contenido='%s', update_at=NOW(), estatus=%s WHERE id=%s;", addslashes($getData), $estatus, $id);

                    $file = "update".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);

                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se actualizo el registro " . $item . "\n";
                    } else {
                        echo "No se actualizo el registro " . $item . "\n";
                    }
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function CargarDetalleNotaCache($actualiza = false)
    {
        $query = null;
        $id = 0;
        $cantidad = 0;
        $estatus = 200;

        try {
            self::$Inicio = date("H:i:s");
            $a = self::$urlDetalle;

            $dbh = self::DB();

            foreach ($a as $item) {
                $query = sprintf("SELECT * FROM caches c WHERE c.url='%s';", $item);

                $stmt = $dbh->query($query);

                // Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
                $row = $stmt->fetchAll(PDO::FETCH_OBJ);
                $cantidad = count($row);

                $getData = @file_get_contents($item);
                $getData = self::RemplazaCaracteresEspeciales($getData);
                $getData = self::LimpiarSaltosLinea($getData);

                $getData = htmlspecialchars($getData, ENT_QUOTES);

                if ($getData == "") {
                    $estatus = 404;
                }

                self::$Fin = date("H:i:s");

                if ($cantidad == 0) {

                    $query = sprintf("INSERT INTO cacheCopo.caches(url, contenido, tipo, estatus) VALUES('%s', '%s', 2, %s);", trim($item), addslashes($getData), $estatus);

                    $file = "insert".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);


                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se agrego el registro " . $item . "\n";
                    } else {
                        echo "No se agrego el registro " . $item . "\n";
                    }
                } else {

                    if ($actualiza) {
                        foreach ($row as $i) {
                            $id = $i->id;
                        }

                        $query = sprintf("UPDATE cacheCopo.caches SET contenido='%s', update_at=NOW(), estatus=%s WHERE id=%s;", addslashes($getData), $estatus, $id);

                        $file = "update".date("Ymd").".sql";
                        $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                        fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                        fclose($fh);


                        $stmt = $dbh->prepare($query);
                        if ($stmt->execute()) {
                            echo "Se actualizo el registro " . $item . "\n";
                        } else {
                            echo "No se actualizo el registro " . $item . "\n";
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function CargarCoposCache()
    {
        $query = null;
        $id = 0;
        $estatus = 200;

        try {
            self::$Inicio = date("H:i:s");
            $a = self::$urlCopos;

            $dbh = self::DB();

            foreach ($a as $item) {
                $query = sprintf("SELECT c.id, c.url FROM caches c WHERE c.url='%s';", $item);

                $stmt = $dbh->query($query);

                // Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
                $row = $stmt->fetchAll(PDO::FETCH_OBJ);
                $cantidad = count($row);

                $getData = @file_get_contents($item);
                $getData = self::RemplazaCaracteresEspeciales($getData);
                $getData = self::LimpiarSaltosLinea($getData);

                $getData = htmlspecialchars($getData, ENT_QUOTES);

                if ($getData == "") {
                    $estatus = 404;
                }

                self::$Fin = date("H:i:s");

                if ($cantidad == 0) {

                    $query = sprintf("INSERT INTO cacheCopo.caches(url, contenido, tipo, estatus) VALUES('%s', '%s', 3, %s);", trim($item), addslashes($getData), $estatus);

                    $file = "insert".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);

                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se agrego el registro " . $item . "\n";
                    } else {
                        echo "No se agrego el registro " . $item . "\n";
                    }
                } else {
                    foreach ($row as $i) {
                        $id = $i->id;
                    }

                    $query = sprintf("UPDATE cacheCopo.caches SET contenido='%s', update_at=NOW(), estatus=%s WHERE id=%s;", addslashes($getData), $estatus, $id);

                    $file = "update".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);

                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se actualizo el registro " . $item . "\n";
                    } else {
                        echo "No se actualizo el registro " . $item . "\n";
                    }
                }
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function CargarEstadosNotaCache()
    {
        $query = null;
        $id = 0;
        $cantidad = 0;
        $estatus = 200;

        try {
            self::$Inicio = date("H:i:s");
            $a = self::$urlEstados;

            $dbh = self::DB();

            foreach ($a as $item) {
                $query = sprintf("SELECT * FROM caches c WHERE c.url='%s';", $item);

                $stmt = $dbh->query($query);

                // Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
                $row = $stmt->fetchAll(PDO::FETCH_OBJ);
                $cantidad = count($row);

                $getData = @file_get_contents($item);
                $getData = self::RemplazaCaracteresEspeciales($getData);
                $getData = self::LimpiarSaltosLinea($getData);

                $getData = htmlspecialchars($getData, ENT_QUOTES);

                if ($getData == "") {
                    $estatus = 404;
                }

                self::$Fin = date("H:i:s");

                if ($cantidad == 0) {

                    $query = sprintf("INSERT INTO cacheCopo.caches(url, contenido, tipo, estatus) VALUES('%s', '%s', 4, %s);", trim($item), addslashes($getData), $estatus);

                    $file = "insert".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);


                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se agrego el registro " . $item . "\n";
                    } else {
                        echo "No se agrego el registro " . $item . "\n";
                    }
                } else {
                    foreach ($row as $i) {
                        $id = $i->id;
                    }

                    $query = sprintf("UPDATE cacheCopo.caches SET contenido='%s', update_at=NOW(), estatus=%s WHERE id=%s;", addslashes($getData), $estatus, $id);

                    $file = "update".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);

                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se actualizo el registro " . $item . "\n";
                    } else {
                        echo "No se actualizo el registro " . $item . "\n";
                    }
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function CargarPaginadoCache()
    {
        $query = null;
        $id = 0;
        $cantidad = 0;
        $estatus = 200;

        try {
            self::$Inicio = date("H:i:s");
            $a = self::$urlPaginado;

            $dbh = self::DB();

            foreach ($a as $item) {
                $query = sprintf("SELECT * FROM caches c WHERE c.url='%s';", $item);

                $stmt = $dbh->query($query);

                // Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
                $row = $stmt->fetchAll(PDO::FETCH_OBJ);
                $cantidad = count($row);

                $getData = @file_get_contents($item);
                $getData = self::RemplazaCaracteresEspeciales($getData);
                $getData = self::LimpiarSaltosLinea($getData);

                $getData = htmlspecialchars($getData, ENT_QUOTES);

                if ($getData == "") {
                    $estatus = 404;
                }

                self::$Fin = date("H:i:s");

                if ($cantidad == 0) {

                    $query = sprintf("INSERT INTO cacheCopo.caches(url, contenido, tipo, estatus) VALUES('%s', '%s', 5, %s);", trim($item), addslashes($getData), $estatus);

                    $file = "insert".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);

                    $stmt = $dbh->prepare($query);
                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se agrego el registro " . $item . "\n";
                    } else {
                        echo "No se agrego el registro " . $item . "\n";
                    }
                } else {
                    foreach ($row as $i) {
                        $id = $i->id;
                    }

                    $query = sprintf("UPDATE cacheCopo.caches SET contenido='%s', update_at=NOW(), estatus=%s WHERE id=%s;", addslashes($getData), $estatus, $id);

                    $file = "update".date("Ymd").".sql";
                    $fh = fopen($file, 'a+') or die("Se produjo un error al crear el archivo");
                    fwrite($fh, ($query . PHP_EOL)) or die("No se pudo escribir en el archivo");
                    fclose($fh);


                    $stmt = $dbh->prepare($query);
                    $stmt = $dbh->prepare($query);
                    if ($stmt->execute()) {
                        echo "Se actualizo el registro " . $item . "\n";
                    } else {
                        echo "No se actualizo el registro " . $item . "\n";
                    }
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function CargarDatosMysql()
    {
        try {
            if (file_exists("insertcopos.sql")) {
                $comando = 'mysql -u root cacheCopo < insertcopos.sql';
                $ultima_linea = system($comando, $retornoCompleto);
                print_r($ultima_linea);
                print_r($retornoCompleto);
            }

            if (file_exists("updatecopos.sql")) {
                $comando = 'mysql -u root cacheCopo < updatecopos.sql';
                $ultima_linea = system($comando, $retornoCompleto);
                print_r($ultima_linea);
                print_r($retornoCompleto);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function EliminarArchivos(){
        if(file_exists("insert.sql"))
            unlink('insert.sql');

        if(file_exists("update.sql"))
            unlink('update.sql');
    }
}

//Cache::EliminarArchivos();
//Cache::CargarHomeCache(); // 1
//Cache::CargarDetalleNotaCache(); // 2
//Cache::CargarCoposCache(); // 3
//Cache::CargarEstadosNotaCache(); // 4
//Cache::CargarPaginadoCache(); // 5

Cache::BuscarUrlCache("https://codigopostal.com/");

//Cache::CargarDatosMysql();
