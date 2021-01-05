<?php
include_once 'index.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">

    <title>Document</title>
</head>
<body>
<h1>Success</h1>

<!--//FORMOS DUOMENYS-->

<div class="container color">
    <div>Dėkojame už Jūsų žinutę, <?php print $name; ?>!</div>
    <div class="inside-container"><i>Jūsų pateikta informacija:</i>
        <div class="posted-info">Vardas: <?php print $name; ?></div>
        <div>El.pašto adresas: <?php print $email; ?></div>
        <div>Telefono numeris: <?php print $phone; ?></div>

        <div>Skirta: <?php whichDepartament($contact_depart); ?></div>
        <div>Tema: <?php selectParticularSubject($select_subject); ?></div>
        <div>Žinutė: <?php print $message; ?></div>
    </div>
</div>


</body>
</html>

