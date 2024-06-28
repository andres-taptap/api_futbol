<?php
// Definiciones de conexión a la base de datos
define("TAPTAP_DB_HOST", "son-pro-useast-ganesha.cnmxfcili0i5.us-east-1.rds.amazonaws.com");
define("TAPTAP_DB_USER", "latam");
define("TAPTAP_DB_PASSWD", "qtfSnKcXd3LbV3g2");
define("TAPTAP_DB_NAME", "latam_campaigns");
define("TAPTAP_DB_TABLE_FORM", "copaamerica_co202406_matches");

// Función para conectar a la base de datos
function dbConnect() {
    $c = mysqli_connect(TAPTAP_DB_HOST, TAPTAP_DB_USER, TAPTAP_DB_PASSWD, TAPTAP_DB_NAME);
    if (!$c) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
    return $c;
}

// Función para guardar o actualizar datos en la tabla
function saveOrUpdateData($data, $c) {
    $id = mysqli_real_escape_string($c, strip_tags($data['id']));
    $fecha = mysqli_real_escape_string($c, strip_tags($data['fecha']));
    $homeTeam = mysqli_real_escape_string($c, strip_tags($data['homeTeam']));
    $awayTeam = mysqli_real_escape_string($c, strip_tags($data['awayTeam']));
    $homeGoals = mysqli_real_escape_string($c, strip_tags($data['homeGoals']));
    $awayGoals = mysqli_real_escape_string($c, strip_tags($data['awayGoals']));
    $winner = mysqli_real_escape_string($c, strip_tags($data['winner']));
    $homeTeamId = mysqli_real_escape_string($c, strip_tags($data['homeTeamId']));
    $awayTeamId = mysqli_real_escape_string($c, strip_tags($data['awayTeamId']));
    $date = date("Y-m-d H:i:s");

    $query = "INSERT INTO " . TAPTAP_DB_TABLE_FORM . " 
        (id, fecha, homeTeam, awayTeam, homeGoals, awayGoals, winner, homeTeamId, awayTeamId, date) 
        VALUES ('$id', '$fecha', '$homeTeam', '$awayTeam', '$homeGoals', '$awayGoals', '$winner', '$homeTeamId', '$awayTeamId', '$date')
        ON DUPLICATE KEY UPDATE
        fecha = VALUES(fecha),
        homeTeam = VALUES(homeTeam),
        awayTeam = VALUES(awayTeam),
        homeGoals = VALUES(homeGoals),
        awayGoals = VALUES(awayGoals),
        winner = VALUES(winner),
        homeTeamId = VALUES(homeTeamId),
        awayTeamId = VALUES(awayTeamId),
        date = VALUES(date)";

    if (!mysqli_query($c, $query)) {
        return false;
    } else {
        return true;
    }
}

// Función para obtener todos los registros de la tabla y enviar por correo
function sendMailAllReg($c) {
    $query = "SELECT * FROM " . TAPTAP_DB_TABLE_FORM;
    if (!($result = mysqli_query($c, $query))) {
        echo 'Error al ejecutar consulta: ' . mysqli_error($c);
        exit;
    }

    $email = '<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>REGISTRO FORMULARIO</title> 
</head>
<body style="font-family: Helvetica, Arial, sans-serif;font-size: 0.9em;color: #666;max-width: 768px;">
    <p>REGISTRO FORMULARIO</p>
    <table cellpadding="10" cellspacing="0" style="border-color:#CCCCCC">
        <tr style="background-color:#999999; color:#FFFFFF;text-align:center;">
            <td>#</td><td>ID</td><td>Fecha</td><td>Home Team</td><td>Away Team</td><td>Home Goals</td><td>Away Goals</td><td>Winner</td><td>Home Team ID</td><td>Away Team ID</td><td>Date</td>
        </tr>';

    if (mysqli_num_rows($result) > 0) {
        $ind = 0;
        while ($fila = mysqli_fetch_array($result)) {
            $ind++;
            $email .= "<tr>
                <td>$ind</td>
                <td>" . htmlentities($fila['id'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['fecha'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['homeTeam'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['awayTeam'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['homeGoals'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['awayGoals'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['winner'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['homeTeamId'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['awayTeamId'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlentities($fila['date'], ENT_QUOTES, 'UTF-8') . "</td>
            </tr>";
        }
    } else {
        $email .= "<tr><td colspan='11'>No hay registros en la tabla</td></tr>";
    }

    $email .= '</table></body></html>';

    // Envío de correo electrónico (comentado por seguridad)
    // $subject = 'Registro de Formulario';
    // $headers = 'MIME-Version: 1.0' . "\r\n";
    // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // $headers .= 'From: Camilo Quevedo <camilo.quevedo@taptapnetworks.com>' . "\r\n";
    // $to = 'camilo.quevedo@taptapnetworks.com';
    // mail($to, $subject, $email, $headers);

    // Salida del correo electrónico en lugar de mostrar en pantalla
    echo $email;
    exit;
}

// Verificar método de solicitud POST para guardar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c = dbConnect(); // Conectar a la base de datos

    $data = $_POST;

    // Guardar o actualizar datos en la tabla
    if (saveOrUpdateData($data, $c)) {
        sendMailAllReg($c); // Enviar correo con todos los registros después de guardar/actualizar
    } else {
        echo "Error al guardar datos";
    }

    mysqli_close($c); // Cerrar la conexión a la base de datos
} else {
    echo 'Fallo al enviar el formulario';
}
?>
