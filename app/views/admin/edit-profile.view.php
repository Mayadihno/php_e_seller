<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Edit Profile Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Profile</h5>
                </div>

                <?= flashMessage(delete: true); ?>
                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger text-center" id="flash-message">
                        <?= implode('<br>', $errors['general']) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($errors['password_incorrect'])): ?>
                    <div class="alert alert-danger text-center" id="flash-message">
                        <?= implode('<br>', $errors['password_incorrect']) ?>
                    </div>
                <?php endif; ?>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <!-- Profile Image -->
                        <div class="text-center mb-4">
                            <?php if (!empty($user->image)): ?>
                                <img src="<?= BASE_URL ?>/<?= esc($user->image) ?>" alt="Profile Image"
                                    class="rounded-circle" width="150" height="150" style="object-fit: cover;">
                            <?php else: ?>
                                <img src="<?= $user->gender == 'male' ? 'https://avatar.iran.liara.run/public/boy?username=Ash' : 'https://avatar.iran.liara.run/public/55' ?>" alt="Placeholder"
                                    class="rounded-circle" width="150" height="150">
                            <?php endif; ?>
                        </div>

                        <input type="hidden" class="hidden" name="id" value="<?= $user->id ?>">
                        <div class="mb-3">
                            <label class="form-label">Change Profile Picture</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="<?= esc($user->first_name) ?>">
                                <?= showError($errors, 'first_name') ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?= esc($user->last_name) ?>">
                                <?= showError($errors, 'last_name') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?= esc($user->email) ?>">
                            <?= showError($errors, 'email') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?= esc($user->phone ?? '') ?>">
                            <?= showError($errors, 'phone') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="male" <?= $user->gender == 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= $user->gender == 'female' ? 'selected' : '' ?>>Female</option>
                            </select>
                            <?= showError($errors, 'gender') ?>
                        </div>

                        <div class="mb-3">
                            <label for="country_id" class="form-label">Country</label>
                            <select class="form-select" name="country_id">
                                <option value="<?= $country_id ?>"> <?= $country ?></option>
                                <?php if (!empty($countries)): ?>
                                    <?php foreach ($countries as $country): ?>
                                        <option <?= oldSelect('country_id', $country->id) ?> value="<?= $country->id ?>"><?= esc($country->country) ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                            <?= showError($errors, 'country_id') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your Password" />
                            <?= showError($errors, 'password') ?>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>