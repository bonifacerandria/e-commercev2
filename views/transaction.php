<!DOCTYPE html>
<html>
<head>
    <title>BMOI e-commerce</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

<div class="container">

    <div class="header">
        <img src="/assets/logo.png" class="logo">
        <h2>Résumé de transaction </h2>
    </div>

    <table>
        <tr><td>ID Commande:</td><td><?= htmlspecialchars($data['orderID'] ?? '') ?></td></tr>
        <tr><td>Commerçant:</td><td><?= htmlspecialchars($data['merchant'] ?? '') ?></td></tr>
        <tr><td>Montant:</td><td><?= htmlspecialchars($data['amount'] ?? '') ?></td></tr>
        <tr><td>Devise:</td><td><?= htmlspecialchars($data['currency'] ?? '') ?></td></tr>
        <tr><td>Carte:</td><td><?= htmlspecialchars($data['card'] ?? '') ?></td></tr>
        <tr><td>Date</td><td><?= htmlspecialchars($data['date'] ?? '') ?></td></tr>
    </table>

    <form method="POST">
        <input type="hidden" name="action" value="send_email">

        <input type="email" name="email" placeholder="Email client" required>

        <button type="submit" class="btn-orange">
            Envoyer PDF 
        </button>
    </form>

    <form method="POST">
        <input type="hidden" name="action" value="download_pdf">
        <button class="btn-purple">Télécharger PDF</button>
    </form>

</div>

<script src="/assets/js/app.js"></script>
</body>
</html>