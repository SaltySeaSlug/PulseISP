<div class="content-wrapper">
  <section class="content">
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title mt-2"><i class="fad fa-list mr-2"></i><?= trans('edit_language') ?></h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/languages'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i><?= trans('language_list') ?></a>
        </div>
      </div>
      <div class="card-body">
        <?php echo form_open(base_url('admin/languages/edit/'.$language['id']), 'class="form-horizontal"' )?>
          <div class="form-group">
            <label for="group_name" class="col-sm-3 control-label"><?= trans('display_name') ?></label>

            <div class="col-sm-12">
              <input type="text" name="name" value="<?=$language['name']?>" class="form-control" id="group_name" placeholder="e.g., English">
            </div>
          </div>

          <div class="form-group">
            <label for="group_name" class="col-sm-3 control-label"><?= trans('directory_name') ?></label>

            <div class="col-sm-12">
              <input type="text" name="short_name" value="<?=$language['short_name']?>" class="form-control" id="group_name" placeholder="e.g., EN">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="<?= trans('update_language') ?>" class="btn btn-primary pull-right">
            </div>
          </div>

        <?php echo form_close(); ?>
      </div>
    </div>
  </section> 
</div>


 <script>
    $("#language").addClass('active');
  </script>
