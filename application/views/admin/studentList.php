<style>
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
</style>

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css">

<div class="section-header">
    <h1>Student List</h1>
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
                        <table id="student-list" class="table table-striped font-14 hover">
                            <thead>
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">Email</th>
                                    <th class="align-middle">Contact</th>
                                    <th class="align-middle">Student Type</th>
                                    <th class="align-middle">Status</th>
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
    $("#student-list").DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        dataType: "json",
        paging: true,
        pagingType: "simple_numbers",
        order: [],
        pageLength: 50,
        "ajax": {
            "url": siteUrl + "admin/getstudentlist",
        },
        "columnDefs": [{
            "targets": [0,5,6],
            "orderable": false
        },
        {
            "targets": [2,3,4],
            "className": 'text-left'
        }],
        "initComplete": function(settings, json) {
            $('#question_count').html(json.question_count);
        }
    });
});

function deletestudent(id) {
    if (confirm('Do you really want to delete this student? You will not recover it later.')) {
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash

        $.ajax({
            url: siteUrl + "admin/deletestudent",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,
            data: {
                [csrfName]: csrfHash,
                student: id,
            },
            success: function(data) {
                $('.csrfToken').val(data.token);
                $('#student-list').DataTable().ajax.reload();
            }
        });
    } else {
        return false;
    }
}

function changestatus(id,e){
    var csrfName = $('.csrfToken').attr('name');
    var csrfHash = $('.csrfToken').val();
    $.ajax({
        url: "<?php echo base_url() ?>admin/checkedstudentstatus", 
        type: "POST",  
        crossDomain: true,
        dataType: 'json',
        cache: false,
        data:{
            [csrfName]: csrfHash,
            student : id,
            status : e.checked ? 1 : 0,
        },  
        success:function(data){
            $('.csrfToken').val(data.token);
        }  
    });  
}
</script>