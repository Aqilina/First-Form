<?php

//pridėtumėt porą funkcijų laukeliams validuoti, pvz ne daugiau kaip 50 simbolių,
//arba slaptažodžiui nemažiau kaip 6 simboliai, galite sugalvoti ir savo validatorių

//CONTACT CUSTOMER SUPPORT
//3 x inputs - text, email, tel.;
//3 x radio inputs;
//2 options to select;
//textarea;

//Submitint galima tik būtinai užpildžius:
//Vardas, el. paštas arba telefonas, vienas iš radio inputų.

var_dump($_POST);

$name = $email = $phone = $radio = $contact_depart = $select_subject = $message = '';
$nameErr = $emailErr = $phoneErr = $radioErr = $contact_departErr = $select_subject = $messageErr = '';


//////////////////////////////////////////////
///           VALIDACIJOS
///////////////////////////////////////////////


//AR FORMA ISSIUSTA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //NAME VALIDACIJA
    if (empty($_POST['user_name'])) {
        $nameErr = 'Prašome įrašyti vardą';
    } else {
        $name = cleanInput($_POST['user_name']);
        if (strlen($name) > 25) {
            $nameErr = 'Vardas neturi būti ilgesnis nei 25 raidės';
            //PATIKRINTI AR IVESTA REIKSME YRA TIK RAIDES IR TARPAI - RegEx
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = 'Vardą turi sudaryti tik raidės';
        }
    }

    //IVESTI EL. PASTA ARBA TELEFONA; NUMERIO VALIDACIJA
    if (empty($_POST['phone']) && empty($_POST['email'])) {
        $emailErr = 'Prašome nurodyti el. pašto adresą arba telefono numerį';
    } else {
        $email = cleanInput($_POST['email']);
        $phone = cleanInput($_POST['phone']);

        //NEVEIKIA KAIP NORIU:

//        if (empty($_POST['phone']) || $phone !== is_int($phone)) {
//            $phoneErr = 'Prašome įvesti tik skaičius';
//        }

    }

    //RADIO VALIDACIJA
    if (empty($_POST['contact_depart'])) {
        $contact_departErr = 'Prašome pasirinkti skyrių';
    } else {
        $contact_depart = cleanInput($_POST['contact_depart']);
    }

    //SKYRIAUS VALIDACIJA
    if (!empty($_POST['contact_depart'])) {
        $contact_depart = cleanInput($_POST['contact_depart']);
    }

    //TEMOS PRISKYRIMAS KINTAMAJAM
    if (!empty($_POST['select'])) {
        $select_subject = cleanInput($_POST['select']);
    }

    //ZINUTES VALIDACIJA
    if (!empty($_POST['message'])) {
        $message = cleanInput($_POST['message']);
        if (strlen($message) > 20) {
            $messageErr = 'Žinutė negali būti ilgesnė nei 20 raidžių';
        }
    }

    //IDEALIU ATVEJU NUKREIPIA I KITA PSL
//    if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($radioErr)) {
//        //klaidu nera
//        Header('Location: final_form.php');
//    }
}


//--------------------------------------------------------------------------------
//////////////////////////////////////////
//             FUNKCIJOS
//////////////////////////////////////////

function cleanInput($inputText)
{
    $cleanName = htmlspecialchars($inputText);
    $trimmedCleanedText = trim($cleanName);
    return $trimmedCleanedText;
}

//ATVAIZDUOTI ERORAMS
//1. inputo langelio spalva
function outputErrorClass($errorType)
{
    if ($errorType !== '') {
        echo 'error-input-color';
    }
}

//2. parasymas, kad klaida ir taisyk
function showInputError($errorType)
{
    if ($errorType !== '') {
        return "<p class='error-alert'>$errorType</p>";
    }
}

function alertRightSide($errorType)
{
    if ($errorType !== '') {
        return "<p class='error-alert alert-right'>$errorType</p>";
    }
}

//ATVAIZDUOTI RADIO PASIRINKIMAMS
function whichDepartament($depart)
{
    if ($depart === 'sales') {
        print 'Pardavimų skyriui';
    }
    if ($depart === 'administration') {
        print 'Administracijai';
    }
    if ($depart === 'customer_support') {
        print 'Klientų aptarnavimo skyriui';
    }
}

//GRAZUS TEMOS ATVAIZDAVIMAS - BE "NAME"
function selectParticularSubject($subject) {
    if ($subject === 'none') {
        print 'Nenurodyta';
    }
    if ($subject === 'complains') {
        print 'Skundai';
    }
    if ($subject === 'questions') {
        print 'Klausimai';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .container {
            width: 50%;
            margin: 20px auto;
            border: 1px solid black;
            padding: 20px;
        }

        .color {
            background-color: darkorange;
        }

        input, textarea, select {
            padding: 12px 20px;
            margin: 10px 0 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        [type=text], [type=submit], select {
            width: 100%;
        }

        [type=email] {
            width: 49%;
            float: left;
        }

        [type=tel], .phone-alert-right {
            width: 49%;
            float: right;
        }

        [type=radio] {
            margin-right: 5px;
        }

        textarea {
            width: 100%;
            resize: none;
        }

        input[type=submit] {
            width: 33%;
            margin: 0 auto;
            display: block;
            horiz-align: center;
        }

        .inside-container {
            background-color: white;
            margin: 15px 0;
        }

        div {
            margin: 10px 0;
            padding-left: 5px;
        }

        .error-input-color {
            border-color: tomato;
            background-color: #eea99a;
        }

        .error-alert {
            color: tomato;
            font-size: 14px;
            margin: 0 0 10px 0;
            display: inline-block;
        }

        .alert-right {
            width: 49%;
            float: right;
        }
    </style>

    <title>Document</title>
</head>
<body>
<div class="container">
    <form action="index.php" method="post">
        <div>
            <label for="user_name"></label>
            <input class="<?php outputErrorClass($nameErr) ?>" type="text" placeholder="Jūsų vardas" name="user_name">
            <?php echo showInputError($nameErr) ?>
        </div>

        <div>
            <label for="email"></label>
            <input class="<?php outputErrorClass($emailErr) ?>" type="email" placeholder="El. paštas" name="email">

            <label for="phone"></label>
            <input class="<?php outputErrorClass($phoneErr) ?>" type="tel" placeholder="Telefono numeris" name="phone">
            <?php echo showInputError($emailErr) ?>
            <?php echo alertRightSide($phoneErr) ?>
        </div>


        <div>NORIU SUSISIEKTI SU:</div>
        <label for="sales"></label>
        <input type="radio" name="contact_depart" id="sales" value="sales">Pardavimų skyriumi<br>

        <label for="administration"></label>
        <input type="radio" name="contact_depart" id="administration" value="administration">Administracija<br>

        <label for="customer_support"></label>
        <input type="radio" name="contact_depart" id="customer_support" value="customer_support">Klientų aptarnavimo skyriumi<br>
        <?php echo showInputError($contact_departErr) ?>

        <select name="select" id="select">

            <label for="none"></label>
            <option name="select_subject" value="none" >PASIRINKITE TEMĄ</option>

            <label for="complains"></label>
            <option name="select_subject" value="complains" >Skundai</option>

            <label for="questions"></label>
            <option name="select_subject" value="questions" >Klausimai</option>
        </select>

        <textarea name="message" id="" cols="30" rows="10" placeholder="Jūsų žinutė"></textarea>
        <?php echo showInputError($messageErr) ?>

        <input type="submit" name="submit" value="Siųsti">
    </form>
</div>

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
