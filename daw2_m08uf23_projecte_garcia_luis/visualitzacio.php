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
        <title>Cerca d'Usuaris</title>
        <style>
            header{
            	display:flex;
            	justify-content:space-around;
            }
        </style>
    </head>

    <body>
    <header>
		<a href="http://zend-lugala/projecte/menu.php"> Inici </a><br>
		<h2>Veure Usuari</h2>
    </header>
        <div>
            <?php
            if ($_GET['usr'] && $_GET['ou']) {
                $domini = 'dc=fjeclot,dc=net';
                $opcions = [
                    'host' => 'zend-lugala',
                    'username' => "cn=admin,$domini",
                    'password' => 'fjeclot',
                    'bindRequiresDn' => true,
                    'accountDomainName' => 'fjeclot.net',
                    'baseDn' => 'dc=fjeclot,dc=net',
                ];
                $ldap = new Ldap($opcions);
                $ldap->bind();
                $entrada = 'uid=' . $_GET['usr'] . ',ou=' . $_GET['ou'] . ',dc=fjeclot,dc=net';
                $usuari = $ldap->getEntry($entrada);

                echo '<table>
            <thead>
                <tr>
                    <th scope="col" colspan="2">' . $usuari["dn"] . '</th>
                </tr>
                <tr>
                    <th scope="col">Atribut</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>';
                foreach ($usuari as $atribut => $dada) {
                    if ($atribut != "dn") {
                        //echo $atribut . ": " . $dada[0] . '<br>';
                        //echo "<td>" . $value['cn'][0] . "</td>";
                        echo '<tr>';
                        echo '<td>' . $atribut . '</td>';
                        echo "<td>" . $dada[0] . "</td>";
                        echo '</tr>';
                        echo '<tr>';
                    }
                }if (!$usuari){
                    echo "<b>No existeix</b><br />";
                }else{
                echo "</tbody>
        </table>";}
            } else {
            ?>
                <div>
                    <div>
                        <form action="http://zend-lugala/projecte/visualitzacio.php" method="GET" autocomplete="off">
                            <h5>Cerca Usuari</h5>
                           	<input type="text" name="ou" placeholder="Unitat Organitzativa" required /><br><br>
                            <input type="text" name="usr" placeholder="Usuari" required /><br><br>
                            <input type="submit" class="button" value="Cercar Usuari" /><br>
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