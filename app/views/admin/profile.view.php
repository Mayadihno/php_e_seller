<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Profile Card -->
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">

                    <!-- Profile Image Placeholder -->
                    <?php if (!empty($user->image)): ?>
                        <img src="<?= BASE_URL ?>/<?= esc($user->image) ?>"
                            alt="Profile Image"
                            class="rounded-circle mb-3"
                            width="150"
                            height="150"
                            style="object-fit: cover;">
                    <?php else: ?>
                        <img src="<?= $user->gender == 'male' ? 'https://avatar.iran.liara.run/public/boy?username=Ash' : 'https://avatar.iran.liara.run/public/55' ?>" alt="Placeholder Image from Placeholder API" class="rounded-circle mb-3" width="150" height="150">
                    <?php endif; ?>

                    <!-- Profile Info -->
                    <h3 class="fw-bold"><?= esc($user->first_name . ' ' . $user->last_name) ?></h3>
                    <p class="text-muted mb-1"><?= esc($user->email) ?></p>
                    <p class="text-muted"><?= esc($user->phone ?? 'No phone number') ?></p>

                    <hr class="my-4">

                    <div class="text-start ps-md-5 pe-md-5">
                        <p><strong>Gender:</strong> <?= esc($user->gender ?? '-') ?></p>
                        <p><strong>Country:</strong> <?= esc($country ?? '-') ?></p>
                        <p><strong>Joined:</strong> <?= get_date($user->date_created) ?></p>
                    </div>

                    <!-- Edit Button -->
                    <a href="<?= BASE_URL ?>/admin/profile/edit/<?= $user->id ?>" class="btn text-white btn-primary mt-4">
                        <i class="fas fa-edit me-1"></i> Edit Profile
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>