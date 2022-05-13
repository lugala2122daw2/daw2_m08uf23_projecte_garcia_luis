<?php
require 'vendor/autoload.php';

use Laminas\Ldap\Attribute;
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
        <title>Modificar Usuari</title>
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
		<h2>Modificar Usuari</h2>
    </header>
        <div>
            <?php
            if ($_POST['method'] == "PUT") {
                if ($_POST['uid'] && $_POST['ou'] && $_POST['radioValue'] && $_POST['nouContingut']) {

                    $atribut = $_POST['radioValue'];
                    $nou_contingut = $_POST['nouContingut'];

                    $uid = $_POST['uid'];
                    $ou = $_POST['ou'];
                    $dn = 'uid=' . $uid . ',ou=' . $ou . ',dc=fjeclot,dc=net';

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
                    $entrada = $ldap->getEntry($dn);
                    if ($entrada) {
                        Attribute::setAttribute($entrada, $atribut, $nou_contingut);
                        $isModificat = true;
                        $ldap->update($dn, $entrada);
                        echo "Modificat correctament<br />";
                    } else {
                        echo "<b>No existeix</b><br />";
                    }
                }
            } else {
            ?>
                <div>
                    <div>
                        <form action="http://zend-lugala/projecte/modificacio.php" method="POST" autocomplete="off">
                            <br><input type="text" name="method" value="PUT" class="noMostrar"><br>
                            <input type="text" name="ou" placeholder="Unitat Organitzativa" required /><br><br>
                            <input type="text" name="uid" placeholder="Usuari" required /> <br><br>
                            <input type="radio" name="radioValue" value="uidNumber" /><span class="formLabel">UID Number</span><br>
                            <input type="radio" name="radioValue" value="gidNumber" /><span class="formLabel">GID Number</span><br>
                            <input type="radio" name="radioValue" value="homeDirectory" /><span class="formLabel">Directori Personal</span><br>
                            <input type="radio" name="radioValue" value="loginShell" /><span class="formLabel">Shell</span><br>
                            <input type="radio" name="radioValue" value="cn" /><span class="formLabel">CN</span><br>
                            <input type="radio" name="radioValue" value="sn" /><span class="formLabel">SN</span><br>
                            <input type="radio" name="radioValue" value="givenName" /><span class="formLabel">Given Name</span><br>
                            <input type="radio" name="radioValue" value="postalAddress" /><span class="formLabel">Adreça Postal</span><br>
                            <input type="radio" name="radioValue" value="mobile" /><span class="formLabel">Mòbil</span><br>
                            <input type="radio" name="radioValue" value="telephoneNumber" /><span class="formLabel">Telèfon Fixe</span><br>
                            <input type="radio" name="radioValue" value="title" /><span class="formLabel">Títol</span><br>
                            <input type="radio" name="radioValue" value="description" /><span class="formLabel">Descripció</span><br><br>
                            <input type="text" name="nouContingut" placeholder="Contigut a modificar" required /><br><br>
                            <input type="submit" class="button" value="Modificar"/><br>
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