<?php use App\Core\Helper;?>
<div class="row justify-content-center mt-4">
    <div class="col-6">
    <h2>Add Students</h2>
    </div>
    <div class="col-3 text-end">
        <a href="<?= Helper::getSiteUrl()?>students/" class="btn btn-danger">Back</a>
    </div>
</div>
<div class="row justify-content-center">
<div class="col-9">
<form method="POST" class="needs-validation" action="" enctype="multipart/form-data" novalidate>
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" required class="form-control col-10" value="" id="name" />
    <?php if (!empty($errors["name"][0])):?><div class="invalid-feedback d-block"><?= $errors["name"][0]?></div><?php endif;?>
  </div>
  <div class="mb-3">
    <label for="grade" class="form-label">Grade</label>

    <select id="grade" name="grade" class="form-select" required>
        <?php foreach ($gride_data AS $key=>$val):?>
        <option value="<?= $key?>"><?= $val?></option>
        <?php endforeach;?>
    </select>
    <?php if (!empty($errors["grade"][0])):?><div class="invalid-feedback d-block"><?= $errors["grade"][0]?></div><?php endif;?>
  </div>
  <div class="mb-3">
    <label for="phoro" class="form-label">Photo</label>
    <input type="file" name="photo" class="form-control" value="" id="photo" />
    <?php if (!empty($errors["image"][0])):?><div class="invalid-feedback d-block"><?= $errors["image"][0]?></div><?php endif;?>
  </div>
  <div class="mb-3">
    <label for="dob" class="form-label">Date of Birth</label>
    <input type="date" name="dob" value="<?= date("Y-m-d")?>" max="<?= date("Y-m-d") ?>" class="form-control" id="dob" required>
    <?php if (!empty($errors["dob"][0])):?><div class="invalid-feedback d-block"><?= $errors["dob"][0]?></div><?php endif;?>
  </div>
  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" name="address" class="form-control" id="address" required>
    <?php if (!empty($errors["address"][0])):?><div class="invalid-feedback d-block"><?= $errors["address"][0]?></div><?php endif;?>
  </div>
  <div class="mb-3">
    <label for="city" class="form-label">City</label>
    <input type="text" name="city" class="form-control" id="city" required>
    <?php if (!empty($errors["city"][0])):?><div class="invalid-feedback d-block"><?= $errors["city"][0]?></div><?php endif;?>
  </div>
  <div class="mb-3">
    <label for="country" class="form-label">Country</label>
    <input type="text" name="country" class="form-control" id="country" required>
    <?php if (!empty($errors["country"][0])):?><div class="invalid-feedback d-block"><?= $errors["country"][0]?></div><?php endif;?>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>

<?php
$GLOBAL_JS .= <<<JS
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})()
JS;
Helper::setGlobalVariable("GLOBAL_JS", $GLOBAL_JS);
?>