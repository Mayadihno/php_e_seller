<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow border-0">
                <div class="card-body text-center">

                    <!-- Profile Image -->
                    <?php if (!empty($user->image)): ?>
                        <img src="<?= BASE_URL ?>/<?= esc($user->image) ?>"
                            alt="Profile Image"
                            class="rounded-circle mb-3"
                            width="140"
                            height="140"
                            style="object-fit: cover;">
                    <?php else: ?>
                        <img src="<?= $user->gender == 'male' ? 'https://avatar.iran.liara.run/public/boy?username=' . urlencode($user->first_name) : 'https://avatar.iran.liara.run/public/girl?username=' . urlencode($user->first_name) ?>"
                            class="rounded-circle mb-3"
                            width="140"
                            height="140"
                            alt="Default Profile">
                    <?php endif; ?>

                    <!-- Basic Info -->
                    <h4 class="fw-bold"><?= esc($user->first_name . ' ' . $user->last_name) ?></h4>
                    <p class="text-muted mb-1"><?= esc($user->email) ?></p>
                    <p class="text-muted"><?= esc($user->phone ?? 'No phone number') ?></p>

                    <hr class="my-4">

                    <!-- Detailed Info -->
                    <div class="text-start px-3 px-md-5">
                        <p><strong>Gender:</strong> <?= esc(ucfirst($user->gender) ?? '-') ?></p>
                        <p><strong>Country:</strong> <?= esc($country ?? '-') ?></p>
                        <p><strong>Joined On:</strong> <?= get_date($user->date_created) ?></p>
                    </div>

                    <!-- Edit Button -->
                    <a href="<?= BASE_URL ?>/profile/edit/<?= $user->id ?>" class="btn btn-outline-primary mt-3">
                        <i class="fas fa-edit me-1"></i> Edit Profile
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>