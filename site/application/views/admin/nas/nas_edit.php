  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title mt-2"> <i class="fad fa-pencil"></i>
              &nbsp; <?= trans('edit_nas') ?> </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/nas'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('nas_list') ?></a>
            <a href="<?= base_url('admin/nas/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_nas') ?></a>
          </div>
        </div>
        <div class="card-body">
   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>
           
            <?php echo form_open(base_url('admin/nas/edit/'.$nas['id']), 'class="form-horizontal"' )?> 
              <div class="form-group">
                <label for="shortname" class="col-md-2 control-label">Name</label>

                <div class="col-md-12">
                  <input type="text" name="shortname" value="<?= $nas['shortname']; ?>" class="form-control" id="shortname" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="nasname" class="col-md-2 control-label">IP Address</label>

                <div class="col-md-12">
                  <input type="text" name="nasname" value="<?= $nas['nasname']; ?>" class="form-control" id="nasname" placeholder="">
                </div>
              </div>

              <div class="form-group">
                <label for="nasidentifier" class="col-md-2 control-label">Identifier</label>

                <div class="col-md-12">
                  <input type="text" name="nasidentifier" value="<?= $nas['nasidentifier']; ?>" class="form-control" id="nasidentifier" placeholder="">
                </div>
              </div>

              <div class="form-group">
                <label for="type" class="col-md-2 control-label">Type</label>

                <div class="col-md-12">
                  <input type="type" name="type" value="<?= $nas['type']; ?>" class="form-control" id="type" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="ports" class="col-md-2 control-label">Ports</label>
                <div class="col-md-12">
                  <input type="number" name="ports" value="<?= $nas['ports']; ?>" class="form-control" id="ports" placeholder="">
                </div>
              </div>
 <div class="form-group">
                <label for="secret" class="col-md-2 control-label">Secret</label>
                <div class="col-md-12">
                  <input type="text" name="secret" value="<?= $nas['secret']; ?>" class="form-control" id="secret" placeholder="">
                </div>
              </div>


              <!--<div class="form-group">
                <label for="role" class="col-md-2 control-label"><?= trans('status') ?></label>

                <div class="col-md-12">
                  <select name="status" class="form-control">
                    <option value=""><?= trans('select_status') ?></option>
                    <option value="1" <?= ($nas['is_active'] == 1)?'selected': '' ?> >Active</option>
                    <option value="0" <?= ($nas['is_active'] == 0)?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div>-->
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update NAS" class="btn btn-primary pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
        </div>
          <!-- /.box-body -->
      </div>  
    </section> 
  </div>
