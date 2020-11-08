<?php $this->load->view('admin/layouts/vwheader'); ?> 
 <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        <?php $this->load->view('admin/layouts/vwNavigation'); ?>

        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-header">
              <div class="row">
                <div class="col-lg-12">
                  <h3>Users</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL."admin/users";?>"><i data-feather="user"></i></a></li>
                    <li class="breadcrumb-item">Users</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
		<div class="container-fluid">
			<div class="row">
				<!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-sm-10">
								<h5>Users</h5>
							</div>
							<?php
								$add_access = false;
								$add_short_code = "users_add";
								if(isset($this->permissionData->$add_short_code))
									$add_access = true;
								
								if($add_access)
								{
							?>
									<div class="col-sm-2">
										<button class="btn btn-primary" type="button" onclick="adduser()">Add User</button>
									</div>
						<?php 	} ?>
						</div>
					</div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="display" id="dataTable">
                        <thead>
                          <tr>
							<th>Sr. #</th>
                            <th>Name</th>
                            <th>User Name</th>
							<th>Email</th>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
			</div>
		</div>
          <!-- Container-fluid Ends-->
    </div>
	
<div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="ModalLabel"></h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	  </div>
	  <div class="modal-body">
		<form class="form theme-form" id="ModalForm" action="" method="post" enctype="multipart/form-data">
		  <div class="modal-body">
			<?php echo create_csrfinput(); ?>	
			<input type="hidden" name="pri_id" id="pri_id" />
			<div class="card-body">
			  <div class="row">
				<div class="col">
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Name</label>
					<div class="col-sm-9">
					  <input class="form-control" type="text" placeholder="Name" id="name" name="name" required title="Name" >
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">User Name</label>
					<div class="col-sm-9">
					  <input class="form-control" type="text" placeholder="User Name" id="uname" name="uname" required title="User Name" >
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Email</label>
					<div class="col-sm-9">
					  <input class="form-control" type="email" placeholder="Email" id="email" name="email" required title="Email" >
					</div>
				  </div>
				  <div class="form-group row" id="change_password_div" style="display:none;">
					<label class="col-sm-3 col-form-label">Change Password</label>
					<div class="col-sm-9">
						<div class="checkbox checkbox-dark">
							<input id="change_password" name="change_password" onchange="change_pass(this)" type="checkbox" data-original-title="" title="">
							<label for="change_password"></label>
						</div>
					</div>
				  </div>
				  <div id="password_div">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Password</label>
						<div class="col-sm-9">
						  <input class="form-control" type="password" placeholder="Password" id="password" name="password" title="Password" >
						</div>
					  </div>
					  <div class="form-group row">
						<label class="col-sm-3 col-form-label">Confirm Password</label>
						<div class="col-sm-9">
						  <input class="form-control" type="password" placeholder="Confirm Password" id="con_password" name="con_password" title="Confirm Password" >
						</div>
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Phone</label>
					<div class="col-sm-9">
					  <input class="form-control m-input digits phone_number" type="tel" placeholder="Phone" id="phone" name="phone" required title="Phone" >
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Role</label>
					<div class="col-sm-9">
						<select class="form-control form-control-inverse btn-square" name="role_id" id="role_id" required>
							<option value="">Select Role</option>
							<?php
								if(isset($role_data) && !empty($role_data))
								{
									foreach($role_data as $index => $role)
									{
							?>
										<option value="<?php echo $role->id;?>"><?php echo $role->role_name;?></option>
							<?php
									}
								}
							?>
						</select>
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Status</label>
					<div class="col-sm-9">
						<select class="form-control form-control-inverse btn-square" name="status_id" id="status_id" required>
							<option value="1">Active</option>
							<option value="0">In-Active</option>
						</select>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
			<button class="btn btn-secondary" type="submit" id="btn-save" value="">Save</button>
		  </div>
	  </form>
	  </div>
	</div>
  </div>
</div>

<?php $this->load->view('admin/layouts/vwfooter'); ?>
<script>
var table_obj = "";
$( document ).ready(function() {
	
    init_dataTable();
});

function init_dataTable()
{	
	if(table_obj != '' && table_obj != null)
	{
		$('#dataTable').dataTable().fnDestroy();
		$('#dataTable tbody').empty();
		table_obj = '';
	}

	var mSortingString = [];

	table_obj = $('#dataTable').DataTable({
		"processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		scrollX: false,
		paging: true,
		ordering: false,
		searching: true,
		bfilter: false,
		info: true,
		orderMulti: false,
		iDisplayLength: 10,
		aoColumnDefs:mSortingString,
		"initComplete": function(settings, json) {
	
		},
		/* fixedColumns:   {
			leftColumns: 2
		}, */
		// Load data for the table's content from an Ajax source

		"ajax": {
			"url":'<?= base_url("admin/showUsers");?>',
			"type": "POST",
			"dataFilter":function(inData){ 
				return inData;									
			},
		},
		
		//Set column definition initialisation properties.
		"columnDefs": [
			{ 
				"targets": [ 0 ], //first column / numbering column
				"orderable": true, //set not orderable
			}
		],
		
		"order": [
			
		], //Initial no order.
		"language": {
		
		}
	});

	return false;
}

/*

$(document).ready(function () {
	
	$("#MenuDataTable").DataTable();
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	}); 
});

*/

function adduser() 
{
	$("#change_password_div").hide();
	$("#change_password").prop("checked",false);
	$("#password_div").show();
	
	$("#password").attr({"required":true, "minlength":8});
	$("#con_password").attr({"required":true, "minlength":8});
	
	$("#password").val("");
	$("#con_password").val("");
	
	$('#btn-save').val("create-user");
	$('#pri_id').val("");
	$('#ModalForm').trigger("reset");
	$('#ModalLabel').html("");
	$('#ModalLabel').html("Add User");
	$('#UserModal').modal('show');
}

jQuery('#ModalForm').submit(function(event)
{
	event.preventDefault();
	
	var passCheck = true;
	if($("#pri_id").val() != "")
	{
		if($("#change_password").prop("checked") == false )
			passCheck = false;
	}
	if($("#name").val() == "" || $("#name").val() == " " || $("#name").val() == "-" )
	{
		alert("Please Enter Name");
		return false;
	}
	if($("#uname").val() == "" || $("#uname").val() == " " || $("#uname").val() == "-" )
	{
		alert("Please Enter User Name");
		return false;
	}
	if($("#email").val() == "" || $("#email").val() == " " || $("#email").val() == "-" )
	{
		alert("Please Enter E-mail");
		return false;
	}
	if(passCheck)
	{
		if($("#password").val() == "" || $("#password").val() == " " || $("#password").val() == "-" )
		{
			alert("Please Enter Password");
			return false;
		}
		if($("#con_password").val() == "" || $("#con_password").val() == " " || $("#con_password").val() == "-" )
		{
			alert("Please Enter Confirm Password");
			return false;
		}
		if($("#password").val() != "" && $("#con_password").val() != "")
		{
			if($("#password").val() != $("#con_password").val())
			{
				alert("Password and Confirm Password Should be Same");
				return false;
			}
		}
	}
	if($("#phone").val() == "" || $("#phone").val() == " " || $("#phone").val() == "-" )
	{
		alert("Please Enter Phone");
		return false;
	}
	if($("#role_id").val() == "" || $("#role_id").val() == " " || $("#role_id").val() == "-" )
	{
		alert("Please Select Role");
		return false;
	}
	
	var actionType = $('#btn-save').val();
	$('#btn-save').html('Sending..');

	$('#btn-save').attr('disabled',true);
	
	jQuery.ajax({
		url: '<?= base_url("admin/saveUser");?>',
		type: 'POST',
		dataType: 'json',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(response, textStatus, xhr) {
			$('#btn-save').attr('disabled',false);

			if(!response.status)
			{
				$('#btn-save').html('Save');
				toastMsg("error",response.msg);
				return false;
			}
			
			init_dataTable();
			
			$('#ModalForm').trigger("reset");
			$('#UserModal').modal('hide');
			$('#btn-save').html('Save');
			toastMsg("success",response.msg);
		}
	});
	
});

function edituser(e) 
{
	var pri_id = $(e).data('id');
	if(pri_id == '')
		return false;

	$("#change_password_div").show();
	$("#change_password").prop("checked",false);
	$("#password_div").hide();
	
	$("#password").removeAttr("required");
	$("#password").removeAttr("minlength");
	
	$("#con_password").removeAttr("required");
	$("#con_password").removeAttr("minlength");
				
	$("#password").val("");
	$("#con_password").val("");
	
	$.ajax({
		data: { "pri_id" : pri_id },
		url: '<?= base_url("admin/editUser");?>',
		type: "POST",
		dataType: 'json',
		success: function (data) {
			
			$('#ModalLabel').html("");
			$('#ModalLabel').html("Edit User");
			$('#btn-save').val("edit-user");
			$('#pri_id').val(data.id);
			$('#name').val(data.u_name);
			$('#email').val(data.u_email);
			$('#uname').val(data.user_name);
			$('#role_id').val(data.role_id);
			$('#status_id').val(data.u_status);
			$('#phone').val(data.phone);
			
			$('#UserModal').modal('show');
		}
	});
}

function deleteuser(e)
{
	var pri_id = $(e).data("id");
	if(confirm("Are You sure want to delete !")) {

	$.ajax({
		type: "POST",
		data: { "pri_id" : pri_id },
		url: '<?= base_url("admin/deleteUser");?>',
		success: function (data) {
			init_dataTable();
			toastMsg("success","User Successfully Deleted!");
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
   }
}

function change_pass(e)
{
	$("#password").val("");
	$("#con_password").val("");
	var value = $(e).prop("checked");	
	if(value)
	{
		$("#password_div").show();
		$("#password").attr({"required":true, "minlength":8});
		$("#con_password").attr({"required":true, "minlength":8});
	}else{
		$("#password_div").hide();
		$("#password").removeAttr("required");
		$("#password").removeAttr("minlength");
		
		$("#con_password").removeAttr("required");
		$("#con_password").removeAttr("minlength");
	}
}
</script>