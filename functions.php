<?php

function selectacct ($bk_id) {	
	include "../includedb/new_db_connection.php";
	$sql = "SELECT account_number FROM banks WHERE bk_id='$bk_id'";
    $result = $conn->query($sql);
    while($row = $result->fetch()){  
        echo '<option value="'.$row['account_number'].'">'.$row['account_number'].'</option>'; 
	}
}

function selectinv($clientid) {
	include "../includedb/new_db_connection.php";
	$sql = "SELECT DISTINCT inv_no, name FROM invoice_details JOIN invoice ON invoice_details.clientname=invoice.id WHERE clientname='$clientid'";
    $result = $conn->query($sql);
        while($row = $result->fetch()){  
            echo '<option value="'.$row['inv_no'].'">'.$row['name'].' '.$row['inv_no'].'</option>'; 
        }
}

function getinvno($invno){
	include "../includedb/new_db_connection.php";
	$sql = "SELECT * FROM invoice_details JOIN invoice ON invoice_details.clientname=invoice.id WHERE inv_no='$invno'";
    $result = $conn->query($sql);
    while($row = $result->fetch()){
        echo '<tr> <td scope="col">'.$row["serial_no"].'</td>
        <td scope="col">'.$row["inv_date"].'</td>
        <td scope="col">'.$row["name"].'</td>
        <td scope="col">'.$row["description"].'</td>
        <td scope="col">'.$row["amount"].'</td>
        <td scope="col"> <input type="number" name="amount_paid" id="amount_paid" value="'.$row["amount_paid"].'" class="form-control form-control-sm text-right" disabled>
        <td scope="col"> <input type="number" name="amnt" id="amnt" class="form-control form-control-sm amount"></tr>';
    }
}

function saveinv($acct, $inflowdate, $currency, $income_type, $client_id, $docref, $bank, $invoice, $invdetails){
	include "../includedb/new_db_connection.php";
		$invdetails=json_decode($invdetails, true);
        foreach($invdetails as $cashin){
        $amount=$cashin['col1'];
        $amounttopay=$cashin['col2']; 
        $amountpaid=$cashin['col3'];   
        $sn=$cashin['col4'];
        $stmt=$conn->prepare("INSERT INTO cash_inflow(inflow_date, income_type_id, income_source, currency, amount, inv_ref, document_ref, receiving_bank, account_number) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bindParam(1, $inflowdate, PDO::PARAM_STR);
        $stmt->bindParam(2, $income_type, PDO::PARAM_INT);
        $stmt->bindParam(3, $client_id, PDO::PARAM_STR);
        $stmt->bindParam(4, $currency, PDO::PARAM_INT);
        $stmt->bindParam(5, $amounttopay, PDO::PARAM_INT);
        $stmt->bindParam(6, $invoice, PDO::PARAM_INT);
        $stmt->bindParam(7, $docref, PDO::PARAM_STR);
        $stmt->bindParam(8, $bank, PDO::PARAM_INT);
        $stmt->bindParam(9, $acct, PDO::PARAM_STR);
        $stmt->execute();
        $amtpaid=$amountpaid+$amounttopay;
        $sql = "UPDATE invoice_details SET amount_paid='$amtpaid' WHERE inv_no='$invoice' AND serial_no='$sn'"; 
        $result = $conn->query($sql);     

        // $sql2= "SELECT * FROM invoice_details WHERE inv_no='$invoice' AND serial_no='$sn'";  
        // $stmnt=$conn->query($sql2);
        
        // while($result2=$stmnt->fetch()){
        //     $invamt=$result2['amount'];
        //     $invamtpaid=$result2['amount_paid'];
        //     $pstatus=$result2['pstatus'];
        //     if($invamtpaid<$invamt){
        //         $upd="UPDATE invoice_details SET psatus='not fully paid' WHERE inv_no='$invoice' AND serial_no='$sn'";
        //         $rest = $conn->query($upd);
        //     }
        //     else{
        //         $upd="UPDATE invoice_details SET psatus='paid' WHERE inv_no='$invoice' AND serial_no='$sn'";
        //         $rest = $conn->query($upd);           
        //     }
        // }
    }
    if(isset($result)){
        echo "Invoice payment sucesfully saved";
    }else{
          echo "record(s) not saved";
    }
}

function savegrant($acct, $inflowdate, $currency, $inputamount, $income_type, $docref, $donor, $projectid, $bank){
	include "../includedb/new_db_connection.php";
	$stmt=$conn->prepare("INSERT INTO cash_inflow(inflow_date, income_type_id, income_source, currency, amount, document_ref, costcentre_id, receiving_bank, account_number) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bindParam(1, $inflowdate, PDO::PARAM_STR);
    $stmt->bindParam(2, $income_type, PDO::PARAM_INT);
    $stmt->bindParam(3, $donor, PDO::PARAM_STR);
    $stmt->bindParam(4, $currency, PDO::PARAM_INT);
    $stmt->bindParam(5, $inputamount, PDO::PARAM_INT);
    $stmt->bindParam(6, $docref, PDO::PARAM_STR);
    $stmt->bindParam(7, $projectid, PDO::PARAM_INT);
    $stmt->bindParam(8, $bank, PDO::PARAM_INT);
    $stmt->bindParam(9, $acct, PDO::PARAM_STR);
    $result=$stmt->execute();

    if(isset($result)){
        echo "Grant payment sucesfully saved";
    }else{
          echo "record(s) not saved";
    }
}

function saveloan($acct, $inflowdate, $currency, $inputamount, $income_type, $docref, $lender, $projectid, $bank){
	include "../includedb/new_db_connection.php";
	$stmt=$conn->prepare("INSERT INTO cash_inflow(inflow_date, income_type_id, income_source, currency, amount, document_ref, costcentre_id, receiving_bank, account_number) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bindParam(1, $inflowdate, PDO::PARAM_STR);
    $stmt->bindParam(2, $income_type, PDO::PARAM_INT);
    $stmt->bindParam(3, $lender, PDO::PARAM_STR);
    $stmt->bindParam(4, $currency, PDO::PARAM_INT);
    $stmt->bindParam(5, $inputamount, PDO::PARAM_INT);
    $stmt->bindParam(6, $docref, PDO::PARAM_STR);
    $stmt->bindParam(7, $projectid, PDO::PARAM_INT);
    $stmt->bindParam(8, $bank, PDO::PARAM_INT);
    $stmt->bindParam(9, $acct, PDO::PARAM_STR);
    $result=$stmt->execute();

    if(isset($result)){
        echo "Loan payment sucesfully saved";
    }else{
          echo "record(s) not saved";
    }
}

function saveothers($acct, $inflowdate, $currency, $inputamount, $income_type, $docref, $client, $bank){
	include "../includedb/new_db_connection.php";
	$stmt=$conn->prepare("INSERT INTO cash_inflow(inflow_date, income_type_id, income_source, currency, amount, document_ref, receiving_bank, account_number) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bindParam(1, $inflowdate, PDO::PARAM_STR);
    $stmt->bindParam(2, $income_type, PDO::PARAM_INT);
    $stmt->bindParam(3, $client, PDO::PARAM_STR);
    $stmt->bindParam(4, $currency, PDO::PARAM_INT);
    $stmt->bindParam(5, $inputamount, PDO::PARAM_INT);
    $stmt->bindParam(6, $docref, PDO::PARAM_STR);
    $stmt->bindParam(7, $bank, PDO::PARAM_INT);
    $stmt->bindParam(8, $acct, PDO::PARAM_STR);
    $result=$stmt->execute();

    if(isset($result)){
        echo "Other payment sucesfully saved";
    }else{
          echo "record(s) not saved";
    }
}

function getgrant($inctype, $start_date, $end_date){
	include "../includedb/new_db_connection.php";
	if(empty($start_date) || empty($end_date)){
        echo '<tr><td scope="col" colspan="12" class="text-danger text-center mx-auto"><h3>Please select date range</h3></td></tr>';
    } 
    else{    
        $sql="SELECT inflow_id, inflow_date, cash_inflow.amount, currency, costcentre, income_type, income_source, document_ref, inv_ref, bank_name, cash_inflow.account_number FROM cash_inflow JOIN income_types ON cash_inflow.income_type_id=income_types.income_type_id
        JOIN banks ON cash_inflow.receiving_bank=banks.bk_id 
        JOIN costcentres ON cash_inflow.costcentre_id=costcentres.costid WHERE (cash_inflow.income_type_id='$inctype') AND (inflow_date BETWEEN '$start_date' AND '$end_date') ORDER BY inflow_date ASC"; 
        $result = $conn->query($sql);
        if($result->rowCount() > 0){
            $searchrow = $result->fetchAll();
            foreach($searchrow as $row){
                echo '
                    <tr>
                    <td scope="col" class="text-muted">'.$row["inflow_id"].'</td>
                    <td scope="col" class="text-muted">'.$row["inflow_date"].'</td>
                    <td scope="col" class="text-muted">'.$row["amount"].'</td>
                    <td scope="col" class="text-muted">'.$row["currency"].'</td>
                    <td scope="col" class="text-muted">'.$row["costcentre"].'</td>
                    <td scope="col" class="text-muted">'.$row["income_type"].'</td>
                    <td scope="col" class="text-muted">'.$row["income_source"].'</td> 
                    <td scope="col" class="text-muted"><a href="'.$row["document_ref"].'" target="_blank">'.$row["document_ref"].'</a></td>
                    <td scope="col" class="text-muted">N/A</td>           
                    <td scope="col" class="text-muted">'.$row["bank_name"].'</td>
                    <td scope="col" class="text-muted">'.$row["account_number"].'</td>            
                </tr>';
            }
        }
        else {
            echo '<tr><td scope="col" colspan="12" class="text-danger text-center mx-auto"><h3>No records found between selected dates</h3></td></tr>';
        }
	}
	
}

function getinv($inctype, $start_date, $end_date) {
	include "../includedb/new_db_connection.php";
	if(empty($start_date) || empty($end_date)){
        echo '<tr><td scope="col" colspan="12" class="text-danger text-center mx-auto"><h3>Please select date range</h3></td></tr>';
    } 
    else{    
        $sql="SELECT inflow_id, inflow_date, cash_inflow.amount, currency, income_type, income_source, document_ref, inv_ref, bank_name, cash_inflow.account_number FROM cash_inflow JOIN income_types ON cash_inflow.income_type_id=income_types.income_type_id
        JOIN banks ON cash_inflow.receiving_bank=banks.bk_id 
        JOIN invoice_details ON cash_inflow.inv_ref=invoice_details.inv_no WHERE (cash_inflow.income_type_id='$inctype') AND (inflow_date BETWEEN '$start_date' AND '$end_date') ORDER BY inflow_date ASC"; 
        $result = $conn->query($sql);
        
        if($result->rowCount() > 0){
            $searchrow = $result->fetchAll();
            foreach($searchrow as $row){
                echo '
                    <tr>
                    <td scope="col" class="text-muted">'.$row["inflow_id"].'</td>
                    <td scope="col" class="text-muted">'.$row["inflow_date"].'</td>
                    <td scope="col" class="text-muted">'.$row["amount"].'</td>
                    <td scope="col" class="text-muted">'.$row["currency"].'</td>
                    <td scope="col" class="text-muted">N/A</td>
                    <td scope="col" class="text-muted">'.$row["income_type"].'</td>
                    <td scope="col" class="text-muted">'.$row["income_source"].'</td> 
                    <td scope="col" class="text-muted"><a href="'.$row["document_ref"].'" target="_blank">'.$row["document_ref"].'</a></td>
                    <td scope="col" class="text-muted">'.$row["inv_ref"].'</td>           
                    <td scope="col" class="text-muted">'.$row["bank_name"].'</td>
                    <td scope="col" class="text-muted">'.$row["account_number"].'</td>
                    </tr>';
            }
        }
        else {
            echo '<tr><td scope="col" colspan="12" class="text-danger text-center mx-auto"><h3>No records found between selected dates</h3></td></tr>';
        }
    }
}

function getloan($inctype, $start_date, $end_date){
	include "../includedb/new_db_connection.php";
	if(empty($start_date) || empty($end_date)){
        echo '<tr><td scope="col" colspan="12" class="text-danger text-center mx-auto"><h3>Please select date range</h3></td></tr>';
    } 
    else{    
        $sql="SELECT inflow_id, inflow_date, cash_inflow.amount, currency, costcentre, income_type, income_source, document_ref, inv_ref, bank_name, cash_inflow.account_number FROM cash_inflow JOIN income_types ON cash_inflow.income_type_id=income_types.income_type_id
        JOIN banks ON cash_inflow.receiving_bank=banks.bk_id 
        JOIN costcentres ON cash_inflow.costcentre_id=costcentres.costid WHERE (cash_inflow.income_type_id='$inctype') AND (inflow_date BETWEEN '$start_date' AND '$end_date') ORDER BY inflow_date ASC"; 
        $result = $conn->query($sql);
        $searchrow = $result->fetchAll();
        if($result->rowCount() > 0){
            foreach($searchrow as $row){
                echo '
                    <tr>
                    <td scope="col" class="text-muted">'.$row["inflow_id"].'</td>
                    <td scope="col" class="text-muted">'.$row["inflow_date"].'</td>
                    <td scope="col" class="text-muted">'.$row["amount"].'</td>
                    <td scope="col" class="text-muted">'.$row["currency"].'</td>
                    <td scope="col" class="text-muted">'.$row["costcentre"].'</td>
                    <td scope="col" class="text-muted">'.$row["income_type"].'</td>
                    <td scope="col" class="text-muted">'.$row["income_source"].'</td> 
                    <td scope="col" class="text-muted"><a href="'.$row["document_ref"].'" target="_blank">'.$row["document_ref"].'</a></td>
                    <td scope="col" class="text-muted">N/A</td>           
                    <td scope="col" class="text-muted">'.$row["bank_name"].'</td>
                    <td scope="col" class="text-muted">'.$row["account_number"].'</td>            
                </tr>';
            }
        }
        else {
            echo '<tr><td scope="col" colspan="12" class="text-danger text-center mx-auto"><h3>No records found between selected dates</h3></td></tr>';
        }
    }
}

function getothers($inctype, $start_date, $end_date){
	include "../includedb/new_db_connection.php";
	if(empty($start_date) || empty($end_date)){
        echo '<tr><td scope="col" colspan="12" class="text-danger text-center mx-auto"><h3>Please select date range</h3></td></tr>';
    } 
    else{    
        $sql="SELECT inflow_id, inflow_date, cash_inflow.amount, currency, income_type, income_source, document_ref, bank_name, cash_inflow.account_number FROM cash_inflow JOIN income_types ON cash_inflow.income_type_id=income_types.income_type_id
        JOIN banks ON cash_inflow.receiving_bank=banks.bk_id 
        WHERE (cash_inflow.income_type_id='$inctype') AND (inflow_date BETWEEN '$start_date' AND '$end_date') ORDER BY inflow_date ASC"; 
        $result = $conn->query($sql);
        if($result->rowCount() > 0){
            $searchrow = $result->fetchAll();
            foreach($searchrow as $row){
                echo '
                    <tr>
                    <td scope="col" class="text-muted">'.$row["inflow_id"].'</td>
                    <td scope="col" class="text-muted">'.$row["inflow_date"].'</td>
                    <td scope="col" class="text-muted">'.$row["amount"].'</td>
                    <td scope="col" class="text-muted">'.$row["currency"].'</td>
                    <td scope="col" class="text-muted">N/A</td>
                    <td scope="col" class="text-muted">'.$row["income_type"].'</td>
                    <td scope="col" class="text-muted">'.$row["income_source"].'</td> 
                    <td scope="col" class="text-muted"><a href="'.$row["document_ref"].'" target="_blank">'.$row["document_ref"].'</a></td>
                    <td scope="col" class="text-muted">N/A</td>           
                    <td scope="col" class="text-muted">'.$row["bank_name"].'</td>
                    <td scope="col" class="text-muted">'.$row["account_number"].'</td>            
                </tr>';
            }
        }
        else {
            echo '<tr><td scope="col" colspan="12" class="text-danger text-center mx-auto"><h3>No records found between selected dates</h3></td></tr>';
        }
	}
}


function savebank($bank_name, $account_number){
		include "../includedb/new_db_connection.php";
		$bank=ucfirst(strtolower($bank_name));
        $stmt =$conn->prepare("INSERT INTO banks(bank_name, account_number) VALUES (?,?)");
		$stmt->bindParam(1, $bank, PDO::PARAM_STR);
		$stmt->bindParam(2, $account_number, PDO::PARAM_STR);
        $stmt->execute();

        echo "New Bank added";
}

function editbank($bk_id){
	include "../includedb/new_db_connection.php";
	$sql = "SELECT * FROM banks WHERE bk_id='$bk_id'";
	$result = $conn->query($sql);
	$data = $result->fetch();
	echo json_encode($data);
}

function updatebank($bk_id, $bank_name, $account_number){
	include "../includedb/new_db_connection.php";
	$bank=ucfirst(strtolower($bank_name));
	$sql = "UPDATE banks SET bank_name='$bank', account_number='$account_number' WHERE bk_id='$bk_id'";
	$stmt = $conn->query($sql);
	
	if(isset($stmt)){
		echo "Bank updated successfully";
	}
	else{
		echo "Error updating, please try again!";
	}

}
?>