<?php
$checkout = $ses->get('checkout_data') ?? [];
?>

<!-- Step 2: Dispatch -->
<h4 class="mb-4">Confirm Your Details</h4>

<div class="mb-4 border rounded p-3 bg-light">
    <p><strong>Name:</strong> <?= $ses->user('first_name') ?? '' ?> <?= $ses->user('last_name')  ?? '' ?></p>
    <p><strong>Email:</strong> <?= $ses->user('email')  ?? '' ?></p>
    <p><strong>Phone:</strong> <?= $ses->user('phone')  ?? '' ?></p>
    <p><strong>Address:</strong> <?= $checkout['address'] ?? '' ?>, <?= $checkout['city'] ?? '' ?>, <?= $checkout['state'] ?? '' ?> <?= $checkout['zip'] ?? '' ?></p>
    <p><strong>Country:</strong> <?= $checkout['country'] ?? '' ?></p>
</div>

<h4 class="mb-3">Select a Dispatch Method</h4>
<form method="post">
    <input type="hidden" name="next_step" value="2">
    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="dispatch_method" id="standard" value="standard" required
            <?= ($checkout['dispatch_method'] ?? '') === 'standard' ? 'checked' : '' ?>>
        <label class="form-check-label" for="standard">
            Standard (3-5 days) - <strong><?= formatPrice(8000) ?></strong>
        </label>
    </div>

    <div class="form-check mb-4">
        <input class="form-check-input" type="radio" name="dispatch_method" id="express" value="express"
            <?= ($checkout['dispatch_method'] ?? '') === 'express' ? ' checked ' : '' ?>>
        <label class="form-check-label" for="express">
            Express (1-2 days) - <strong><?= formatPrice(12000) ?></strong>
        </label>
    </div>

    <button type="submit" name="prev_step" class="btn btn-secondary">Back</button>
    <button type="submit" class="btn btn-primary">Next</button>
</form>