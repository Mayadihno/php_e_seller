<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-transparent bg-gradient d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4 d-flex justify-content-center align-items-center flex-column">
            <a class="navbar-brand d-flex align-items-center pb-2" href="<?= BASE_URL ?>/">
                <img src="https://cdn.vectorstock.com/i/1000v/43/22/shopping-cart-logo-design-vector-21804322.jpg" alt="Your Logo" width="32" height="32" class="d-inline-block align-text-top me-2">
                <span class="italic fw-4">E-seller</span>
            </a>
            <?= flashMessage(delete: true); ?>
            <h4 class="fw-bold">Reset Password</h4>
        </div>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger text-center" id="flash-message">
                <?= implode('<br>', $errors['general']) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    value="<?= oldValue('password') ?>"
                    placeholder="Enter your password" />
                <?= showError($errors, 'password') ?>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="confirm_password"
                    name="confirm_password"
                    value="<?= oldValue('confirm_password') ?>"
                    placeholder="Enter your confirm password" />
                <?= showError($errors, 'confirm_password') ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(() => {
            const flash = document.getElementById("flash-message");
            if (flash) {
                flash.style.transition = "opacity 0.5s ease";
                flash.style.opacity = "0";
                setTimeout(() => flash.remove(), 500);
            }
        }, 5000);
    </script>
</body>

</html>