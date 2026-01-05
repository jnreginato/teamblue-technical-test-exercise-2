<?php

declare(strict_types=1);

/** @var array{result: string|null, error: string|null} $viewData */
$result = $viewData['result'];
$error = $viewData['error'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Number Operations</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="container">
    <h1 style="text-align:center;">Operations using addition only</h1>

    <h2>Multiplication</h2>
    <form method="post">
        <input type="hidden" name="action" value="multiply">
        <label><input type="text" name="a" placeholder="First number" required></label>
        <label><input type="text" name="b" placeholder="Second number" required></label>
        <button type="submit">Multiply</button>
    </form>

    <hr>

    <h2>Factorial</h2>
    <form method="post">
        <input type="hidden" name="action" value="factorial">
        <label><input type="number" name="n" placeholder="Number for factorial" min="0" required></label>
        <button type="submit">Calculate factorial</button>
    </form>

    <?php

    if ($result !== null) : ?>
        <div class="result">
            <strong>Result:</strong><br> <?= htmlspecialchars($result) ?>
        </div>
    <?php endif; ?>

    <?php

    if ($error !== null) : ?>
        <div class="error">
            <strong>Error:</strong><br>
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div style="text-align:center; margin-bottom: 20px;">
        <a
            href="/coverage/"
            target="_blank"
            rel="noopener noreferrer"
            class="coverage-link"
        >
            View test coverage report
        </a>
    </div>
</div>

</body>
</html>
