 <!-- Step 1: Address -->
 <h4>Shipping Address</h4>
 <input type="hidden" name="next_step" value="1">
 <div class="row mb-3">
     <div class="col-md-6">
         <label class="form-label">First Name</label>
         <input type="text" class="form-control" disabled value="<?= oldValue('first_name', $ses->user('first_name')) ?>">
     </div>
     <div class="col-md-6">
         <label class="form-label">Last Name</label>
         <input type="text" class="form-control" disabled value="<?= oldValue('last_name', $ses->user('last_name')) ?>">
     </div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6">
         <label class="form-label">Email</label>
         <input type="email" class="form-control" disabled value="<?= oldValue('email', $ses->user('email')) ?>">
     </div>
     <div class="col-md-6">
         <label class="form-label">Phone</label>
         <input type="tel" class="form-control" disabled value="<?= oldValue('phone', $ses->user('phone')) ?>">
     </div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6">
         <label class="form-label">Address</label>
         <input type="text" class="form-control" name="address" value="<?= oldValue('address', $ses->get('address') ?? '') ?>">
         <?= showError($errors, 'address') ?>
     </div>
     <div class="col-md-6">
         <label class="form-label">City</label>
         <input type="text" class="form-control" name="city" value="<?= oldValue('city', $ses->get('city') ?? '') ?>">
         <?= showError($errors, 'city') ?>
     </div>
 </div>
 <div class="row mb-3">
     <div class="col-md-4">
         <label class="form-label">State</label>
         <input type="text" class="form-control" name="state" value="<?= oldValue('state', $ses->get('state') ?? '') ?>">
         <?= showError($errors, 'state') ?>
     </div>
     <div class="col-md-4">
         <label class="form-label">Zip</label>
         <input type="text" class="form-control" name="zip" value="<?= oldValue('zip', $ses->get('zip') ?? '') ?>">
         <?= showError($errors, 'zip') ?>
     </div>
     <div class="col-md-4">
         <label class="form-label">Country</label>
         <input type="text" class="form-control" name="country" disabled value="<?= oldValue('country', $country->country) ?>">
         <?= showError($errors, 'country') ?>
     </div>
 </div>
 <button type="submit" class="btn btn-primary">Next</button>