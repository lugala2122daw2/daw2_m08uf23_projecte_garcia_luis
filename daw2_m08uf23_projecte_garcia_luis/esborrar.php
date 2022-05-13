<?php
require 'vendor/autoload.php';

use Laminas\Ldap\Ldap;

session_start();
if (isset($_SESSION['admin'])) {
    ini_set('display_errors', 0);
    ?>
    <!DOCTYPE html>
    <html lang="cat">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Esborrar Usuari</title>
        <style>
            .noMostrar{
            	display:none;
            }
            header{
            	display:flex;
            	justify-content:space-around;
            }
        </style>
  	</head>    

    <body>
    <header>
		<a href="http://zend-lugala/projecte/menu.php"> Inici </a><br>
		<h2>Esborrar Usuari</h2>
    </header>
        <div>
            <?php
            if ($_POST['method'] == "DELETE") {
                if ($_POST['usr'] && $_POST['ou']) {

                    $uid = $_POST['usr'];
                    $unorg = $_POST['ou'];
                    $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';

                    $opcions = [
                        'host' => 'zend-lugala',
                        'username' => 'cn=admin,dc=fjeclot,dc=net',
                        'password' => 'fjeclot',
                        'bindRequiresDn' => true,
                        'accountDomainName' => 'fjeclot.net',
                        'baseDn' => 'dc=fjeclot,dc=net',
                    ];

                    $ldap = new Ldap($opcions);
                    $ldap->bind();
                    $isEsborrat = false;
                    try {
                        if ($ldap->delete($dn)) echo "<b>Esborrat Correctament</b><br>";
                    } catch (Exception $e) {
                        echo "<b>No existeix</b><br>";
                    }
                }
            } else {
            ?>
                <div>
                    <div>
                        <form action="http://zend-lugala/projecte/esborrar.php" method="POST" autocomplete="off">
                            <input type="text" name="method" value="DELETE" class="noMostrar"><br><br>
                            <input type="text" name="ou" placeholder="Unitat Organitzativa" required /><br><br>
                            <input type="text" name="usr" placeholder="Usuari" required /><br><br>
                            <input type="submit" class="button" value="Esborrar" /><br>
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location: http://zend-lugala/projecte/");
}
?>