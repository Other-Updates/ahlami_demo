<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Events</title>
        <style type="text/css">
            table tr td { padding:8px; }
        </style>
    </head>
    <body style="margin:0px; padding:0px;">
        <div class="container" style="margin:0px auto;">
            <table  cellpadding="0px" cellspacing="0px" style="position:relative; width:50%; margin-top:20px; mrgin:0px auto;  margin: 0 auto;">
                <tr>
                    <td style="background-color:#026670; text-align:center;"><img src="<?php echo base_url() . 'themes/event/assets/images/logo1.png'; ?>" style="width:180px;"></td>
                </tr>
            </table>
            <table border="3" bordercolor="#026670" cellpadding="0px" cellspacing="0px" style="position:relative; width:50%; margin-top:10px; margin:0px auto;">
                <tr>
                    <td>
                        <table cellpadding="0px" cellspacing="0px" style="width:100%;">
                            <tr>
                                <td colspan="3" style="border-bottom:1px solid #ccc; color:#026670; padding-left:28px;">You are invited for <b><?php echo ucfirst($event[0]['event_name']); ?></b> Event.</td>
                            </tr>
                            <tr>
                                <td style="padding-top:10px; padding-left:2px;; font-weight:bold; width:47%;">Event Type:</td>
                                <td width="5%"></td>
                                <td style="padding-top:10px; padding-left:2px;; font-weight:bold;">Event Name:</td>
                            </tr>
                            <tr>
                                <td style="padding-top:4px; border:1px solid #ccc;"><?php echo ucfirst($event[0]['event_type_name']); ?></td>
                                <td width="5%"></td>
                                <td style="padding-top:4px; border:1px solid #ccc;"><?php echo ucfirst($event[0]['event_name']); ?></td>
                            </tr>
                            <tr>
                                <td style="padding-top:10px; padding-left:2px;font-weight:bold; ">Event Start Date:</td>
                                <td width="5%"></td>
                                <td style="padding-top:10px; padding-left:2px;font-weight:bold;">Event End Date:</td>
                            </tr>
                            <tr>
                                <td style="padding-top:4px; border:1px solid #ccc;"><?php echo date('d-M-Y H:i A', strtotime($event[0]['from_date'])); ?></td>

                                <td width="5%"></td>
                                <td style="padding-top:4px; border:1px solid #ccc;"><?php echo date('d-M-Y H:i A', strtotime($event[0]['to_date'])); ?></td>
                            </tr>
                            <tr>
                                <td style="padding-top:10px; padding-left:2px;font-weight:bold; ">Total Invited Members:</td>
                                <td width="5%"></td>
                                <td style="padding-top:10px; padding-left:2px;font-weight:bold;">Event Location:</td>
                            </tr>
                            <tr>
                                <?php
                                $invited_members = json_decode($event_invited_members[0]['invited_members'], TRUE);
                                ?>
                                <td style="padding-top:4px; border:1px solid #ccc;"><?php echo count($invited_members); ?></td>

                                <td width="5%"></td>
                                <td style="padding-top:4px; border:1px solid #ccc;"><?php echo 'Kayalpattinam' ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding-top:5px;"><b>Event Invitations</b></td>
                            </tr>
                            <?php
                            if (isset($event_invitations) && !empty($event_invitations)) {
                                $s = 1;
                                foreach ($event_invitations as $value) {
                                    ?>
                                    <tr>
                                        <td colspan="6" style="padding-top:10px;  border:1px solid #ccc;">
                                            <a  onclick="window.location.href = '<?php echo base_url() . 'attachments/events/invitations/' . $value['file_name']; ?>'"   href="javascript:void(0);"><img src="<?php echo base_url() . 'attachments/events/invitations/' . $value['file_name']; ?>"  style="width: 100%; height: 150px; border: 1px #ccc solid; padding: 3px;" title="<?php echo $value['file_name']; ?>" ></a>
                                            <a href="<?php echo base_url() . 'attachments/events/invitations/' . $value['file_name']; ?>" class="btn btn-info btn-xs" title="download" target="_blank" download="" style="margin-top: 6px;padding: 7px;"><i class="icon-download"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $s++;
                                }
                            } else {
                                ?>
                                <tr><td colspan="3">No Invitations found</td></tr>
                                <?php
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if (!empty($event_dynamic_fields)) {
                            foreach ($event_dynamic_fields as $field_id => $fieldInfo) {
                                $dynamic_data = $event_dynamic_values[$field_id];
                                $fieldData = json_decode($fieldInfo['field_data'], TRUE);
                                $fieldID = (!empty($dynamic_data['field_id'])) ? $dynamic_data['field_id'] : $fieldInfo['id'];
                                $fieldType = $fieldData['type'];
                                $fieldLabel = $fieldData['label'];
                                $fieldValue = $dynamic_data['value'];
                                ?>
                                <div class="col-md-6">
                                    <strong><?php echo $fieldLabel; ?>:</strong>
                                    <p><label><?php echo $fieldValue; ?></label></p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <table  cellpadding="0px" cellspacing="0px" style="position:relative; width:50%; margin-top:5px; margin:0px auto;">
                <tr>
                    <td colspan="3" bgcolor="#797979" style="color:white; height:40px;">Copyright &copy; 2019 Events, All rights reserved.</td>
                </tr>
            </table>
        </div>
    </body>
</html>
