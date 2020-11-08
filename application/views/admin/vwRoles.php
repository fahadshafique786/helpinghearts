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
                  <h3>Roles</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL."admin/roles";?>"><i data-feather="lock"></i></a></li>
                    <li class="breadcrumb-item">Roles</li>
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
								<h5>Roles</h5>
							</div>
							<div class="col-sm-2">
								<button class="btn btn-primary" type="button" onclick="addrole()">Add Role</button>
							</div>
						</div>
					</div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="display" id="dataTable">
                        <thead>
                          <tr>
							<th>Sr. #</th>
                            <th>Name</th>
							<th>Permission</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                          
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
	
<div class="modal fade" id="RoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="ModalLabel"></h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	  </div>
	  <form class="form theme-form" id="ModalForm" action="" method="post" enctype="multipart/form-data">
		  <div class="modal-body">
			<?php echo create_csrfinput(); ?>	
			<input type="hidden" name="pri_id" id="pri_id" />
			<div class="card-body">
			  <div class="row">
				<div class="col">
				  <div class="form-group row">
					<label class="col-sm-2 col-form-label">Name</label>
					<div class="col-sm-4">
					  <input class="form-control" type="text" placeholder="Name" id="name" name="name" required title="Name" >
					</div>
					<label class="col-sm-2 col-form-label">Status</label>
					<div class="col-sm-4">
						<select class="form-control form-control-inverse btn-square" name="status_id" id="status_id">
							<option value="1">Active</option>
							<option value="0">In-Active</option>
						</select>
					</div>
				  </div>
				</div>
			  </div>
				<?php
					$GetMenuData = GetMenuData(true);
					$GetAllPermissions = GetAllPermissions();
					if(!empty($GetMenuData))
					{
						foreach($GetMenuData as $index => $menu)
						{
				?>
							<hr>
							<h5><?php echo $menu->m_name;?></h5>
							<?php 
								if(!empty($GetAllPermissions))
								{ 
									if(isset($GetAllPermissions[$menu->short_code]))
									{
							?>
										<div class="row">
							<?php
											foreach($GetAllPermissions[$menu->short_code] as $PermissionIndex => $permission)
											{
												if(isset($permission->permission_shortcode) && !empty($permission->permission_shortcode))
												{
							?>
													<div class="col-sm-3">
														<div class="checkbox checkbox-dark">
															<input id="<?php echo $permission->permission_shortcode;?>" name="permission[<?php echo $permission->permission_shortcode;?>]" type="checkbox" data-original-title="" title="">
															<label for="<?php echo $permission->permission_shortcode;?>"><?php echo ucwords($permission->action_name);?></label>
														</div>
													</div>
							<?php
												}					
							 			} 	
							?>
										</div>
			<?php
									}
								} 
						}
					}
				?>
			  
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

<div class="modal fade" id="ViewRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="ViewModalLabel">View Permissions</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	  </div>
	  <div class="modal-body">
		<div class="card-body">
			<?php
				$GetMenuData = GetMenuData(true);
				$GetAllPermissions = GetAllPermissions();
				if(!empty($GetMenuData))
				{
					foreach($GetMenuData as $index => $menu)
					{
			?>
						<h5><?php echo $menu->m_name;?></h5>
						<?php 
							if(!empty($GetAllPermissions))
							{ 
								if(isset($GetAllPermissions[$menu->short_code]))
								{
						?>
									<div class="row">
						<?php
										foreach($GetAllPermissions[$menu->short_code] as $PermissionIndex => $permission)
										{
											if(isset($permission->permission_shortcode) && !empty($permission->permission_shortcode))
											{
						?>
												<div class="col-sm-3">
													<div class="checkbox checkbox-solid-primary">
														<input id="view_<?php echo $permission->permission_shortcode;?>" type="checkbox" data-original-title="" title="" disabled>
														<label for="view_<?php echo $permission->permission_shortcode;?>"><?php echo ucwords($permission->action_name);?></label>
													</div>
												</div>
						<?php
											}					
									} 	
						?>
									</div>
		<?php
								}
							} 
					}
				}
			?>
		  
		</div>
	  </div>
	  <div class="modal-footer">
		<button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
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
		searching: false,
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
			"url":'<?= base_url("admin/showRoles");?>',
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

function addrole() 
{
	$('input:checkbox').removeAttr('checked');
	$('#btn-save').val("create-user");
	$('#ModalForm').trigger("reset");
	$('#pri_id').val("");
	$('#ModalLabel').html("");
	$('#ModalLabel').html("Add Role");
	$('#RoleModal').modal('show');
}

jQuery('#ModalForm').submit(function(event)
{
	event.preventDefault();
	
	if($("#name").val() == "" || $("#name").val() == " " || $("#name").val() == "-" )
	{
		alert("Please Enter Role Name");
		return false;
	}
	
	var actionType = $('#btn-save').val();
	$('#btn-save').html('Sending..');

	$('#btn-save').attr('disabled',true);
	
	jQuery.ajax({
		url: '<?= base_url("admin/saveRole");?>',
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
			$('#RoleModal').modal('hide');
			$('#btn-save').html('Save');
			toastMsg("success",response.msg);
		}
	});
	
});

function editrole(e) 
{
	var pri_id = $(e).data('id');
	if(pri_id == '')
		return false;

	$.ajax({
		data: { "pri_id" : pri_id },
		url: '<?= base_url("admin/editRole");?>',
		type: "POST",
		dataType: 'json',
		success: function (data) {	
			
			$('input:checkbox').removeAttr('checked');
			
			$('#ModalLabel').html("");
			$('#ModalLabel').html("Edit Role");
			$('#btn-save').val("edit-user");
			$('#pri_id').val(data.id);
			$('#name').val(data.role_name);
			$('#status_id').val(data.role_status);
			
			var permission_array = '';
			if( data.role_permission_array != "" )
				permission_array = JSON.parse(data.role_permission_array);
			
			$.each( permission_array, function( key, value ) {
			  $("#"+key).attr("checked",true);
			});

			$('#RoleModal').modal('show');
		}
	});
}

function deleterole(e)
{
	var pri_id = $(e).data("id");
	if(confirm("Are You sure want to delete !")) {

	$.ajax({
		type: "POST",
		data: { "pri_id" : pri_id },
		url: '<?= base_url("admin/deleteRole");?>',
		success: function (data) {
			init_dataTable();
			toastMsg("success","Role Successfully Deleted!");
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
   }
}

function showrole(e) 
{
	var pri_id = $(e).data('id');
	if(pri_id == '')
		return false;

	$.ajax({
		data: { "pri_id" : pri_id },
		url: '<?= base_url("admin/editRole");?>',
		type: "POST",
		dataType: 'json',
		success: function (data) {	

			$('input:checkbox').removeAttr('checked');
			
			$('#ViewModalLabel').html("");
			$('#ViewModalLabel').html("View Permissions");
			
			var permission_array = '';
			if( data.role_permission_array != "" )
				permission_array = JSON.parse(data.role_permission_array);
			
			$.each( permission_array, function( key, value ) {
			  $("#view_"+key).attr("checked",true);
			});

			$('#ViewRoleModal').modal('show');
		}
	});
}

</script>