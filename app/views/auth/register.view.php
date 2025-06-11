<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light d-flex align-items-center justify-content-center my-5" ">

    <div class=" card shadow-sm p-4" style="width: 100%; max-width: 500px;">
    <div class="text-center mb-4">
        <div class="text-center mb-4 d-flex justify-content-center align-items-center flex-column">
            <a class="navbar-brand d-flex align-items-center pb-2" href="<?= BASE_URL ?>/">
                <img src="https://cdn.vectorstock.com/i/1000v/43/22/shopping-cart-logo-design-vector-21804322.jpg" alt="Your Logo" width="32" height="32" class="d-inline-block align-text-top me-2">
                <span class="italic fw-4">E-seller</span>
            </a>
            <h4 class="fw-bold">Sign In</h4>
        </div>
        <h4 class="fw-bold">Create an Account</h4>
    </div>

    <form method="POST">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fullname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fullname" name="first_name" value="<?= oldValue('first_name') ?>" placeholder="Enter your First name" />
                <?= showError($errors, 'first_name') ?>
            </div>
            <div class="col-md-6">
                <label for="fullname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="fullname" name="last_name" value="<?= oldValue('last_name') ?>" placeholder="Enter your Last name" />
                <?= showError($errors, 'last_name') ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email address</label>
                <input type="email" value="<?= oldValue('email') ?>" class="form-control" id="email" name="email" placeholder="Enter your email" />
                <?= showError($errors, 'email') ?>
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" value="<?= oldValue('phone') ?>" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" />
                <?= showError($errors, 'phone') ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" name="gender">
                    <option value="">--Select Gender--</option>
                    <option <?= oldSelect('gender', 'male') ?> value="male">Male</option>
                    <option <?= oldSelect('gender', 'female') ?> value="female">Female</option>
                    <option <?= oldSelect('gender', 'other') ?> value="other">Other</option>
                </select>
                <?= showError($errors, 'gender') ?>
            </div>
            <div class="col-md-6">
                <label for="country_id" class="form-label">Country</label>
                <select class="form-select" name="country_id">
                    <option value="">--Select Country--</option>
                    <?php if (!empty($countries)): ?>
                        <?php foreach ($countries as $country): ?>
                            <option <?= oldSelect('country_id', $country->id) ?> value="<?= $country->id ?>"><?= esc($country->country) ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
                <?= showError($errors, 'country_id') ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" value="<?= oldValue('password') ?>" class="form-control" id="password" name="password" placeholder="Create a password" />
                <?= showError($errors, 'password') ?>
            </div>
            <div class="col-md-6">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" value="<?= oldValue('confirm_password') ?>" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" />
                <?= showError($errors, 'confirm_password') ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <div class="text-center mt-3">
        <small>Already have an account? <a href="<?= BASE_URL ?>/login" class="text-decoration-none">Login</a></small>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>