<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My App</title>
        <meta name="viewport" content="width=device-width user-scalable=no, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>

    <body>
        Home Page
        <hr />
        <?php if (isset($invoice)): ?>
            <h1>Invoice</h1>
            <p>Invoice ID: <?=  $invoice['id'] ?></p>
            <p>Amount: <?= $invoice['amount'] ?></p>
            <p>User: <?= $invoice['full_name'] ?></p>
        <?php endif; ?>
    </body>
</html>