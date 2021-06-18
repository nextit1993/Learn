<?php

require_once ('config/config.php');

$sql = "SELECT * FROM users ORDER BY first_name ASC "; 
$query = mysqli_query($conn, $sql);

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "user_master_" . date('Y-m-d') . ".csv";
    
    #create a file pointer
    $f = fopen('php://memory', 'w');
    
    #set column headers
    $fields = array('SR.NO', 'EMP Code', 'First Name', 'Last Name', 'Email ID', 'Mobile','Building No. & Wing','Room No','Project','Designation','Password','Comp Time');
    fputcsv($f, $fields, $delimiter);
    
     #output each row of the data, format line as csv and write to file pointer
     $i = 1;
    while($row = $query->fetch_assoc()){
        $counter = $i++;
        if($row['quiz_time'] ==''){
            $quiz_time =$row['quiz_time'];
           }else{
            $quiz_time = $row['quiz_time']."&nbsp;Secs";
           }
		   
		   $project =  $row['c_name'];
					$c_name = '';
					if($project == 1)
					{
						$c_name = 'M/s Satre Infrastructure';
					}
					 if($project == 2)
					{
						$c_name = 'M/s Sunita Enterprises';
					}
					 if($project == 3)
					{
						$c_name = 'M/s Ashar Ventures';
					}
					 
		   
        $lineData = array($counter,$row['emp_id'], $row['first_name'], $row['last_name'], $row['email_id'], $row['mobile'], $row['state'],$row['city'],$c_name,$row['designation'],$row['password1r'],$quiz_time);
        fputcsv($f, $lineData, $delimiter);
    }
    
    #move back to beginning of file
    fseek($f, 0);
    
    #set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    #output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>


               
                