<?php
    if(isset($_POST['submit'])){

        if(!$_FILES['archivo']['error'] > 0) {

            if(getimagesize($_FILES['archivo']['tmp_name'])) {

                if($_FILES['archivo']['type'] == 'image/png') {

                    if($_FILES['archivo']['size'] < 1500000) {

                        $fecha="";
                        if(move_uploaded_file($_FILES['archivo']['tmp_name'], 
                                              'imagenes/' . $fecha . $_FILES['archivo']['name'])) {
                            echo "<p>La imagen se guard� con exito.</p>";
                        } else {
                            echo "<p>No pudo guardarse el archivo.</p>";
                        }
                    } else {
                        echo "<p>La imagen no debe ser superior a 500Kb.</p>";
                    }
                } else {
                    echo "<p>El formato de la imagen debe ser PNG.</p>";
                }
            } else {
                echo "<p>No est�s subiendo una imagen.</p>";
            }
        } else {
            echo "<p>Ocurri� un error mientras se sub�a el archivo.</p>";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Upload</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        Archivo:
        <input type="file" name="archivo">
        <br>
        <input type="submit" value="Subir archivo" name="submit">
    </form>
</body>

</html>