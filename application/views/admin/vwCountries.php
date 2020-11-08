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
                  <h3>Countries</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL."admin/countries";?>"><i data-feather="flag"></i></a></li>
                    <li class="breadcrumb-item">Countries</li>
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
								<h5>Countries</h5>
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
							<th>Country Code</th>
                            <th>Falg</th>
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
			"url":'<?= base_url("admin/showCountries");?>',
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

function updatecountry(e) 
{
	var pri_id = $(e).data('id');
	var status = $(e).prop("checked");
	if(pri_id == '')
		return false;
	
	$.ajax({
		data: { "pri_id" : pri_id , "status" : status },
		url: '<?= base_url("admin/updateCountry");?>',
		type: "POST",
		dataType: 'json',
		success: function (data) {			
			init_dataTable();
			toastMsg("success","Country Status Successfully Updated!");
		}
	});
}

function deletecountry(e)
{
	var pri_id = $(e).data("id");
	if(confirm("Are You sure want to delete !")) {

	$.ajax({
		type: "POST",
		data: { "pri_id" : pri_id },
		url: '<?= base_url("admin/deleteCountry");?>',
		success: function (data) {
			init_dataTable();
			toastMsg("success","Country Successfully Deleted!");
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
   }
}

</script>