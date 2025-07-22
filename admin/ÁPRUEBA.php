<?php
	include 'includes/session.php';

	function generateRow($conn){
		$contents = '';
		
		$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id ORDER BY attendance.date DESC, attendance.time_in DESC";

		$query = $conn->query($sql);
		$total = 0;
        $conta1=0;
		while($row = $query->fetch_assoc()){
            $conta1=$conta1+1;
            $status = ($row['status'])?'<span class="label label-warning pull-right">a tiempo</span>':'<span class="label label-danger pull-right">tarde</span>';
			$contents .= "
			<tr>
                <td>".$conta1."</td>
                <td>".$row['date']."</td>
                <td>".$row['employee_id']."</td>
				<td>".$row['lastname'].", ".$row['firstname']."</td>
                <td>".date('h:i A', strtotime($row['time_in']))."</td>
                <td>".date('h:i A', strtotime($row['time_out']))."</td>
                <td>".$status."</td>
				
			</tr>
			";
		}

		return $contents;
	}

	require_once('../tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('SIS - Horario del empleado');  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
        
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
      	<h2 align="center">SIS-ASIS</h2>
      	<h4 align="center">ASISTENCIA</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                <th width="5%" align="center"><b>N°</b></th> 
                <th width="15%" align="center"><b>Fecha</b></th> 
           		<th width="18%" align="center"><b>DNI Empleado</b></th>
                <th width="25%" align="center"><b>Nombre de empleado</b></th> 
                <th width="14%" align="center"><b>Ingreso</b></th>
                <th width="14%" align="center"><b>Salida</b></th>
                <th width="13%" align="center"><b>Condición</b></th>
                
				
           </tr>  
      ';  
    $content .= generateRow($conn); 
    $content .= '</table>';  
    $pdf->writeHTML($content);  
    $pdf->Output('schedule.pdf', 'I');

?>