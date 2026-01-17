<?php
switch ($resultado) {
    case "entrar":
        echo "yes";
        break;
    case "nousuario":
        echo "Usuario o Contraseña Incorrecta";
        break;
    case "noempresa":
        echo "Empresa no registrada";
        break;
    case "nousuarioempresa":
        echo "El Usuario no esta activo para la Empresa";
        break;
    default: "no";
        break;
}
?>