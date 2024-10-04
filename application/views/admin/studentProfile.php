<style>
.rank-no {
    font-size: 22px;
    color: #FFFFFF;
}

.set-col {
    display: flex;
    justify-content: space-around;
    text-align: center;
    background: #00A4EF;
}

.stats-box {
    position: relative;
    box-shadow: rgba(51, 51, 51, 0.08) 0px 4px 10px;
    background-color: rgb(255, 255, 255);
    border-radius: 8px;
    height: 194px;
    overflow: hidden;
}

.stats-date {
    background-color: #6777ef;
    font-size: 12px;
    color: rgb(255, 255, 255);
    padding: 7px 15px;
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
}

.stats-details-box {
    font-size: 32px;
    height: 154px;
    padding: 0px 20px;
}

.stats-days-left {
    border: 1px solid rgb(255, 255, 255);
    padding: 3px 7px;
    border-radius: 4px;
}

.stats-details {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    justify-content: space-around;
}

.stats {
    text-align: center;
}

.stats-today-practice {
    color: #6777ef;
    font-weight: bold;
}

.stats-label {
    font-size: 16px;
    color: rgb(153, 153, 153);
}


.stats-numbers {
    color: rgb(51, 51, 51);
    font-weight: initial;
}

/* profile */
.profile-img {
    padding: 25px 14px;
}
</style>


<!-- <div class="content-body"> -->
    <!-- row -->
    <!-- <div class="container-fluid"> -->

        <div class="section-header">
            <h1>Student Profile</h1>

        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="student-detail">
								<div class="row">
									<div class="col-2">
										<div class="profile-img">
											<img alt="image" style="width: 150px;" src="<?php echo $this->session->userdata('profile_picture') ? base_url($this->session->userdata('profile_picture')) : base_url('assets/images/default-profile.png'); ?>" class="rounded-circle mr-1">
										</div>										
									</div>
									<div class="col-12 col-md-10">
										<div class="row">
											<div class="col-12">
												<div class="student-name">
													<h4> <?php echo $studentList[0]->first_name; ?></h4>
												</div>
												<div class="exp-date">
													<?php $validity = new DateTime($studentList[0]->validity); ?>
													<p>Expire Date: <?php echo $validity->format('d M Y'); ?></p>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-4">
												<div class="username-title">
													<b>Full Name:</b>
												</div>
												<div class="username">
													<p><?php echo $studentList[0]->first_name .' '. $studentList[0]->last_name; ?></p>
												</div>
											</div>
											<div class="col-4">
												<div class="email-title">
													<b>Email:</b>
												</div>
												<div class="email">
													<p><?php echo $studentList[0]->email; ?></p>
												</div>
											</div>
											<div class="col-4">
												<div class="contact-title">
													<b>Contact:</b>
												</div>
												<div class="contact">
													<p><?php echo $studentList[0]->country_code . " "; ?><?php echo $studentList[0]->phone ?  $studentList[0]->phone : "N/A"; ?></p>

												</div>
											</div>
											<div class="col-4">
												<div class="product-title">
													<b>Product</b>
												</div>
												<div class="product">
													<p>PTE</p>
												</div>
											</div>
											<div class="col-4">
												<div class="student-type-title">
													<b>Student Type:</b>
												</div>
												<div class="student-type">
													<p><?php echo $studentList[0]->stud_type ?  $studentList[0]->stud_type : "N/A"; ?></p>
												</div>
											</div>
											<div class="col-4">
												<div class="create-title">
													<b>Created On</b>
												</div>
												<div class="create">
													<p>
														<?php 
															$created_on = new DateTime($studentList[0]->create_date);
															echo $created_on->format("M d, Y g:i A");
														?>
													</p>
												</div>
											</div>
											<div class="col-4">
												<div class="target-score-title">
													<b>Applykart Coupon</b>
												</div>
												<div class="target-score">
													<p><?php echo $studentList[0]->ak_coupon_code; ?></p>
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

			<div class="row">
                <h3 class="fs-20 text-black mb-2 ml-4">Quick Action</h3>
            </div>

			<input type="hidden" class="csrfToken"
                            name="<?php echo $this->security->get_csrf_token_name(); ?>"
                            value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="row">

                <div class="col-md-2 col-sm-6">
                    <div class="card">

                        <div class="card-body" data-toggle="modal" data-target="#LoginPopup" style="cursor:pointer;">
                            <div class="text-center">
                                <i class="fas fa-sign-in-alt" style="font-size:36px"></i>

                            </div>
                            <p class="card-text text-center"> Login</p>
						</div>
                    </div>
                </div>


                <div class="col-md-2 col-sm-6">
                    <div class="card">
						<!-- <a href="<?php echo base_url('admin/addstudent/'.$studentList[0]->studentId); ?> " style="color:unset; text-decoration:none;"> -->
							<div class="card-body" data-toggle="modal" data-target="#editPopup" style="cursor:pointer;">
								<div class="text-center">
									<i class="fas fa-pen" style="font-size:36px"></i>

								</div>
								<p class="card-text text-center"> Edit</p>
							</div>
						<!-- </a> -->
                    </div>
                </div>


                <div class="col-md-2 col-sm-6">
                    <div class="card">

                        <div class="card-body" onclick="deletestudent(<?php echo $studentList[0]->studentId ?>)" style="cursor:pointer;">
                            <div class="text-center">
                                <i class="far fa-trash-alt" style='font-size:36px;color:red'></i>

                            </div>
                            <p class="card-text text-center"> Delete</p>
                        </div>
                    </div>
                </div>


                <div class="col-md-2 col-sm-6">
                    <div class="card">
					<a href="<?php echo base_url('admin/addstudent/'.$studentList[0]->studentId.'?addtest=1'); ?> " style="color:unset; text-decoration:none;">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fa fa-plus" style="font-size:36px;color:blue"></i>

                            </div>
                            <p class="card-text text-center"> Add Test</p>
                        </div>
					</a>
                    </div>
                </div>


                <div class="col-md-2 col-sm-6">
                    <div class="card">

                        <div class="card-body" onclick="extendValidityPopup()" style="cursor:pointer">
                            <div class="text-center">
                                <i class='fas fa-sync-alt' style='font-size:36px'></i>
                            </div>
                            <p class="card-text text-center">Extend validity</p>
                        </div>
                    </div>
                </div>


                <!-- <div class="col-md-2 col-sm-6">
                    <div class="card">

                        <div class="card-body">
                            <div class="text-center">
                                <i class="fa fa-print" style="font-size:36px"></i>

                            </div>
                            <p class="card-text text-center"> Templates</p>
                        </div>
                    </div>
                </div> -->



            </div>

            <div class="row">
                <h3 class="fs-20 text-black mb-2 ml-4">Test Overview</h3>
            </div>

            <div class="row">
				<div class="col-xl-4 col-xxl-4">
						<div class="row">
							<div class="col-xl-12 col-md-6">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-19">TEST HISTORY</h4>	
									</div>
									<div class="card-body">
										<table class="font-12 table-bordered">
											<thead>
												<tr>
													<th class="p-2">Test Allocation</th>
													<th class="p-2">Date</th>
													<th class="p-2">Status</th>
												</tr>
											</thead>
											<tboday>
												<?php foreach($mock_history as $key => $mocktest){ ?>
												<?php foreach ($mock_test as $test => $rowtest) { ?>
												<?php if ($mocktest->mock_series == $rowtest->id) { ?>
												<tr>
													<td class="text-left p-1"><?php echo $rowtest->title; ?></td>
													<td class="text-left p-1">
														<?php 
															$last_updated = new DateTime($mocktest->update_date);
															echo $last_updated->format("M d, Y g:i A");
															?>
													</td>
													<td class="text-left p-1">
														<?php if($mocktest->status == 3) { echo "Pending"; } ?>
														<?php if($mocktest->status == 2) { echo "Completed Pending Scoring"; } ?>
														<?php if($mocktest->status == 1) { echo "Completed"; } ?>
													</td>
												</tr>
												<?php } ?>
												<?php } ?>
												<?php } ?>
											</tboday>
										</table>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-xxl-4">
						<div class="row">
							<div class="col-xl-12 col-md-6">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-19">MOCK TEST</h4>
									
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-4">
												<div class="available">Available</div>
												<div class="available-no"><p>40</p></div>
											</div>
											<div class="col-4">
												<div class="use">Used</div>
												<div class="use-no"><p>0</p></div>
											</div>
											<div class="col-4">
												<div class="unuse">Unused</div>
												<div class="unuse-no"><p>0</p></div>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<div class="position-relative">
													<canvas id="saleStatisticsChart"></canvas>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-xxl-4">
						<div class="row">
							<div class="col-xl-12 col-md-6">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-19">SECTION WISE TEST</h4>
									
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-4">
												<div class="available">Available</div>
												<div class="available-no"><p>40</p></div>
											</div>
											<div class="col-4">
												<div class="use">Used</div>
												<div class="use-no"><p>0</p></div>
											</div>
											<div class="col-4">
												<div class="unuse">Unused</div>
												<div class="unuse-no"><p>0</p></div>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<div class="position-relative">
													<canvas id="saleStatisticsChart1"></canvas>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
        </div>
		<div class="modal fade" id="validityPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Extend Validity</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row mb-1">
						<div class="col-12 form-group">
							<label class="input-label" for="desc">Validity</label>
							<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Account Validity"></i>
							<?php
								$validity = new DateTime($studentList[0]->validity);
							?>
							<input type="date" name="validity" id="validity" min="<?php if(isset($studentList)){echo $validity->format("Y-m-d");}?>" value="<?php if(isset($studentList)){echo $validity->format("Y-m-d");}?>"
								placeholder="validity"
								class="form-control" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="saveValidity()">Save</button>
				</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="LoginPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Student Login</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body pb-0">
					<p>You will be logged out as Admin.</p>
					<p>Do you want to continue ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" onclick="studentLogin(<?php echo $studentList[0]->studentId ?>)">Yes</button>
				</div>
				</div>
			</div>
		</div>
    <!-- </div>
</div> -->

		<div class="modal fade" id="editPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Edit Student Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row mb-1">
						<div class="col-12 form-group">
							<form action="<?php echo base_url(); ?>admin/updateStudentProfile" method="post" id="studentUpdateForm">
								<input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<input type="hidden" name="studentId" value ="<?php echo $studentList[0]->studentId; ?>"/>
								<div class="row pt-2">
									<label class="col-3">First Name</label>
									<input type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control col-9" value = "<?php echo $studentList[0]->first_name; ?>" required>
								</div>
								<div class="row pt-2">
									<label class="col-3">Last Name</label>
									<input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control col-9" value = "<?php echo $studentList[0]->last_name; ?>" required>
								</div>
								<div class="row pt-2">
									<label class="col-3">Password</label>
									<input type="password" name="password" id="password" placeholder="Password" class="form-control col-8" autocomplete="new-password" required>
									<i class="fa fa-eye col-1 d-flex align-items-center" id="togglePassword" style="cursor: pointer;"></i>
								</div>
								<div class="row pt-2">
									<label class="col-3">Email</label>
									<input type="text" name="email" id="email" placeholder="Email" class="form-control col-9" value = "<?php echo $studentList[0]->email; ?>" required>
								</div>
								<div class="row pt-2">
									<label class="col-3">Phone</label>
									<input type="text" name="phone" id="phone" placeholder="Phone" class="form-control col-9" value = "<?php echo $studentList[0]->phone; ?>" required>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="studentUpdate()" >Update</button>
				</div>
				</div>
			</div>
		</div>

<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/chartjs/chart.min.js"></script>
<script>
const siteUrl = '<?php echo base_url(); ?>';

var saleStatisticsChart = document.getElementById("saleStatisticsChart").getContext('2d');
	var chart = {};
(function ($) {
	"use strict";

	makeStatisticsChart('saleStatisticsChart', saleStatisticsChart, 'Sale', [],[0,0,0,0,0,0,0,0,550,0,0,0]);

	// makeStatisticsChart('usersStatisticsChart', usersStatisticsChart, 'Users', ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"],[2,0,0,0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]);
	
})(jQuery)





function makeStatisticsChart(name, section, badge, labels, datasets) {
  chart[name] = new Chart(section, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        label: badge,
        data: datasets,
        indexLabel: "{symbol} - {y}",
		yValueFormatString: "#,##0.0\"%\"",
		showInLegend: true,
		legendText: "{label} : {y}",
		backgroundColor: '#6777ef'
      }]
    }
  });
}

// saleStatisticsChart1
var saleStatisticsChart1 = document.getElementById("saleStatisticsChart1").getContext('2d');
	var chart = {};
(function ($) {
	"use strict";

	makeStatisticsChart1('saleStatisticsChart1', saleStatisticsChart1, 'Sale', [40,10,50],[3,0,0,40,0,0,60,0,550,0,0,0]);

	// makeStatisticsChart('usersStatisticsChart', usersStatisticsChart, 'Users', ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"],[2,0,0,0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]);
	
})(jQuery)

function makeStatisticsChart1(name, section, badge, labels, datasets) {
  chart[name] = new Chart(section, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        label: badge,
        data: datasets,
        indexLabel: "{symbol} - {y}",
		yValueFormatString: "#,##0.0\"%\"",
		showInLegend: true,
		legendText: "{label} : {y}",
		backgroundColor: '#6777ef'
      }]
    }
  });
}

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
                location.href="<?php echo base_url('admin/students');?>";
            }
        });
    } else {
        return false;
    }
}

function studentLogin(id){

	$.ajax({
		url: siteUrl + "admin/studentLogin",
		type: "get",
		crossDomain: true,
		dataType: 'json',
		cache: false,
		data: {
			studentId: id,
		},
		success: function() {
			location.href="<?php echo base_url('user/signin');?>";
		}
	});

}

function extendValidityPopup(){
	$('#validityPopup').modal('show');
}

function studentUpdate(){
	$('#studentUpdateForm').submit();
}
function saveValidity(){
	var csrfName = $('.csrfToken').attr('name');
	var csrfHash = $('.csrfToken').val(); // CSRF hash

	$.ajax({
		url: siteUrl + "admin/extendStudentValidity",
		type: "POST",
		crossDomain: true,
		dataType: 'json',
		cache: false,
		data: {
			[csrfName]: csrfHash,
			studentId: <?php echo $studentList[0]->studentId ?>,
			newValidity: $('#validity').val()
		},
		success: function(data) {
			$('.csrfToken').val(data.token);
			location.reload();
		}
	});
}

const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('fa-eye-slash');
    this.classList.toggle('fa-eye');
  });
</script>
