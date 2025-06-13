<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-transparent bg-gradient d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4 d-flex justify-content-center align-items-center flex-column">
            <a class="navbar-brand d-flex align-items-center pb-2" href="<?= BASE_URL ?>/">
                <img src="https://cdn.vectorstock.com/i/1000v/43/22/shopping-cart-logo-design-vector-21804322.jpg" alt="Your Logo" width="32" height="32" class="d-inline-block align-text-top me-2">
                <span class="italic fw-4">E-seller</span>
            </a>
            <h4 class="fw-bold">Sign In</h4>
        </div>
        <?= flashMessage(delete: true); ?>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger text-center" id="flash-message">
                <?= implode('<br>', $errors['general']) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="<?= oldValue('email') ?>"
                    placeholder="Enter your email" />
                <?= showError($errors, 'email') ?>
            </div>


            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    value="<?= oldValue('password') ?>"
                    placeholder="Enter your password" />
                <?= showError($errors, 'email') ?>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="remember" />
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="#" class="small text-decoration-none">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <small>Don't have an account? <a href="<?= BASE_URL ?>/register" class="text-decoration-none">Register</a></small>
        </div>
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