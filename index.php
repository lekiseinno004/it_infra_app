<?php include("include/head.php"); ?>
<?php include("class/connect.php"); ?>
<?php 
			$class_con_LeKise_Group = new Sqlsrv_LeKise_Group();
            $class_con_LeKise_Group->getConnect();
            // Select
            $query=$class_con_LeKise_Group->getQuery("
                SELECT company_Code,department_Code,department_Name
                FROM department
                WHERE company_Code='LKL'
                OR company_Code='LKS'
                OR company_Code='LKT'
                OR company_Code='OMP'
                OR company_Code='WTL'
            ");
            while($result=$class_con_LeKise_Group->getResult($query)){
                $company_Code[] = $result["company_Code"];
                $department_Code[] = $result["department_Code"];
                $department_Name[] = $result["department_Name"];
            }
?>
<style type="text/css">
	.bg-green{
		background-color: #008000;	
		color: #FFFFFF;
	}
	.bg-red{
		background-color: #FF0000;	
		color: #FFFFFF;
	}
</style>
<body id="page-top">
	<!-- Page Wrapper -->
  <div id="wrapper">

    <?php include("include/sidebar.php") ?>
	<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
      	<!-- Topbar -->
        <?php include("include/Topnav.php"); ?>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        		<div class="container-fluid">
					<div class="row">
					<div class="col-lg-12">

		              <!-- Circle Buttons -->
		              <form action="process/update_data.php" method="POST">
		              	<div class="card shadow mb-4">
		                <div class="card-header py-3">
		                  <h6 class="m-0 font-weight-bold text-primary">Printer Form (ส่งซ่อมปริ้นเตอร์)</h6>
		                </div>
		                <div class="card-body" style="display: inline-flex;">
		                  	<div class="col-sm-3">
								<input type="text" name="brand" id="brand" placeholder="Brand" class="form-control" required>
							</div>
							<div class="col-sm-3">
								<input type="text" name="model" id="model" placeholder="Model" class="form-control" required>
							</div>
							<div class="col-sm-3">
								<input type="text" name="supplier" id="supplier" placeholder="Supplier" class="form-control" required> 
							</div>
							<div class="col-sm-3">
								<textarea name="remark" id="remark" class="form-control" placeholder="สาเหตุ" required></textarea>
							</div>
						</div>
						<div class="card-body" style="display: inline-flex;">
							<div class="col-sm-3">
								<select name="depart" id="depart" class="form-control" required>
									<option value='#'>แผนกที่ส่งซ่อม</option>
									<?php foreach ($company_Code as $key => $value) {?>
									<option value="<?php echo $value." | ".$department_Name[$key] ?>"><?php echo $value." | ".$department_Name[$key]; ?></option>
									<?php  } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<input type="number" name="num_date" id="num_date" placeholder="จำนวนวัน" class="form-control" required> 
							</div>	
							<div class="col-sm-3" style="padding-bottom: 1%;">
								<select name="status" id="status" class="form-control" required>
									<option value="1">ได้รับ</option>
									<option value="0">ยังไม่ได้รับคืน</option>
								</select>
							</div>
							<div class="col-sm-3" style="text-align: left;">
		                		<input type="hidden" name="method" id="method" value="printer">
								<button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Save</button>
							</div>
		                </div>
		              </div>
		          </form>

		            </div>
					</div>
<?php 
			$class_con_printer = new Sqlsrv_quotation_approve();
			$class_con_printer->getConnect();
            // Select
            $query=$class_con_printer->getQuery("
                SELECT *
                FROM Printer_Approve
            ");
            while($result=$class_con_printer->getResult($query)){
                $id[] = $result["id"];
                $brand[] = $result["brand"];
                $model[] = $result["model"];
                $supplier[] = $result["supplier"];
                $remark[] = $result["remark"];
                $department[] = $result["department"];
                $date_approve[] = $result["date_approve"];
                $num_date[] = $result["num_date"];
                $status[] = $result["status"];
            }
				// $id = array("1","2");
    //             $brand = array("HP","Epson");
    //             $model = array("001","002");
    //             $supplier = array("HP","Epson");
    //             $remark = array("ถาดใส่หมึกเสีย","ถาดใส่กระดาษเสีย");
    //             $department = array("inno","infra");
    //             $date_approve = array("2019-09-13","2019-09-14");
    //             $num_date = array("15","10");
    //             $status = array("1","0");
?>
					<div class="row">
						<div class="col-lg-12">
							<!-- DataTales Example -->
				          <div class="card shadow mb-4">
				            <div class="card-header py-3">
				              <h6 class="m-0 font-weight-bold text-primary">Printer Table</h6>
				            </div>
				            <div class="card-body">
				              <div class="table-responsive">
								<table class="table table-bordered" id="dataTable_printer" width="100%" cellspacing="0">
									<thead>
										<tr align="center">
											<th>ID</th>
											<th>Brand</th>
											<th>Model</th>
											<th>Suplier</th>
											<th>สาเหตุ</th>
											<th>แผนกที่ส่งซ่อม</th>
											<th>วันที่ส่ง</th>
											<th>จำนวนวัน</th>
											<th>สถานะรับคืน</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($id as $row => $ids) { ?>
										<tr align="center">
											<td><?php echo $ids ?></td>
											<td><?php echo $brand[$row] ?></td>
											<td><?php echo $model[$row] ?></td>
											<td><?php echo $supplier[$row] ?></td>
											<td><?php echo $remark[$row] ?></td>
											<td><?php echo $department[$row] ?></td>
											<td><?php echo $date_approve[$row] ?></td>
											<td><?php echo $num_date[$row] ?></td>
											<?php 
												if($status[$row]=="1"){
													$status_bg = "<div class='bg-green'>ได้รับ</div>";
												}else{
													$status_bg = "<div class='bg-red'>ยังไม่ได้รับคืน</div>";
												}
											?>
											<td><?php echo $status_bg; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
				              </div>
				            </div>
				          </div>
						</div>
					</div>
			</div>
		</div>
			 <!-- Footer -->
	      <footer class="sticky-footer bg-white">
	        <div class="container my-auto">
	          <div class="copyright text-center my-auto">
	            <span>Copyright &copy; Data Approved 2019</span>
	          </div>
	        </div>
	      </footer>
	      <!-- End of Footer -->
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#depart').select2();
	});
	$(document).ready(function() {
    	$('#dataTable_printer').DataTable({
    		responsive: true,
    		"lengthMenu": [[-1,50 ,25 ,10], ["All",50 ,25 ,10]]
    	});
	} );
</script>
<?php include("include/footer.php"); ?>