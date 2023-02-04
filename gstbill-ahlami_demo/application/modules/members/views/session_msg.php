 <?php if ($this->session->flashdata('flashSuccess')) { ?>
    <div class="alert alert-success no-border">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Success!</span> <?php echo $this->session->flashdata('flashSuccess') ?>
    </div> 
<?php } ?>
<?php if ($this->session->flashdata('flashError')) { ?>
    <div class="alert alert-danger no-border">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Error!</span> <?php echo $this->session->flashdata('flashError') ?>
    </div>
<?php } ?>
<?php if ($this->session->flashdata('flashInfo')) { ?>
    <div class="alert alert-info no-border">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Info!</span> <?php echo $this->session->flashdata('flashInfo') ?>
    </div>   
<?php } ?>
<?php if ($this->session->flashdata('flashWarning')) { ?>
    <div class="alert alert-warning no-border">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Warning!</span> <?php echo $this->session->flashdata('flashWarning') ?>
    </div>
<?php } ?>
