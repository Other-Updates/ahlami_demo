<?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<link href="<?php echo $theme_path; ?>/assets/css/sweetalert.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/sweet.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/sweetalert.min.js"></script>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage General Setting

        </h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <?php echo form_open_multipart('masters/setting/edit/' . $setting[0]['id'], 'name="edit_setting" id="edit_setting" class="form-horizontal"'); ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>Payment Gateway Username</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="setting[payment_gateway_username]" value="<?php echo $setting[0]['payment_gateway_username']; ?>" class="form-control form-align" id="contact_mail" style="margin-bottom:10px;"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>Payment Gateway Password</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="setting[payment_gateway_password]" value="<?php echo $setting[0]['payment_gateway_password']; ?>"class="form-control form-align" id="copy_right" style="margin-bottom:10px;"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>SMS Gateway Username</strong></label>
                <div class="col-sm-8">
                    <input  name="setting[sms_gateway_username]" value="<?php echo $setting[0]['sms_gateway_username']; ?>"class="form-control form-align" id="site_address" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>SMS Gateway Password</strong></label>
                <div class="col-sm-8">
                    <input  name="setting[sms_gateway_password]" value="<?php echo $setting[0]['sms_gateway_password']; ?>"class="form-control form-align" id="site_address" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>Googlemap API Key</strong></label>
                <div class="col-sm-8">
                    <input  name="setting[googlemap_api_key]" value="<?php echo $setting[0]['googlemap_api_key']; ?>"class="form-control form-align" id="googlemap_api_key" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>Unlock Charge</strong></label>
                <div class="col-sm-8">
                    <input  name="setting[unlock_charge]" value="<?php echo $setting[0]['unlock_charge']; ?>"class="form-control form-align" id="site_address" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>Vatt(%)</strong></label>
                <div class="col-sm-8">
                    <input  name="setting[vatt]" value="<?php echo $setting[0]['vatt']; ?>"class="form-control form-align" id="site_address" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>From Mail</strong></label>
                <div class="col-sm-8">
                    <input  name="setting[from_mail]" value="<?php echo $setting[0]['from_mail']; ?>"class="form-control form-align" id="site_address" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>From Mail</strong></label>
                <div class="col-sm-8">
                    <input  name="setting[from_mail]" value="<?php echo $setting[0]['from_mail']; ?>"class="form-control form-align" id="site_address" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
    <?php $locations = ($setting[0]['current_location']) ? unserialize($setting[0]['current_location']) : '';
        $setting[0]['latitude'] = ($locations) ? $locations['latitude'] : '';
        $setting[0]['longitude'] = ($locations) ? $locations['longitude'] : '';
    ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>Latitude</strong></label>
                <div class="col-sm-8">
                    <input  name="latitude" value="<?php echo $setting[0]['latitude']; ?>"class="form-control form-align" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-group">
            <div class="form-group has-feedback ">
                <label  class="col-sm-4"><strong>Longitude</strong></label>
                <div class="col-sm-8">
                    <input  name="longitude" value="<?php echo $setting[0]['longitude']; ?>"class="form-control form-align" style="margin-bottom:10px;">
                </div>
            </div>
        </div>
    </div>
</table>
<div class="row" style="margin-bottom:10px;">
    <!--<div class="col-md-3"></div>-->
    <div class="col-md-12">
        <div class="col-md-12">
            <button type="submit" class="btn btn-success submit pull-right"  title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('events/dashboard'); ?>'"  title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>

        </div>
    </div>
</div>
<?php echo form_close(); ?>

</div>

