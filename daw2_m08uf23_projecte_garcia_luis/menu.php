<?php
session_start();
if (isset($_SESSION['admin'])) {
?>
    <!DOCTYPE html>
    <html lang="cat">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menú Prinicpal LDAP</title>
    </head>
    <style>
    header{
    	display:flex;
    	justify-content:space-around;
    }
    </style>

    <body>
    <header>
		<a href="http://zend-lugala/projecte/menu.php"> Inici </a><br>
		<h2>Menú PRINCIPAL</h2>
    </header>
        <div>
                
            <div>
                <br><a href="http://zend-lugala/projecte/visualitzacio.php" >Buscar Usuari</a><br><br>
                <a href="http://zend-lugala/projecte/afegir.php" >Afegir Usuari</a><br><br>
                <a href="http://zend-lugala/projecte/modificacio.php">Modificar Usuari</a><br><br>
                <a href="http://zend-lugala/projecte/esborrar.php">Esborrar Usuari</a><br><br>
            </div>
        </div>
    </body>

    </html>

<?php
} else {
    header("Location: http://zend-lugala/projecte/");
}
?>