<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?= ROOT ?>/public/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
</head>
<body>
    <header>
    <?php if($_SESSION['isLogged']){ ?>
        <div class="header-logout text-right"><i class="fas fa-sign-out-alt mr-2"></i>Logout</div>
    <?php } ?>
        <div class="header-title">Simple todo lists</div>
        <div class="header-subtitle">From ruby garage</div>
        <div class="header-subtitle header-success__message"></div>
        <div class="header-subtitle header-errors__message"></div>
    </header>