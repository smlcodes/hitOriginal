<?php
include 'sessionCheck.php';
include 'db.php';

error_reporting(E_ERROR);
session_start();
$uid = $_SESSION['s_uid'];
 
?>
<!DOCTYPE html>
<html>
<head>
   <?php include 'css.php';?>
</head>

<body class="page-header-fixed">
    <div class="overlay"></div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1">
        <h3><span class="pull-left">Chat</span><a href="javascript:void(0);" class="pull-right" id="closeRight"><i class="fa fa-times"></i></a></h3>

    </nav>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
        <h3><span class="pull-left">Sandra Smith</span> <a href="javascript:void(0);" class="pull-right" id="closeRight2"><i class="fa fa-angle-right"></i></a></h3>
    </nav>
 
    <!-- Search Form -->
    <main class="page-content content-wrap">
        <?php include 'navbar.php';?>
       	<div class="page-sidebar sidebar">
                  <?php include('sidemenu.php');  ?>  
                <!-- Page Sidebar Inner -->
            </div>
            <!-- Page Sidebar -->
		    <div class="page-inner">            
           	<div id="main-wrapper">
		
            
        
            
          
              <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Basic example</h4>
                                </div>
                                <div class="panel-body">
                                   <div class="table-responsive">
                                    <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                           		<th>No.</th>
                                                <th>Title</th>
                                                <th>Director</th>
                                                <th>Actors</th>
                                                <th>Result</th>
                                                <th>Budget(Cr's)</th>
                                                <th>Collection(Cr's)</th>
                                                <th>50'Centers</th>
                                                <th>100'Centers</th>
                                            </tr>
                                        </thead>
                                   
                                        <tbody>
                                        <?php 
                                        include 'db.php';
                                        $uid = $_SESSION['s_uid'];
                             			$sql = "SELECT * FROM tolly_ready_for_shoot s WHERE  s.status = 'out'";
                                             			//echo $sql;
                                                    			$result = mysqli_query($conn, $sql);                                                      			
                                                    				
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$i++;
                                                    					
                                                    					$rid = $row["rid"];
                                                    					$title = $row["title"];
                                                    					$dname = $row["dname"];
                                                    					$aname = $row["aname"];
                                                    					$res = $row["result"];
                                                    					$collection= $row["collection"];
                                                    					$budget = $row["sofar"];
                                                    					
                                                    				 $sql2 =	"select * from tolly_release s WHERE s.rid = ".$rid." and s.status = 'out'";
                                                    				$r1= mysqli_query($conn, $sql2);
                                                    				$row1 = mysqli_fetch_assoc($r1);
                                                    				
                                                    				$c50 = $row1["50d_cen"];
                                                    				$c100 = $row1["100d_cen"]; 
                                          		echo "<tr>";
                                          		echo "<td><b>".$rid."</b></td>";
                                             	echo "<td><a href='movie.php?rid=".$rid."' class='btn btn-danger btn-rounded'>".$title."</a></td>";
                                             	echo "<td><b>".$dname."</b></td>";
                                             	echo "<td><b>".$aname."</b></td>";
                                             	echo "<td><button type='button' class='btn btn-info'>".$res."</button></td>";
                                             	echo "<td>".round($budget/10000000, 2)."</td>";
                                             	echo "<td>".round($collection/10000000, 2)."</td>";
                                             	 echo "<td>".$c50."</td>";
                                             	echo "<td>".$c100."</td>";
                                            	echo " </tr> ";
                                          
                                                    				}
                                                    			}
                                            ?>
                                            
                                            
                                        </tbody>
                                       </table>  
                                    </div>
                                </div>
                            </div>
							</div>
							</div>
							
            
            
          
          
          
          
           
            <!-- Main Wrapper -->

   		 
            <div class="page-footer">
                <p class="no-s">2015 &copy; HitandFut.com</p>
            </div>
        </div>
        <!-- Page Inner -->
    </main>
    <!-- Page Content -->
  
    <div class="cd-overlay"></div>

	<?php include 'js.php';?>
	<script type="text/javascript"
		src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['gauge']}]}"></script>

	
	

</body>

</html> <?php mysql_close($conn);?>