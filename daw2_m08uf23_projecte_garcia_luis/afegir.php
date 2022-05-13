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
        <title>Afegir Usuari</title>
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
		<h2>Afegir Usuari</h2>
    </header>
        <div>
            <?php
            if (
                $_POST['uid'] && $_POST['ou'] && $_POST['uidNumber'] && $_POST['gidNumber'] && $_POST['homeDirectory'] && $_POST['shell']
                && $_POST['cn'] && $_POST['sn'] && $_POST['givenName'] && $_POST['postalAddress'] && $_POST['mobil'] && $_POST['telefon']
                && $_POST['title'] && $_POST['description']
            ) {
                $uid = '' . $_POST['uid'];
                $ou = '' . $_POST['ou'];
                $uidNumber = $_POST['uidNumber'];
                $gidNumber = $_POST['gidNumber'];
                $homeDirectory = '' . $_POST['homeDirectory'];
                $shell = '' . $_POST['shell'];
                $cn = '' . $_POST['cn'];
                $sn = '' . $_POST['sn'];
                $givenName = '' . $_POST['givenName'];
                $postalAddress = '' . $_POST['postalAddress'];
                $mobil = '' . $_POST['mobil'];
                $telefon = '' . $_POST['telefon'];
                $titol = '' . $_POST['title'];
                $descripcio = '' . $_POST['description'];
                $objcl = array('inetOrgPerson', 'organizationalPerson', 'person', 'posixAccount', 'shadowAccount', 'top');

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
                $nova_entrada = [];
                Attribute::setAttribute($nova_entrada, 'objectClass', $objcl);
                Attribute::setAttribute($nova_entrada, 'uid', $uid);
                Attribute::setAttribute($nova_entrada, 'uidNumber', $uidNumber);
                Attribute::setAttribute($nova_entrada, 'gidNumber', $gidNumber);
                Attribute::setAttribute($nova_entrada, 'homeDirectory', $homeDirectory);
                Attribute::setAttribute($nova_entrada, 'loginShell', $shell);
                Attribute::setAttribute($nova_entrada, 'cn', $cn);
                Attribute::setAttribute($nova_entrada, 'sn', $sn);
                Attribute::setAttribute($nova_entrada, 'givenName', $givenName);
                Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
                Attribute::setAttribute($nova_entrada, 'postalAddress', $postalAddress);
                Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
                Attribute::setAttribute($nova_entrada, 'title', $titol);
                Attribute::setAttribute($nova_entrada, 'description', $descripcio);
                $dn = 'uid=' . $uid . ',ou=' . $ou . ',dc=fjeclot,dc=net';
                if ($ldap->add($dn, $nova_entrada)) {
                    echo "Creat correctament <br />";
                }
            } else {
            ?>
                <div>
                    <div>
                        <form action="http://zend-lugala/projecte/afegir.php" method="POST" autocomplete="off">
                            <br><input type="text" name="uid" placeholder="UID" required />
                            <input type="text" name="ou" placeholder="Unitat Organitzativa" required /><br><br>
                            <input type="number" name="uidNumber" placeholder="UID Number" required />
                            <input type="number" name="gidNumber" placeholder="GID Number" required /><br><br>
                            <input type="text" name="homeDirectory" placeholder="Directori Personal" required />
                            <input type="text" name="shell" placeholder="Shell" required /><br><br>
                            <input type="text" name="cn" placeholder="CN" required />
                            <input type="text" name="sn" placeholder="SN" required /><br><br>
                            <input type="text" name="givenName" placeholder="Given Name" required />
                            <input type="text" name="postalAddress" placeholder="Adreça Postal" required /><br><br>
                            <input type="text" name="mobil" placeholder="Número de Telèfon Mòbil" required />
                            <input type="text" name="telefon" placeholder="Número de Telèfon" required /><br><br>
                            <input type="text" name="title" placeholder="Títol" required />
                            <input type="text" name="description" placeholder="Descripció" required /><br><br>
                            <input type="submit" class="button" value="Afegir" /><br>
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