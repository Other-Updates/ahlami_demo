<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<?php
if ($this->session->flashdata('success')) {
    $success_message = $this->session->flashdata('success');
    ?>
    <div class="session_msg">
        <div class="alert alert-success no-border">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
            <span class="text-semibold">Success! </span><?php echo $success_message; ?>
        </div>
    </div>
    <?php
}
?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Import Members</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <form action="<?php echo $this->config->item('base_url'); ?>members/import_members" enctype="multipart/form-data" name="import_members" id="import_members" method="post">
            <fieldset class="content-group">
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label><strong>Attachment:</strong></label>
                                    <input type="file" name="member_data" id="member_data" class="form-control">
                                    <span class="error_msg"></span>
                                    <div class="form-control-feedback">
                                        <i class="icon-upload4"></i>
                                    </div>
                                </div>
                                <div>
                                    <a href="<?php echo $this->config->item('base_url') . 'attachment/csv/sample_member.csv'; ?>" title="Sample Import File" download><i class="icon icon-download4"></i> Click here</a> to download sample format file for import members (.CSV)
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label><strong>Skip Rows:</strong></label>
                                    <input type="text" name="skip_rows" id="skip_rows" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div >
                <?php
                if (($this->session->flashdata('file_upload'))) {
                    $message = $this->session->flashdata('file_upload');
                    ?>
                    <?php if ($message) { ?>
                        <label style="font-weight:bold;margin-left:6px;margin-top:3px;">Validation Results</label>
                        <p style="background-color: pink;padding: 9px 0px 6px 25px;"><span style="color:red;"class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;&nbsp; Data Validation is failed.Please fix errors and re-upload the file</p>
                    <?php } ?>
                    <div class="hvscroll">
                        <table style="width:100%;">
                            <tbody>
                                <?php
                                if (!empty($message)) {
                                    $s = 1;
                                    foreach ($message as $val) {
                                        ?>
                                        <tr>
                                            <td width="5%"><?php echo $s ?>.&nbsp;</td>
                                            <td><?php echo $val ?></td>
                                        </tr>
                                        <?php
                                        $s++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>

            </div>


            <div class="row">
                <!--                <div class="col-md-6">
                                    <div class="text-left">
                                        <button type="button" class="btn btn-danger" id="cancel" onclick="window.location = '<?php echo base_url('users/user_types'); ?>'"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                                    </div>
                                </div>-->
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('members'); ?>'" title="Cancel" style="float:left;"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                        <button type="submit" name="submit"  id="import" style="margin-top: 5px;" class="btn btn-primary submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#import').click(function () {
        var member_data = $('#member_data').val();
        if (member_data == '') {
            $("#error_msg").text("please select your file");
            return false;
        }
    });
</script>
<style>
    #error_msg {
        color: red;
    }
    tbody tr td {
        background-color:pink;
    }
    .hvscroll {
        height: auto;
        overflow-y: auto;
        width: 100%;
        overflow-x:auto;
    }
</style>