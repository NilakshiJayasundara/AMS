<?php



 // return $output;

  // require("fpdf/fpdf.php");
  //   $pdf=new FPDF();
  //   $pdf->Addpage();
  //   $pdf->Setfont("Arial","B",16);
  // $pdf->Cell(0,10,"welcome",1,1,"C");
  // $pdf->Cell(50,10,"name:",1,0);
  // $pdf->Cell(50,10,"name:",1,0);
  // $pdf->Cell(50,10,"name:",1,0);

 // $pdf->Cell(50,10,$row['name'],1,1);
 
    
// if(isset($_POST['submityear'])){
// 	echo "kjsbfkjbf";
// }
 // if(isset($_POST["submityea"])){
	require_once('../tcpdf/Tcpdf.php');
	
	 $obj_pdf= new TCPDF('p', PDF_UNIT, PDF_PAGE_FORMAT,true,'UTF-8',false);
	 $obj_pdf->SetCreator(PDF_CREATOR);
	 $obj_pdf->SetTitle("Report");
	 $obj_pdf->SetHeaderData(",",PDF_HEADER_TITLE, PDF_HEADER_STRING);
 $obj_pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
	 // $obj_pdf->SetFooterFont(Array(PDF_FONT_NAME_DATÁ,'',PDF_FONT_SIZE_DATA));
	 $obj_pdf->SetDefaultMonospacedFont('helvetica');
	 $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	 $obj_pdf->SetMargins(PDF_MARGIN_LEFT,'10',PDF_MARGIN_RIGHT);
	 $obj_pdf->SetPrintHeader(false);
	$obj_pdf->SetPrintFooter(false);
	 $obj_pdf->SetAutoPageBreak(TRUE,10);
	 $obj_pdf->SetFont('helvetica','',11);
	 $obj_pdf->AddPage();
	$content='';
	$content .='<h4 align="center">Genarate Reports</h4><br /><table border="1" cellingspacing="0" cellpadding="3">
	<tr>
	  <th bgcolor="#18FFFF">Date</th>
	  <th bgcolor="#18FFFF">Event Ref</th>
	  <th bgcolor="#18FFFF">Ticket Value</th>
	  <th bgcolor="#18FFFF">Category</th>


	</tr>';


function fetch_date(){
	include('../includes/connection.php') ;
$output='';
 
$year=$_POST['year'];
  $startdate="$year-01-01";
  $enddate="$year-12-31";
  $sql="SELECT * FROM sales WHERE date between '$startdate' and '$enddate'"  ;
  $query=mysqli_query($connection,$sql);


  $sql1="SELECT * FROM sales WHERE ticketValue";
  $query1=mysqli_query($connection,$sql);

$total=0;
   while($row=mysqli_fetch_array($query)){
  		 $ticket= $row['ticketValue'];
  			
  			$category=$row['Catagory'];
  			 $totalone=$ticket*$category;
  			 
  			 $total=$totalone+$total;

 	$output.= '<tr>

 	            <td bgcolor="#84FFFF">'.$row["Date"].'</td>
 	            <td bgcolor="#84FFFF">'.$row["eventRef"].'</td>
 	            <td bgcolor="#84FFFF">'.$row["ticketValue"].'</td>
 	            <td bgcolor="#84FFFF">'.$row["Catagory"].'</td>

 	              
				</tr> ';

 	          

 	

 }
 $output.='<p>Total LKR'. $total.'</p>';
  return $output;
}
fetch_date();
	 $content.=fetch_date();
	 $content.='</table>';
	 $obj_pdf->writeHTML($content);
	 $obj_pdf->output('file.pdf','I');







 ?>