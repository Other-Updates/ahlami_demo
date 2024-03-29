<?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Invoice Report

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
        	<div class="overflow-x">
        	<table class="table table-bordered table-striped table-hover dataTable report-table" cellspacing="0" idth="100%" id="invoice_datatable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Trip&nbsp;#</th>
                        <th>Invoice&nbsp;#</th>
                        <th>ScooterO</th>
                        <th>Customer</th>
                        <th>Ride&nbsp;Start</th>
                        <th>Ride&nbsp;End</th>
                        <th>Ride&nbsp;Distance</th>
                        <th>Total&nbsp;Ride&nbsp;Amount</th>
                        <th>Unlock&nbsp;Charge</th>
                        <th>Sub&nbsp;total</th>
                        <th>Vat&nbsp;Charge</th>
                        <th>Grand&nbsp;Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot class="hide_class">
                    <tr>
                        <td colspan="7"></td>                 
                        <td class="total-bg"></td>
                        <td class="total-bg"></td>
                        <td class="total-bg"></td>
                        <td class="total-bg"></td>
                        <td class="total-bg"></td>
                        <td class="total-bg"></td>
                    </tr>
                </tfoot>
            </table>
         </div>       	
        </div>
    </div>
</div>
</div>
<div id="export_excel"></div>
<script>
    var table = $('#invoice_datatable').DataTable({
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
                    "url":"<?php echo $this->config->base_url();?>"+"reports/invoice_ajaxList",
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
            $(row).find('td:eq(2)').attr('data-th', 'Invoice #');
            $(row).find('td:eq(3)').attr('data-th', 'ScooterO');
            $(row).find('td:eq(4)').attr('data-th', 'Customer');
            $(row).find('td:eq(5)').attr('data-th', 'Ride Start');
            $(row).find('td:eq(6)').attr('data-th', 'Ride End');
            $(row).find('td:eq(7)').attr('data-th', 'Ride Distance');
            $(row).find('td:eq(8)').attr('data-th', 'Total Ride Amount');
            $(row).find('td:eq(9)').attr('data-th', 'Unlock Charge');
            $(row).find('td:eq(10)').attr('data-th', 'Sub total');
            $(row).find('td:eq(11)').attr('data-th', 'Vat Charge');
            $(row).find('td:eq(12)').attr('data-th', 'Grand Total');
            
        },
        "order": [[ 1, "asc" ]],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            var cols = [7,8,9,10,11,12];
            symbol = " ";
            var numFormat = $.fn.dataTable.render.number('\,', '.', 2, symbol).display;
            for (x in cols) {
                total = api.column(cols[x]).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                // Total over this page
                pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                // Update footer
                if (Math.floor(pageTotal) == pageTotal && $.isNumeric(pageTotal)) {
                    pageTotal = pageTotal;

                } else {
                    pageTotal = pageTotal.toFixed(2);/* float */
                }

                // $(api.column(cols[x]).footer()).html(Math.round(pageTotal));
                
                $(api.column(cols[x]).footer()).html(numFormat(parseFloat(pageTotal).toFixed(2)));       

            }
        },
        "columnDefs": [
            { className:"text-center", "targets": [0]},
            { className:"text-center", "targets": [1,2,5,6] },
            { className:"text-right", "targets": [7,8,9,10,11,12] },
            { className:"text-left", "targets": [3,4] }
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
        tab = document.getElementById('invoice_datatable'); // id of table
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