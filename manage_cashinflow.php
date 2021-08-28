<?php
    session_start();
    include('../include/config.php');
    include('../../../include/config.php');
    $staffid=implode(',', array_map(function($el){ return $el['idno']; }, get_user($_SESSION['loginid'])));
    $appid= $_SESSION['appid'];
    $submenuid=$_SESSION['csubmenuid'];

extract($_POST);
if($dataname=='showacct'){
    $cashflowin->selectacct($bk_id);
}


if($dataname=='getinvoice'){
    $cashflowin->selectinv($clientid);
}


if($dataname=='getinvdetails'){
    $cashflowin->getinvno($invno);
}


if($dataname=='savecashinvoice'){
    $cashflowin->saveinv($acct, $inflowdate, $currency, $income_type, $client_id, $docref, $bank, $invoice, $invdetails);
    $comment =$staffid . ' added an invoice payment';
    logguser($staffid,$comment,$appid, $submenuid);
    exit();
}


if($dataname=='savegrant'){
    $cashflowin->savegrant($acct, $inflowdate, $currency, $inputamount, $income_type, $docref, $donor, $projectid, $bank);
    $comment =$staffid . ' added a grant payment';
    logguser($staffid,$comment,$appid, $submenuid);
    exit();
}


if($dataname=='saveloan'){
    $cashflowin->saveloan($acct, $inflowdate, $currency, $inputamount, $income_type, $docref, $lender, $projectid, $bank);
    $comment =$staffid . ' added a loan payment';
    logguser($staffid,$comment,$appid, $submenuid);
    exit();
}


if($dataname=='saveothers'){
    $cashflowin->saveothers($acct, $inflowdate, $currency, $inputamount, $income_type, $docref, $client, $bank, $purpose);
    $comment =$staffid . ' added other payments';
    logguser($staffid,$comment,$appid, $submenuid);
    exit();
}

if($dataname=='getreceiptnum'){
    $sql = "SELECT DISTINCT receipt_num, name, inv_ref, inflow_date FROM cash_inflow LEFT JOIN clients ON cash_inflow.income_source=clients.name WHERE inv_ref='$inv_no' ORDER BY receipt_num DESC";
    $result = $con->query($sql);
    $vals = '';
    while($ret = $result->fetch(PDO::FETCH_ASSOC)){
        $vals .= '<option value='.$ret["receipt_num"] .'>' . ucfirst($ret["receipt_num"]) .' | '. ucfirst($ret["inflow_date"]).' | '. ucfirst($ret["name"]).'</option>';
    }
    echo $vals;
}

if($dataname=='view_service_receipt'){
                $sql2 = "SELECT *, SUM(amount) AS invamount FROM cash_inflow  WHERE receipt_num='$receipt_num'";
                $return = $con->query($sql2);
                $val = $return->fetch(PDO::FETCH_ASSOC);
                $totpaid = $val['invamount'];
                $date = date("d-M-Y ", strtotime($val['inflow_date']));
                $receiptnum = $val['receipt_num']; 
                $inv_no = $val['inv_ref'];
                
                $sql = "SELECT * FROM invoice_details LEFT JOIN clients ON invoice_details.clientname=clients.id WHERE inv_no = '$inv_no'";
                $rest = $con->query($sql);
                
                $sql3 = "SELECT *, currencys.currency as curr FROM invoices LEFT JOIN currencys ON invoices.currency=currencys.currencyid JOIN clients ON clients.id=invoices.clientname WHERE inv_no='$inv_no'";
                $result = $con->query($sql3);
                $getinv = $result->fetch(PDO::FETCH_ASSOC);
                $total = $getinv['total_amount'];
                $currency = $getinv['code'];
                $curr = $getinv['curr'];
                $cname = $getinv['name'];
                $jobtype = $getinv['job_type'];
                $caddress = $getinv['address'].', '.$getinv['city'].', '.$getinv['state'];
                    
                    $sq = "SELECT * FROM coy";
                    $reslt = $con->query($sq);
                    $ret = $reslt->fetch(PDO::FETCH_ASSOC);

                    $receipt = '
                        <div class="receipt-content">
                                <div class="container bootstrap snippet">
                                    <div class="row"> 
                                        <div class="col-md-12">    
                                            <div class="invoice-wrapper">
                                            <div class="row">
                                               <div class="intro mt-2 mb-n3 col-sm-6">
                                        <img src="logo.png" height="80px" width="250px" alt="">
                                    </div> 
                                    <div class="col-sm-6">
                                        <table class="table-sm table-borderless mt-3 float-right">
                                            <tbody>
                                                <tr style="line-height:10px">
                                                    <td class="text-muted">Recipt No.</td>
                                                    <td class="font-weight-bold">'.$receiptnum.'</td>
                                                </tr>
                                                <tr style="line-height:10px">
                                                    <td class="text-muted"> Date</td>
                                                    <td class="font-weight-bold">'.$date.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                      
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <h4 class="mx-auto mt-2">RECEIPT</h4>
                                </div>        
                                                <div class="payment-info">
                    
                                                    <div class="row mb-3">
                                                        <div class="col-sm-6">
                                                            To: <strong>'.$cname.'</strong>
                                                            <small>'.$caddress.'</small>
                                                        </div>
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4">
                                            From: <strong>'.ucfirst($ret['cfullname']).'</strong>
                                            <small>'.$ret['caddress1'].', '.$ret['caddress2'].', '.$ret['city'].'</small><br>
                                            <small>'.$ret['state'].', '.$ret['country'].'</small><br>
                                            <small>'.$ret['cemail'].'</small><br>
                                            <small>'.$ret['cphoneno1'].'</small>
                                                    </div>                                                                                                            </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <table class="table table-sm table-bordered" style="background-color: #ececec">
                                                            <thead class="text-center"> 
                                                            <tr class="p-auto" style="line-height:10px;">';
                                if($jobtype == 'Item'){
                                        $receipt .= '<th scope="col">Description</th>
                                                                <th scope="col">Qty</th>
                                                                <th scope="col">Unit Price</th>
                                                                <th scope="col">Amount Charged</th>
                                                 
                                                            </tr>
                                                            </thead>
                                                            <tbody>';
                
                                        while($inv = $rest->fetch(PDO::FETCH_ASSOC)){
                                            
                                            $desc = $inv['description'];
                                            $quantity = $inv['quantity'];
                                            $price = $inv['price'];
                                            $amount = $inv['amount'];
                                           
                                                                $receipt .= '<tr class="text-justify p-auto" style="line-height:10px;">
                                                                        <td>'.$desc.'</td>
                                                                        <td><span class="float-right">'.$quantity.'</span></td>
                                                                        <td><span class="float-right">'.number_format($price, 2, '.', ',').'</span></td>
                                                                        <td><span class="float-right">'.number_format($amount, 2, '.', ',').'</span></td>
                                                                       
                                                                    </tr> 
                                                                     
                                                                    ';
                }          
                                $receipt .= '<tr>
                                                <td class="font-weight-bold text-right"  colspan="3">Total</td>
                                                <td class="font-weight-bold"><span class="float-right"><span>'.$currency .' </span> '. number_format($total, 2, '.', ',').'</span></td>
                                            </tr>';
                                            
                                $receipt .= '<tr>
                                                <td class="font-weight-bold text-right" colspan="3">Amount Paid</td>
                                                <td class="font-weight-bold"><span class="float-right"><span>'.$currency .' </span> '. number_format($totpaid, 2, '.', ',').'</span></td>
                                            </tr>';
                                            
                    }
                                    
                            else if($jobtype == 'Services'){
                                $receipt .=     '<th scope="col">Description</th>
                                                                <th scope="col">Amount Charged</th>
                                                                
                                                            </tr>
                                                            </thead>
                                                            <tbody>';
                
                                        while($inv = $rest->fetch(PDO::FETCH_ASSOC)){
                                            
                                            $desc = $inv['description'];
                                            $amount = $inv['amount'];
                                           
                                                                $receipt .= '<tr class="text-justify p-auto" style="line-height:10px;">
                                                                        <td>'.$desc.'</td>
                                                                        <td><span class="float-right">'.number_format($amount, 2, '.', ',').'</span></td>
                                                                    </tr> 
                                                                     
                                                                    ';
                }          
                                                            $receipt .= '<tr>
                                                                        <td class="font-weight-bold text-right"  >Total</td>
                                                                        <td class="font-weight-bold"><span class="float-right"><span>'.$currency .' </span> '. number_format($total, 2, '.', ',').'</span></td>
                                                                        </tr>';
                                $receipt .= '<tr>
                                                <td class="font-weight-bold text-right">Deposit</td>
                                                <td class="font-weight-bold"><span class="float-right"><span>'.$currency .' </span> '. number_format($totpaid, 2, '.', ',').'</span></td>
                                            </tr>';
                            }
                                
                                            $receipt .=  '                                                      </tbody>
                                                            </table>
                                                </div>
                        
                                                <div class="row my-3 mb-5">
                                                    <div class="col border-bottom ">
                                                        <h6 class="font-weight-bold">Amount in Words:  <span class="ml-5">'.$cashflowin->numberTowords($totpaid).' '.ucfirst($curr).' Only</span> </h6>
                                                    </div>
                                                </div>
                                                <div class="row my-3 mt-5">
                                                    <div class="col mx-2">
                                    <hr>
                                    <p class="text-center">SIGNATURE (Organization)</p>
                                </div>

                                <div class="col mx-2">
                                    <hr>
                                    <p class="text-center">SIGNATURE (Client)</p>
                                </div>
                                                </div>
                                                 <div class="row mb-2 d-flex justify-content-center">
                                    <small>Renewable Energy is the Future ||  www.protergiaenergy.com</small>
                                </div>
                    
                    
                                                </div>
                                            </div>
                                           
                            
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                    </div>  ';
            echo "$receipt";
            
    $comment =$staffid . ' viewed an invoice receipt';
    logguser($staffid,$comment,$appid, $submenuid);
    exit();
}


if($dataname=='view_grant_receipt'){
    $sql = "SELECT *, cash_inflow.amount AS amt, currencys.currency AS curr FROM cash_inflow
    JOIN costcentres ON cash_inflow.costcentre_id=costcentres.costid
    LEFT JOIN currencys ON cash_inflow.currency = currencys.currencyid WHERE inflow_id = '$inflow_id'";
    $result = $con->query($sql);
    $ret = $result->fetch(PDO::FETCH_ASSOC);

    $cname = $ret['income_source'];
    $caddress = $ret['income_source'];
    $date = date("d-M-Y ", strtotime($ret['inflow_date']));
    $desc = $ret['costcentre'];
    $total = $ret['amt'];
    $currency = $ret['code'];
    $curr = $ret['curr'];
    $receiptnum = $ret['receipt_num'];
    
    $sq = "SELECT * FROM coy";
    $reslt = $con->query($sq);
    $ret = $reslt->fetch(PDO::FETCH_ASSOC);

    $receipt = '
    <div class="receipt-content">
            <div class="container bootstrap snippet">
                <div class="row"> 
                    <div class="col-md-12">    
                        <div class="invoice-wrapper mb-4">
                                <div class="row">
                                               <div class="intro mt-2 mb-n3 col-sm-6">
                                        <img src="logo.png" height="80px" width="250px" alt="">
                                    </div> 
                                    <div class="col-sm-6">
                                        <table class="table-sm table-borderless mt-3 float-right">
                                            <tbody>
                                                <tr style="line-height:10px">
                                                    <td class="text-muted">Recipt No.</td>
                                                    <td class="font-weight-bold">'.$receiptnum.'</td>
                                                </tr>
                                                <tr style="line-height:10px">
                                                    <td class="text-muted"> Date</td>
                                                    <td class="font-weight-bold">'.$date.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                      
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <h4 class="mx-auto mt-2">RECEIPT</h4>
                                </div>    
                                
                            <div class="payment-info">

                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        To: <strong>'.$cname.'</strong>'.$caddress.'
                                    </div>
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-4">
                                        From: <br><strong>'.ucfirst($ret['cfullname']).'</strong>
                                            <small>'.$ret['caddress1'].', '.$ret['caddress2'].', '.$ret['city'].'</small><br>
                                            <small>'.$ret['state'].', '.$ret['country'].'</small><br>
                                            <small>'.$ret['cemail'].'</small><br>
                                            <small>'.$ret['cphoneno1'].'</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <table class="table table-sm table-bordered" style="background-color: #ececec">
                                        <thead>                        
                                            
                                        <tr class="text-center">
                                            <th scope="col">Description</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                <tr class="text-center">
                                                    <td>'.$desc.'</td>
                                                    <td><span class="float-right">'.number_format($total, 2, '.', ',').'</span></td>
                                                </tr> 
                                                <tr>
                                                    <td class="font-weight-bold text-right">TOTAL</td>
                                                    <td class="font-weight-bold"><span class="float-right"><span>'.$currency .' </span> '.number_format($total, 2, '.', ',').'</span></td>
                                                </tr> 
                                        </tbody>
                                        </table>
                            </div>
    
                            <div class="row my-3 mb-5">
                                <div class="col border-bottom ">
                                    <h6 class="font-weight-bold">Amount in Words:  <span class="ml-5">'.$cashflowin->numberTowords($total).' '.ucfirst($curr).' Only</h6>
                                </div>
                            </div>
                            <div class="row my-3 mt-5">
                                <div class="col mx-2">
                                    <hr>
                                    <p class="text-center">SIGNATURE (Organization)</p>
                                </div>

                                <div class="col mx-2">
                                    <hr>
                                    <p class="text-center">SIGNATURE (Client)</p>
                                </div>
                            </div>
                            
                             <div class="row mb-2 d-flex justify-content-center">
                                    <small>Renewable Energy is the Future ||  www.protergiaenergy.com</small>
                            </div>


                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
        
        </div>
    </div>  ';

    echo "$receipt";
    
    $comment =$staffid . ' viewed a grant receipt';
    logguser($staffid,$comment,$appid, $submenuid);
    exit();

}


if($dataname=='view_other_receipt'){
    $sql = "SELECT *, currencys.currency AS curr FROM cash_inflow 
    LEFT JOIN currencys ON cash_inflow.currency = currencys.currencyid WHERE inflow_id = '$inflow_id'";
    $result = $con->query($sql);
    $ret = $result->fetch(PDO::FETCH_ASSOC);

    $cname = $ret['income_source'];
    $caddress = $ret['income_source'];
    $date = date("d-M-Y ", strtotime($ret['inflow_date']));
    $desc = $ret['purpose'];
    $total = $ret['amount'];
    $curr = $ret['curr'];
    $currency = $ret['code'];
    $receiptnum = $ret['receipt_num'];
    
    $sq = "SELECT * FROM coy";
    $reslt = $con->query($sq);
    $ret = $reslt->fetch(PDO::FETCH_ASSOC);

    $receipt = '
    <div class="receipt-content">
            <div class="container bootstrap snippet">
                <div class="row"> 
                    <div class="col-md-12">    
                        <div class="invoice-wrapper mb-4">
                                <div class="row">
                                               <div class="intro mt-2 mb-n3 col-sm-6">
                                        <img src="logo.png" height="80px" width="250px" alt="">
                                    </div> 
                                    <div class="col-sm-6">
                                        <table class="table-sm table-borderless mt-3 float-right">
                                            <tbody>
                                                <tr style="line-height:10px">
                                                    <td class="text-muted">Recipt No.</td>
                                                    <td class="font-weight-bold">'.$receiptnum.'</td>
                                                </tr>
                                                <tr style="line-height:10px">
                                                    <td class="text-muted"> Date</td>
                                                    <td class="font-weight-bold">'.$date.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                      
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <h4 class="mx-auto mt-3 mb-n2">RECEIPT</h4>
                                </div>  
                                
                            <div class="payment-info">

                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        To: <strong>'.$cname.'</strong>'.$caddress.'
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        
                                    </div>
                                    <div class="col-sm-4">
                                        <big>'.strtoupper($ret['cfullname']).'</big><br>
                                            <small>'.$ret['caddress1'].', '.$ret['caddress2'].', '.$ret['city'].'</small><br>
                                            <small>'.$ret['state'].', '.$ret['country'].'</small><br>
                                            <small>'.$ret['cemail'].'</small><br>
                                            <small>'.$ret['cphoneno1'].'</small>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                                <table class="table table-sm table-bordered" style="background-color: #ececec">
                                        <thead>                        
                                            
                                        <tr class="text-center">
                                            <th scope="col">Description</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                <tr class="text-center">
                                                    <td>'.$desc.'</td>
                                                    <td><span class="float-right">'.$total.'</span></td>
                                                </tr> 
                                                <tr>
                                                    <td class="font-weight-bold text-right">TOTAL</td>
                                                    <td class="font-weight-bold"><span class="float-right"><span>'.$currency .' </span> '. $total.'</span></td>
                                                </tr> 
                                        </tbody>
                                        </table>
                            </div>
    
                            <div class="row my-3 mb-5">
                                <div class="col border-bottom ">
                                    <h6 class="font-weight-bold">Amount in Words:  <span class="ml-5">'.$cashflowin->numberTowords($total).' '.ucfirst($curr).' Only</span> </h6>
                                </div>
                            </div>
                            <div class="row my-3 mt-5">
                                <div class="col mx-2">
                                    <hr>
                                    <p class="text-center">SIGNATURE (Organization)</p>
                                </div>

                                <div class="col mx-2">
                                    <hr>
                                    <p class="text-center">SIGNATURE (Client)</p>
                                </div>
                            </div>
                            
                             <div class="row mb-2 d-flex justify-content-center">
                                    <small>Renewable Energy is the Future ||  www.protergiaenergy.com</small>
                                </div>


                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
        
        </div>
    </div>  ';

    echo "$receipt";
    
    $comment =$staffid . ' viewed other paymemts receipt';
    logguser($staffid,$comment,$appid, $submenuid);
    exit();

}


?>