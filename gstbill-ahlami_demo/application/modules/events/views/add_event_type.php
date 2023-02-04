<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/form-builder.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/jquery-ui.min.js"></script>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Add Event Type</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <form name="add_event_type" id="add_event_type" class="form-horizontal" action="<?php echo base_url(); ?>events/event_types/add" method="post" enctype="multipart/form-data">
            <fieldset class="content-group">
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback has-feedback-left">
                                    <label><strong>Event Type Name:</strong></label><span class="req">*</span>
                                    <input type="text" name="event_type[event_type_name]" id="event_type_name" class="form-control required" placeholder="Enter Event Type Name" maxlength="50">
                                    <span class="error_msg"></span>
                                    <div class="form-control-feedback">
                                        <i class="icon-stack"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label><strong>Status:</strong></label><span class="req">*</span>
                                    <select name="event_type[status]" id="status" class="form-control required">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="build-wrap"></div>
                </div>
                <div class="col-md-12 m-t-15">
                    <input type="hidden" name="form_fields[form_fields]" id="form_fields">
                </div>
            </fieldset>
            <div class="row">
                <div class="col-md-6">
                    <div class="text-left">
                        <button type="button" class="btn btn-danger" title="Cancel" onclick="window.location = '<?php echo base_url('events/event_types'); ?>'"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-right">
                        <button type="button" name="submit" class="btn btn-primary submit" title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var fbEditor = document.getElementById('build-wrap');
        var options = {
            dataType: 'json',
            disableFields: ['autocomplete', 'button', 'header', 'hidden', 'paragraph'],
            controlPosition: 'left',
            controlOrder: [
                'text',
                'file',
                'number',
                'date',
                'textarea',
                'select',
                'radio',
                'checkbox'
            ],
            fieldRemoveWarn: true,
            showActionButtons: false
        };
        var formBuilder = $(fbEditor).formBuilder(options);

        $('#event_type_name').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $.ajax({
                    type: 'POST',
                    data: {event_type_name: $.trim($('#event_type_name').val())},
                    url: '<?php echo base_url(); ?>events/event_types/is_event_type_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#event_type_name').closest('div.form-group').find('.error_msg').text('This Event Type Name is not available').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#event_type_name').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });

        $('.submit').click(function (event) {
            event.preventDefault();
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_ele = $(this);
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });

            if (m == 0) {
                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {event_type_name: $.trim($('#event_type_name').val())},
                    url: '<?php echo base_url(); ?>events/event_types/is_event_type_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#event_type_name').closest('div.form-group').find('.error_msg').text('This Event Type Name is not available').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#event_type_name').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }

            if (m == 0) {
                var form_data = formBuilder.actions.getData('json');
                $.ajax({
                    async: false,
                    type: 'POST',
                    url: '<?php echo base_url(); ?>events/event_types/add',
                    data: {
                        form_data: form_data,
                        event_type_name: $('#event_type_name').val(),
                        status: $('#status').val()
                    },
                    success: function (data) {
                        window.location = '<?php echo base_url('events/event_types'); ?>';
                        return false;
                    }
                });
            }
            if (m > 0)
                return false;
        });
    });
</script>

