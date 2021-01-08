<?php

class SizeImagen{

    public static function ValidarImagen($imagen){
        list($width, $height, $type, $attr) = getimagesize($imagen);

        if($height > $width) return false;

        $minHeight = (($width * 60) / 100);

        if($height >= $minHeight){
            
                echo "Ancho: " .$width;
                echo '<br />';
                echo "Alto: " .$height;
                echo '<br />';
                echo "Tipo: " .$type;
                echo '<br />';
                echo "Atributos: " .$attr;
                echo '<p><img src="'.$imagen.'" width="590" height="385"></p>';
            
            return true;
        }
        
        return false;
    }
}

$imagenes = array(
    "imagen/google-fotos.jpg",
    "imagen/img-covid-aguasc.png",
    "imagen/img-covid-bcn.png",
    "imagen/tomar-fotos.jpg",
    "imagen/vender-fotos.jpeg",
    "imagen/c85a.jpg",
    "imagen/1544715674.jpg",
    "imagen/720x300.png",
    "imagen/201dc8.gif",
    "imagen/155933.jpg",
    "imagen/3191172_640px.jpg",
    "imagen/images.jpeg",
    "imagen/images1.jpeg",
);


foreach($imagenes as $item){
    echo SizeImagen::ValidarImagen($item);    
}


