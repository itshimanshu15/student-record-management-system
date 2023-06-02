<?php
include('includes/config.php');
if(!empty($_POST["departmentid"])) 
{
 $did=intval($_POST['departmentid']);
 if(!is_numeric($did)){
 
 	echo htmlentities("invalid Department");exit;
 }
 else{
 $stmt = $dbh->prepare("SELECT StudentName,StudentId FROM tblstudents WHERE DepartmentId= :id order by StudentName");
 $stmt->execute(array(':id' => $did));
 ?><option value="">Select Student </option><?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 {
  ?>
<option value="<?php echo htmlentities($row['StudentId']); ?>"><?php echo htmlentities($row['StudentName']); ?></option>
<?php
 }
}

}

// Code for Subjects attendance
if(!empty($_POST["departmentid1"])) 
{
 $did1=intval($_POST['departmentid1']);
 if(!is_numeric($did1)){
 
  echo htmlentities("invalid Department");exit;
 }
 else{
 $status=0;	
 $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName,tblsubjects.id FROM tblsubjectcombination join  tblsubjects on  tblsubjects.id=tblsubjectcombination.SubjectId WHERE tblsubjectcombination.DepartmentId=:did and tblsubjectcombination.status!=:stts order by tblsubjects.SubjectName");
 $stmt->execute(array(':did' => $did1,':stts' => $status));
 
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 {?>
<p> <?php echo htmlentities($row['SubjectName']); ?><input type="text" name="attendance[]" value="" class="form-control"
        required="" placeholder="Enter attendance out of 100" autocomplete="off"></p>

<?php  }
}
}
?>

<?php

if(!empty($_POST["studentclass"])) 
{
 $id= $_POST['studentclass'];
 $dta=explode("$",$id);
$id=$dta[0];
$id1=$dta[1];
 $query = $dbh->prepare("SELECT StudentId,DepartmentId FROM tblattendance WHERE StudentId=:id1 and DepartmentId=:id ");
//$query= $dbh -> prepare($sql);
$query-> bindParam(':id1', $id1, PDO::PARAM_STR);
$query-> bindParam(':id', $id, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{ ?>
<p>
    <?php
echo "<span style='color:red'> Attendance Already Declare .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
 ?></p>
<?php }
  }  
?>