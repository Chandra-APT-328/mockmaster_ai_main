<style>
table.dataTable {
    width: 100% !important;
}
.badge {
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}
</style>

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css">

<div class="section-header">
    <h1>Order History</h1>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

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

                    <input type="hidden" class="csrfToken"
                            name="<?php echo $this->security->get_csrf_token_name(); ?>"
                            value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="table-responsive">
                        <table id="order-history-list" class="table table-striped font-14 hover">
                            <thead>
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Product</th>
                                    <th class="align-middle">Buyer</th>
                                    <th class="align-middle">Amount</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Create Date</th>
                                    <th class="align-middle">Last Updated</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- Required vendors -->
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

<script type="text/javascript">
var siteUrl = '<?php echo base_url() ?>';

$(document).ready(function() {
    $("#order-history-list").DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        dataType: "json",
        paging: true,
        pagingType: "simple_numbers",
        order: [],
        pageLength: 50,
        dom: 'ltipr',
        "ajax": {
            "url": siteUrl + "admin/orderhistorylist",
        },
        "columnDefs": [{
            "targets": [0,2],
            "orderable": false
        }],
        "initComplete": function(settings, json) {
            $('#question_count').html(json.question_count);
        }
    });
});
</script>