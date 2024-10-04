<style>
.page-titles .breadcrumb li.active a {
    color: #000000;
    font-weight: 500;
    font-size: 20px;
}

.input1,
.input2 {
    border-top: 1px solid;
}

.tab {
    display: none;
}
.cat{
  margin: 4px;
  /* background-color: #104068; */
  border-radius: 4px;
  border: 1px solid #000;
  overflow: hidden;
  float: left;
}
.cat label span:not(.badge) {
    padding: 10px;
    display: block;
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
#packagename {
    margin: 0 !important;
    display: flex;
}
.cat label input {
  position: absolute;
  display: none;
  color: #fff !important;
}
#select{
    float: right;
    color: #fff !important;
    padding: 5px;
    margin-left: 5px;
}
.action input:checked + span{
    background-color: var(--primary); 
    color: #fff !important;
}
table tr th, table tr td {
    text-align: left !important;
}
</style>
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">


<div class="block block-rounded mt-150">
    <div class="block-content">
        <div class="row d-flex justify-content-center align-items-center h-100" style="height:unset !important">
            <div class="col-lg-8 col-xl-12">
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
                <form action="<?php echo $form_action; ?>" class="form-valide" id="user-form" method="post" accept-charset="utf-8" data-parsley-validate>

                    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <!-- <input type="hidden" name="create_by" value="<?php echo $this->session->userdata('name');?>"> -->
                    
                        
                        <div class="section-header">
                            
                            <h3 class="" id="headingTitle">Add Student</h3>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-validation">
                                            <div class="row">

                                                <div class="col-xl-8  ">

                                                    <div class="card-body tab" id="step1">

                                                        <div class="form-group">
                                                            <div class="form-title">
                                                                <!-- <spam>1</spam> -->
                                                                <h6>Student Details</h6>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group">
                                                                    <label class="input-label" for="desc">First Name</label>
                                                                    <input type="text" name="first_name" id="fname" value="<?php echo $student[0]->first_name;?>" placeholder="First name"  class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group">
                                                                    <label class="input-label" for="desc">Last Name</label>
                                                                    <input type="text" name="last_name" id="lname" value="<?php echo $student[0]->last_name;?>" placeholder="Last name" class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group">
                                                                    <label class="input-label" for="desc">Email</label>
                                                                    <input type="email" name="email" id="email" value="<?php echo $student[0]->email;?>" placeholder="Email" class="form-control" data-parsley-validate required>
                                                                </div>
                                                            </div>

                                                            <?php if(!isset($student)){ ?>
                                                                <div class="row mb-1">
                                                                    <div class="col-12 form-group">
                                                                        <label class="input-label" for="desc">Password</label>
                                                                        <div class="input-group">
                                                                        <input type="password" name="password" id="id_password" value="" placeholder="Password" class="form-control"  required>
                                                                        <div class="input-group-append">
                                                                            <spam class="input-group-text">
                                                                                <i class="fa fa-eye"
                                                                                    id="togglePassword"></i>
                                                                            </spam>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group">
                                                                    <label class="input-label" for="desc">Phone</label>
                                                                        <input name="mobile" type="text" class="form-control " value="<?php echo $student[0]->phone;?>" id="mobile" aria-describedby="mobileHelp" placeholder="Phone">
                                                                    </div>
                                                                </div>
                                                            
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group">
                                                                    <label class="input-label" for="desc">Select Branch</label>

                                                                        <select name="branch"  class="form-control populate">
                                                                            <option value="">Select Branch</option>
                                                                            <option value="Melbourne CBD" <?php if(isset($student) && $student[0]->branch == "Melbourne CBD"){echo 'selected';}?>> Melbourne CBD</option>
                                                                            <option value="Clayton" <?php if(isset($student) && $student[0]->branch == "Clayton"){echo 'selected';}?>>Clayton</option>
                                                                            <option value="Trugnina" <?php if(isset($student) && $student[0]->branch == "Trugnina"){echo 'selected';}?>>Trugnina</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group">
                                                                    <label class="input-label" for="desc">Student Type</label>
                                                                        <select name="student_type" id="student_type" data-plugin-selectTwo
                                                                            class="form-control populate">
                                                                                <option value="">Select type</option>
                                                                                <option value="A1 Enrolled" <?php if(isset($student) && $student[0]->student_type == "A1 Enrolled"){echo 'selected';}?>>A1 Enrolled</option>
                                                                                <option value="Not Enrolled" <?php if(isset($student) && $student[0]->student_type == "Not Enrolled"){echo 'selected';}?>>Not Enrolled</option>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                            
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group">
                                                                    <label class="input-label" for="desc">Validity</label>
                                                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Account Validity"></i>
                                                                    <?php
                                                                        $validity = new DateTime($student[0]->validity);
                                                                    ?>
                                                                    <input type="date" name="validity" id="validity" value="<?php if(isset($student)){echo $validity->format("Y-m-d");}?>"
                                                                        placeholder="validity"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <!-- </div>
                                                    </div> -->
                                                    
                                                    <div class="card-body tab" id="step2">

                                                        <div class="form-title">
                                                            <!-- <spam>2</spam> -->
                                                            <h6>Select Package</h6>
                                                        </div>
                                                        <div class="row test">
                                                            <div class="col-xl-12 ">
                                                                <div class="row box-list">
                                                                    
                                                                    <div class="row list">
                                                                    <div class="col-xl-12 pl-4">
                                                                        <?php 
                                                                            foreach($packages as $data => $rowdata){ 
                                                                                $tests_in_package = explode(',',$rowdata->category_type_ids);

                                                                                $status = "";
                                                                                if($student_packages[$rowdata->packageid]){
                                                                                    $status = "checked";
                                                                                }
                                                                        ?>
                                                                        
                                                                        <div class="cat action">
                                                                           <label id="packagename">
                                                                                <input type="checkbox" class="checkbox" name="package[]" value="<?php echo $rowdata->packageid; ?>" <?php echo $status; ?> data-question-type="<?php echo $rowdata->package_category; ?>" data-question-count="<?php echo $tests_in_package ? count($tests_in_package) : 0; ?>" />
                                                                                <span>
                                                                                    <?php echo ucwords($rowdata->package_name); ?> 
                                                                                    <?php if($student_packages[$rowdata->packageid] && $student_packages[$rowdata->packageid]->paymentid > 0){ ?>
                                                                                        <span class="badge badge-light ml-1">Purchased</span>
                                                                                    <?php } ?>
                                                                                    <?php if($student_packages[$rowdata->packageid] && $student_packages[$rowdata->packageid]->paymentid <= 0){ ?>
                                                                                        <span class="badge badge-light ml-1">Assigned</span>
                                                                                    <?php } ?>
                                                                                    <?php if($rowdata->is_purchaseable == 1 && $rowdata->cost > 0){ ?>
                                                                                        <span class="badge badge-light ml-1">Purchaseable</span>
                                                                                    <?php } ?>
                                                                                    <?php if($rowdata->is_purchaseable == 1 && $rowdata->cost == 0){ ?>
                                                                                        <span class="badge badge-light ml-1">Free</span>
                                                                                    <?php } ?>
                                                                                    <?php if($rowdata->show_videos == 1){ ?>
                                                                                        <i class="fas fa-star" style="color:#FFC107;"></i>
                                                                                    <?php } ?>
                                                                                    <i class="fa fa-check" id="select" aria-hidden="true"></i>
                                                                                </span>
                                                                           </label>
                                                                        </div>
                                                                        
                                                                        <?php } ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mx-3">
                                                        <!-- <div class="col-xl-12"> -->
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <input type="button" id="previousBtn" onclick="previousPrev(1)" class="btn btn-primary" value="&#8592; Previous" style="display: none;">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <input type="button" id="nextBtn" onclick="nextPrev(1)" class="btn btn-primary float-right" value="Next &#x2192;">
                                                                    <input type="submit" name="submit_btn" id="submit_btn" style="display: none;"  class="btn btn-primary float-right" value="Submit">
                                                                </div>
                                                            </div>
                                                        <!-- </div> -->
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 sidebox">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="form-title">
                                                                <h6>PURCHASE SUMMARY</h6>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <div class="input pb-2 pt-2">
                                                                        <table>
                                                                            <tr>
                                                                                <td>Name :</td>
                                                                                <td id="f_name"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Email :</td>
                                                                                <td id="mail"></td>
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                                <td>Student Type :</td>
                                                                                <td id="stud_type"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="input1 pb-2 pt-2">
                                                                        <table>
                                                                            <tr>
                                                                                <td>Mock Test :</td>
                                                                                <td id="mock_total">0</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Section Wise Test :</td>
                                                                                <td id="section_total">0</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="input2 pb-2 pt-2">
                                                                        <table>
                                                                            <tr>
                                                                                <td>Total Credit Spend:</td>
                                                                                <td>0</td>
                                                                            </tr>
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
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
<script type="text/javascript">

<?php if(!isset($student)){ ?>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#id_password');
    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
<?php } ?>

$('#nextBtn').click(function() {
        var form = $('#user-form');

        form.parsley().validate();
        if (!form.parsley().isValid()) {
            return false;
        } else {
            $("#previousBtn").show();
            $("#submit_btn").show();
            $("#nextBtn").hide();

            document.getElementById('f_name').innerHTML = inputBox.value;
            document.getElementById('mail').innerHTML = inputBox1.value;
            document.getElementById('stud_type').innerHTML = dropbox.value;
            $('#step2').submit();
        }
});
$(document).ready(function() {
    <?php if($this->input->get('addtest')){ ?>
        $("#previousBtn").show();
            $("#submit_btn").show();
            $("#nextBtn").hide();

            document.getElementById('f_name').innerHTML = inputBox.value;
            document.getElementById('mail').innerHTML = inputBox1.value;
            document.getElementById('stud_type').innerHTML = dropbox.value;
            $('#step2').submit();
            nextPrev(1);
    <?php } ?>
  $('#previousBtn').click(function() {
    $("#previousBtn").hide();
    $("#submit_btn").hide();
    $("#nextBtn").show();
  });

    <?php if(count($student_packages) > 0){ ?>
        $("input[name='package[]']").each(function(index) {
            document.getElementById('f_name').innerHTML = inputBox.value;
            document.getElementById('mail').innerHTML = inputBox1.value;
            document.getElementById('stud_type').innerHTML = dropbox.value;
            
            var mocktotal = parseInt($("#mock_total").text());
            var sectiontotal = parseInt($("#section_total").text());

            if($(this).is(':checked')){
                var count = parseInt($(this).attr('data-question-count'));
                if($(this).attr('data-question-type') == 'full-test'){
                    $("#mock_total").text(mocktotal + count);
                }
                if($(this).attr('data-question-type') == 'section-test'){
                    $("#section_total").text(sectiontotal + count);
                }
            }
        });
    <?php } ?>
});

var inputBox = document.getElementById('fname');
var inputBox1 = document.getElementById('email');
var dropbox = document.getElementById('student_type');

$("input[name='package[]']").change(function(e) {
    var mocktotal = parseInt($("#mock_total").text());
    var sectiontotal = parseInt($("#section_total").text());
    if($(this).is(':checked')){
        var count = parseInt($(this).attr('data-question-count'));
        if($(this).attr('data-question-type') == 'full-test'){
            $("#mock_total").text(mocktotal + count);
        }
        if($(this).attr('data-question-type') == 'section-test'){
            $("#section_total").text(sectiontotal + count);
        }
    }else{
        var count = parseInt($(this).attr('data-question-count'));
        if($(this).attr('data-question-type') == 'full-test'){
            $("#mock_total").text(mocktotal - count);
        }
        if($(this).attr('data-question-type') == 'section-test'){
            $("#section_total").text(sectiontotal - count);
        }
    }
});

var currentTab = 0;
showTab(currentTab);

function showTab(n) {

    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";

    if (n == (x.length - 1)) {
        document.getElementById("submit_btn").innerHTML = "Submit";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
}

function nextPrev(n) {

    var x = document.getElementsByClassName("tab");
    var form = $('#user-form');
    form.parsley().validate();

    if (n == 1 && !form.parsley().isValid()) return false;

    x[currentTab].style.display = "none";
    currentTab = currentTab + n;

    if (currentTab >= x.length) {
        document.getElementById("regForm").submit();
        return false;
    }
    showTab(currentTab);
}
function previousPrev(n) {

    var x = document.getElementsByClassName("tab");
    var form = $('#user-form');
    form.parsley().validate();
    
    if (n == 1 && !form.parsley().isValid()) return false;

    x[currentTab].style.display = "none";
    currentTab = currentTab - n;

    if (currentTab >= x.length) {
        document.getElementById("regForm").submit();
        return false;
    }
    showTab(currentTab);
}
</script>