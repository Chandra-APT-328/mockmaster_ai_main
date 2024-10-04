<style>
div.table-responsive>div.dataTables_wrapper>div.row {
    margin: 10px;
}

td:has(> input.status-switch) {
    display: flex;
    justify-content: center;
}
table.dataTable {
    width: 100% !important;
}

.status-switch{
	height: 0;
	width: 0;
	visibility: hidden;
}

.toggle-label {
	cursor: pointer;
	text-indent: -9999px;
	width: 40px;
	height: 20px;
	background: grey;
	display: block;
	border-radius: 100px;
	position: relative;
}

.toggle-label:after {
	content: '';
	position: absolute;
	top: 1px;
	left: 1px;
	width: 20px;
	height: 18px;
	background: #fff;
	border-radius: 90px;
	transition: 0.3s;
}

input:checked + .toggle-label {
	background: var(--primary);
}

input:checked + .toggle-label:after {
	left: calc(100% - 1px);
	transform: translateX(-100%);
}

.toggle-label:active:after {
	width: 26px;
}

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

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css">

<div class="section-header">
    <h1>Package List</h1>
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
                        <table id="package-list" class="table table-striped font-14 hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Purchaseable</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
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
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
var siteUrl = '<?php echo base_url() ?>';

$(document).ready(function() {
    $("#package-list").DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        dataType: "json",
        paging: true,
        pagingType: "simple_numbers",
        order: [],
        pageLength: 50,
        dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
        "ajax": {
            "url": siteUrl + "admin/getpackagelist",
        },
        "columnDefs": [{
            "targets": [0,5,7],
            "orderable": false
        }],
        "initComplete": function(settings, json) {
            $('#question_count').html(json.question_count);
        }
    });
});

function deletePackage(packageId) {
    var siteUrl = '<?php echo base_url() ?>';
    if (confirm('Do you really want to delete this Package?')) {
        var tablename = 'packages';
        var columnname = 'id';
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash
        $.ajax({
            url: siteUrl + "package/deletePackage",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,
            data: {
                [csrfName]: csrfHash,
                package: packageId,
            },
            success: function(data) {
                $('.csrfToken').val(data.token);
                $('#package-list').DataTable().ajax.reload();
            }
        })
    } else {
        return false;
    }

}

function changestatus(id,e){
    var csrfName = $('.csrfToken').attr('name');
    var csrfHash = $('.csrfToken').val();
    $.ajax({
        url: "<?php echo base_url() ?>package/checkedpackagestatus", 
        type: "POST",  
        crossDomain: true,
        dataType: 'json',
        cache: false,
        data:{
            [csrfName]: csrfHash,
            package : id,
            status : e.checked ? 1 : 0,
        },  
        success:function(data){
            $('.csrfToken').val(data.token);
        }  
    });  
}
</script>