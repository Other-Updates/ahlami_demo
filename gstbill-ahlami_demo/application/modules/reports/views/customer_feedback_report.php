<?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Customer Feedback Report

        <a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse" class=""></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
    <form action="#" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" style="display: block;">    
    	<div class="row">
            <div class="col-md-3">
            	<div class="form-group">
                    <label class="col-sm-12 col-form-label"><strong>Customers:</strong></label>
                    <div class="col-sm-12">
                        <select name="customer" id="customer_id" class="form-control">
                            <option value="">Select Customer</option>
                            <?php if(!empty($customers)):
                                    foreach($customers as $cus): ?>
                                        <option value="<?php echo $cus['id'];?>"><?php echo ucfirst($cus['name']);?></option>
                            <?php   endforeach;
                                  endif;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            	<div class="form-group has-feedback has-feedback-left">
                    <label class="col-sm-12 col-form-label"><strong>From Date:</strong></label>
                    <div class="col-sm-12">
                        <input type="text" id="from_date" data-date="<?php echo date('01/m/Y');?>" class="form-control datepicker" value="<?php echo date('01/m/Y');?>" placeholder="From Date">
                        <span class="error_msg"></span>
                        <div class="form-control-feedback">
                            <i class="icon-calendar3"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group has-feedback has-feedback-left">
                    <label class="col-sm-12 col-form-label"><strong>To Date:</strong></label>
                    <div class="col-sm-12">
                        <input type="text" id="to_date" data-date="<?php echo date('d/m/Y');?>" class="form-control required datepicker" value="<?php echo date('d/m/Y');?>"  placeholder="To Date">
                        <span class="error_msg"></span>
                        <div class="form-control-feedback">
                            <i class="icon-calendar3"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="form-group"><div class="col-sm-12">
            	<label class="col-sm-12 col-form-label"> &nbsp;</label><br />
            	<button type="button" class="btn btn-success submit pull-left search" title="Search"><i class="icon-search4 position-left"></i> Search</button>
                <button type="button" class="btn btn-danger m-l-10 reset" title="Reset"><i class="icon-reset position-left"></i> Reset</button>
                <button type="button" class="btn btn-primary m-l-10 export" title="Export"><i class="icon-download position-left"></i> Export</button>
                </div></div>
            </div>
        </div>
	</form>
    <div class="row">
    	<div class="col-md-12">
        	<table class="table table-bordered table-striped table-hover dataTable" cellspacing="0" idth="100%" id="customer_feedback_datatable">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Trip #</th>
                <th>ScooterO</th>
                <th>Customer</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        	
        </div>
    </div>
</div>
</div>
<div id="export_excel"></div>
<script>
    var table = $('#customer_feedback_datatable').DataTable({
        "processing": true,
        "autoWidth": false,
        "language": {
            processing: "Loading..."
        },
        "serverSide": true,
        "retrieve": true,
        "searching": true,
        "paging": true,
        "bLengthChange": true,
        "ajax": {
                    "url":"<?php echo $this->config->base_url();?>"+"reports/customer_feedback_ajaxlist",
                    "type":"POST",
                    "data": function (data) {
                        data.customer_id=$('#customer_id').val();
                        data.from_date=changeDateFormat($('#from_date').val());
                        data.to_date=changeDateFormat($('#to_date').val());
                    }
                },
        "createdRow": function(row, data, dataIndex) {
            $(row).find('td:eq(0)').attr('data-th', 'S.No');
            $(row).find('td:eq(1)').attr('data-th', 'Trip #');
            $(row).find('td:eq(3)').attr('data-th', 'ScooterO');
            $(row).find('td:eq(4)').attr('data-th', 'Customer');
            $(row).find('td:eq(5)').attr('data-th', 'Feedback');
            
        },
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            { className:"text-center", "targets": [0],"orderable":false },
            { className:"text-center", "targets": [1,2] },
            { className:"text-left", "targets": [3,,4] }
        ],
    });
    $(document).on('click','.search',function(){
        table.ajax.reload();
    });
    $(document).on('click','.reset',function(){
        $('select').val('');
        $('#from_date').val($('#from_date').attr('data-date'));
        $('#to_date').val($('#to_date').attr('data-date'));
        table.ajax.reload();
    });
    $(document).on('click','.export',function(){
        fnExcelReport2();
    });
    function fnExcelReport2()
    {
        var tab_text = "<table id='custom_export' border='5px'><tr width='100px' bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('customer_feedback_datatable'); // id of table
        for (j = 0; j < tab.rows.length; j++)
        {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }
        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
        $('#export_excel').show();
        $('#export_excel').html('').html(tab_text);
        $('#export_excel').hide();
        $("#custom_export").table2excel({
            exclude: ".noExl",
            name: "Invoice Report",
            filename: "Invoice Report",
            fileext: ".xls",
            exclude_img: false,
            exclude_links: false,
            exclude_inputs: false
        });

    }
    function changeDateFormat(date){
        if(date){
            var date    = (date).split('/'),
            newDate = date[2] + '-' + date[1] + '-' + date[0];
            return newDate;
        }else{
            return '';
        }
    }
</script>