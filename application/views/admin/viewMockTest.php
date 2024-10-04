<style>
table.dataTable {
    width: 100% !important;
}
a{
    cursor: pointer;
}
</style>

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css">

<div class="section-header">
    <h1>Mock Test List</h1>
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
                        <table id="mock-test-list" class="table table-striped font-14 hover">
                            <thead>
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Title</th>
                                    <th class="align-middle">PTE Type</th>
                                    <th class="align-middle">Type</th>
                                    <th class="align-middle">Created On</th>
                                    <th class="align-middle">Action</th>
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
    $("#mock-test-list").DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        dataType: "json",
        paging: true,
        pagingType: "simple_numbers",
        order: [],
        pageLength: 50,
        "ajax": {
            "url": siteUrl + "admin/getmocktestlist",
        },
        "columnDefs": [{
            "targets": [0,5],
            "orderable": false
        }],
        "initComplete": function(settings, json) {
            $('#question_count').html(json.question_count);
        }
    });
});

function deletemocktest(id) {
    if (confirm('Do you really want to delete this mocktest? You will not be able to recover it later.')) {
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash

        $.ajax({
            url: siteUrl + "admin/deletemocktest",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,
            data: {
                [csrfName]: csrfHash,
                series: id,
            },
            success: function(data) {
                $('.csrfToken').val(data.token);
                $('#mock-test-list').DataTable().ajax.reload();
            }
        });
    } else {
        return false;
    }
}
</script>