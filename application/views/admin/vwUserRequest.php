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
                  <h3>User Request</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL."admin/userRequest";?>"><i data-feather="box"></i></a></li>
                    <li class="breadcrumb-item">User Request</li>
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
								<h5>User Request</h5>
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
							<th>E-mail</th>
                            <th>Phone</th>
                            <th>Status</th>
							<th>Amount</th>
                            <th>ID Card</th>
							<th>Document</th>
							<th>Address</th>
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
	
<div class="modal fade" id="userRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
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
					<label class="col-sm-3 col-form-label">Name</label>
					<div class="col-sm-9">
					  <input class="form-control" type="text" placeholder="Name" id="name" name="name" required title="Name" >
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Email</label>
					<div class="col-sm-9">
					  <input class="form-control" type="email" placeholder="Email" id="email" name="email" required title="Email" >
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Phone</label>
					<div class="col-sm-9">
					  <input class="form-control m-input digits" type="tel" placeholder="Phone" id="phone" name="phone" required title="Phone" >
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Status</label>
					<div class="col-sm-9">
						<select class="form-control form-control-inverse btn-square" name="status_id" id="status_id">
							<option value="1">Active</option>
							<option value="0">In-Active</option>
						</select>
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Vendor Image</label>
					<div class="col-sm-9">
					  <input class="form-control" type="file" id="vndr_img" name="vndr_img" onchange="allowonlyImg(this)" title="Allow only <?php echo implode(',',Allow_Only_Img);?> file format" >
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Vendor Image Url</label>
					<div class="col-sm-9">
					  <input class="form-control" type="text" placeholder="Vendor Image Url" id="vndr_img_url" name="vndr_img_url" title="Vendor Image Url" >
					</div>
				  </div>
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Address</label>
					<div class="col-sm-9">
					  <textarea class="form-control" rows="2" cols="5" placeholder="Address" id="address" name="address" title="Address" ></textarea>
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
			"url":'<?= base_url("admin/showUserRequests");?>',
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

jQuery('#ModalForm').submit(function(event)
{
	return false;
	event.preventDefault();
	
	if($("#name").val() == "" || $("#name").val() == " " || $("#name").val() == "-" )
	{
		alert("Please Enter Vendor Name");
		return false;
	}
	if($("#email").val() == "" || $("#email").val() == " " || $("#email").val() == "-" )
	{
		alert("Please Enter Vendor E-mail");
		return false;
	}
	if($("#phone").val() == "" || $("#phone").val() == " " || $("#phone").val() == "-" )
	{
		alert("Please Enter Vendor Phone");
		return false;
	}
	
	if($("#pri_id").val() == "")
	{
		if($("#vndr_img").val() == "" || $("#vndr_img").val() == " " || $("#vndr_img").val() == "-" )
		{
			alert("Please Upload Vendor Image");
			return false;
		}
	}
	
	var actionType = $('#btn-save').val();
	$('#btn-save').html('Sending..');

	$('#btn-save').attr('disabled',true);
	
	jQuery.ajax({
		url: '<?= base_url("admin/saveUserRequest");?>',
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
			$('#userRequestModal').modal('hide');
			$('#btn-save').html('Save');
			toastMsg("success",response.msg);
		}
	});
	
});

function edituserRequest(e) 
{
	return false;
	var pri_id = $(e).data('id');
	if(pri_id == '')
		return false;

	$.ajax({
		data: { "pri_id" : pri_id },
		url: '<?= base_url("admin/editUserRequest");?>',
		type: "POST",
		dataType: 'json',
		success: function (data) {			
			$('#ModalLabel').html("");
			$('#ModalLabel').html("Edit Menu");
			$('#btn-save').val("edit-user");
			$('#pri_id').val(data.id);
			$('#name').val(data.c_name);
			$('#email').val(data.c_email);
			$('#phone').val(data.c_phone);
			$('#status_id').val(data.c_status);
			$('#vndr_img_url').val(data.c_img_url);
			$('#address').html(data.c_address);
			$('#userRequestModal').modal('show');
		}
	});
}

function deleteuserRequest(e)
{
	return false;
	var pri_id = $(e).data("id");
	if(confirm("Are You sure want to delete !")) {

	$.ajax({
		type: "POST",
		data: { "pri_id" : pri_id },
		url: '<?= base_url("admin/deleteUserRequest");?>',
		success: function (data) {
			init_dataTable();
			toastMsg("success","User Request Successfully Deleted!");
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
   }
}

</script>