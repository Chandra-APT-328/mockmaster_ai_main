<style>
div.table-responsive>div.dataTables_wrapper>div.row {
    margin: 10px;
}
</style>

<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/plugins/datatables/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

<!-- END Stylesheets -->

<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script> -->

<!-- Datatable style and script -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css"> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js">
</script>

<!-- Datatable import buttons css and script -->
<link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>

<style>
.edit {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.delete {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}

.edit:hover,
.delete:hover {
    opacity: 0.7;
    color: #fff;
}

.card:hover {
    box-shadow: none;
}
</style>
<div class="block block-rounded mt-150">
    <div class="block-content">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center align-items-center h-100"
                                style="height:unset !important">
                                <div class="col-lg-8 col-xl-12">
                                    <div class="row table-responsive">
                                        <!-- form error notification -->
                                        <?php if($this->session->userdata('error')){ ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $this->session->userdata('error'); 
                                $this->session->unset_userdata('error');?>
                                        </div>
                                        <?php } ?>
                                        <?php if($this->session->userdata('success')){ ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $this->session->userdata('success'); 
                                $this->session->unset_userdata('success');?>
                                        </div>
                                        <?php } ?>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">


                                                        <input type="hidden" class="csrfToken"
                                                            name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                            value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                        <table class="table caption-top" id="userTable1">
                                                            <!-- <h5 class="">Summarize Written Text</h5> -->
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Question</th>
                                                                    <th scope="col">Question Type</th>
                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                    $i = 1;
                                        foreach ($getQuestions as $data => $rowData) {
                                            echo "<tr>";
                                            echo "<th scope='row'>".$i."</th>";
                                            echo "<td>".$rowData->title."<span class='badge badge-secondary' style='float: right;'>".$rowData->attempts."</span></td>";
                                            echo "<td>".$getCatData[$rowData->question_type]."</td>";
                                            echo "<td><a class='btn btn-sm edit' href=".base_url()."user/".$rowData->question_type."/".$rowData->id.">View</a></td>";
                                            $i++;
                                        }
                                    ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</body>
<script>
$(document).ready(function() {
    $('#userTable1').DataTable({
        paging: true,
        order: [
            [0, 'desc']
        ],
        dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>"
    });
});
</script>
<!-- Required vendors -->
<script src="<?php echo base_url() ?>assets/vendor/global/global.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js">
</script>
<script src="<?php echo base_url() ?>assets/js/deznav-init.js"></script>
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/highlightjs/highlight.pack.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.js">
</script>

<script src="<?php echo base_url() ?>assets/js/custom.min.js"></script>