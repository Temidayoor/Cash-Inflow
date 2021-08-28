<?php
    session_start();
    include('../include/config.php');
    include('../../../include/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="print.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="divjs/divjs.js"></script>
    <style>
        .container-responsive {
            border: 1px solid;
            background-color: white;
        }
    </style>

    <title>Enter Cash Inflow</title>
</head>

<body style="background-color: #c0c0c0">
    <div class="container">
        <div class="row d-flex justify-content-center">
            
            <h6 class="mt-2 mr-3"> <span class="badge badge-secondary p-2">Enter Cash Inflow</span></h6>
            <button type="button" id="close_btn" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
    </div>
    
    
    
<div class="pr-5 mt-3" style="margin-right: 250px;" id="wrapper">
    <div class="row mx-auto my-2">
        <div id="print" style="display: none">
            <button class="btn-sm btn-primary" id="printreceipt"><i class="fa fa-print"></i> Print Receipt</button>
        </div>
    </div>
    <div class="container-responsive" id="cont">
        
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title" id="staticBackdropLabel"></div>
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
            <!--  <span aria-hidden="true">&times;</span>-->
            <!--</button>-->
          </div>
          <div class="modal-body" id="modal-msg">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
            <button type="button" data-dismiss="modal" id="generate_receipt" class="btn btn-success">Generate Receipt</button>
          </div>
        </div>
      </div>
    </div>

    <header class="font-bold" style=" sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; background: rgb(61, 55, 55); border-radius: 0.25em; color: #FFF; margin-top: 50px; ">
        <h3>Enter Cash Inflow</h3>
    </header>
    <br><br>

    <form method="POST">
        <div class="row mx-auto">
            <div class="col-md-3 col-sm-6 form-group">
                    <label for="inflow_date" class="text-muted font-weight-bold">Select date:</label>
                    <input placeholder="Enter Date" type="date" name="inflow_date" id="inflow_date" class="form-control form-control-sm" required>
            </div>
    
            <div class="col-sm-5 form-group">
            <label for="amount" class="text-muted font-weight-bold">Enter amount:</label>
            <div class="input-group">
                        <input type="text" name="amount" placeholder="Enter amount" id="amount" class="form-control form-control-sm"  required>
           
            <div class="input-group-append">
                <!--<label for="currency" class="text-muted font-weight-bold">Currency:</label>-->
                <select name="currency" id="currency" class="form-control form-control-sm">
                    <option value="">Currency</option>
                    <?php
                                $sql="SELECT * FROM currencys";
                                $result = $con->query($sql);
                                while($searchrow = $result->fetch()){
                                echo '<option value='.$searchrow["currencyid"].'>' . ucfirst($searchrow["currency"]) .'</option>';
                                }  
                                          
                    ?>
                </select>
            </div>
            </div>
            </div>
            <div class="col-sm">
                        <label for="docref" class="text-muted font-weight-bold">Document reference:</label>
                        <input type="text" name="docref" id="docref" class="form-control form-control-sm"  required>
                         <small class="form-text text-muted">Enter web link to reference document</small>
            </div>
        </div>

                
                <div class="row mt-2 mx-auto">
                    <div class="col-md-3 col-sm-6">
                        <label for="income_type" class="text-muted font-weight-bold">Select income type:</label>
                        <select name="income_type" id="income_type" class="form-control form-control-sm">
                            <option value="">Select income type</option>                      
                            <?php
                                $sql="SELECT * FROM income_types";
                                $result = $con->query($sql);
                                while($searchrow = $result->fetch()){
                                echo "<option value=".$searchrow['income_type_id'] .">" . ucfirst($searchrow['income_type']) ."</option>";
                                }            
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6" id="client" style="display:none">
                        <label for="client_name" class="text-muted font-weight-bold">Client name:</label>
                        <select name="client_name" id="client_name" class="form-control form-control-sm">
                            <option value="">Select client name</option> 
                            <?php
                                    $sql="SELECT * FROM clients";
                                    $result = $con->query($sql);
                                    while($searchrow = $result->fetch()){
                                    echo "<option value=".$searchrow['id'] .">" . ucfirst($searchrow['name'])."</option>";
                                    }
                                ?> 
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6" id="donor" style="display:none">
                        <label for="donor" class="text-muted font-weight-bold">Enter donor:</label>
                        <input type="text" name="donor_name" id="donor_name" class="form-control form-control-sm"  required>
                    </div>
                    <div class="col-md-3 col-sm-6" id="amnt" style="display:none">
                        <label for="donor" class="text-muted font-weight-bold">Enter amount:</label>
                        <input type="text" name="" id="amount" class="form-control form-control-sm"  required>
                    </div>
                    <div class="col-md-3 col-sm-6" id="lender" style="display:none">
                        <label for="donor" class="text-muted font-weight-bold">Enter lender:</label>
                        <input type="text" name="lender_name" id="lender_name" class="form-control form-control-sm"  required>
                    </div>
                    <div class="col-md-3 col-sm-6" id="other_client" style="display:none">
                        <label for="donor" class="text-muted font-weight-bold">Received from:</label>
                        <input type="text" name="other_clientname" id="other_clientname" class="form-control form-control-sm"  required>
                    </div>
                    <div class="col-md-3 col-sm-6" id="other_client" style="display:none">
                        <label for="purpose" class="text-muted font-weight-bold">Payment For:</label>
                        <input type="text" name="purpose" id="purpose" class="form-control form-control-sm"  required>
                    </div>
                    
                     <div class="col-md-3 col-sm-6" style="display:none"  id="projects">
                        <label for="project_name" class="text-muted font-weight-bold">Select project name:</label>
                        <select name="project_name" id="project_name" class="form-control form-control-sm">
                            <option value="">Select project name</option> 
                            <?php
                                $sql="SELECT * FROM costcentres";
                                $result = $con->query($sql);
                                while($searchrow = $result->fetch()){
                                echo "<option value=".$searchrow['costid'] .">" . ucfirst($searchrow['costcentre']) ."</option>";
                                }
                            ?>                     
                        </select>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 my-2 mx-2 text-danger" style="display: none" id="inv-loader">
                        <span class="spinner-border spinner-border-sm "></span> Loading...
                    </div>
                    
                    <div class="col-md-3 col-sm-6" id="invoice" style="display:none">
                        <label for="invoice number" class="text-muted font-weight-bold">Select invoice:</label>
                        <select name="invoice_name" id="invoice_name" class="form-control form-control-sm">  
                                           
                        </select>
                    </div>
                </div> 

                <div class="row mt-4 mx-auto">
                    <div class="col-md-3 col-sm-6" id="banks" style="display:none">
                            <label for="bank" class="text-muted font-weight-bold">Select Receiving Bank:</label>
                            <select name="bank" id="bank" class="form-control form-control-sm">
                                <option value="">Select receiving Bank</option> 
                                <?php
                                    $sql="SELECT DISTINCT bk_id, bank_name FROM bank_acctdetails";
                                    $result = $con->query($sql);
                                    while($searchrow = $result->fetch()){
                                    echo "<option value=".$searchrow['bk_id'] .">" . ucfirst($searchrow['bank_name']) ."</option>";
                                    }
                                ?>                     
                            </select>                            
                        </div>
                        
                        <div class="col-md-3 col-sm-6 m-3 text-danger" style="display: none" id="bnk-loader">
                            <span class="spinner-border spinner-border-sm "></span> Loading...
                        </div>
                        
                        <div class="col-md-3 col-sm-6" id="bankacct" style="display:none">
                            <label for="bank" class="text-muted font-weight-bold">Select Bank Account:</label>
                            <select name="acct" id="acct" class="form-control form-control-sm">
                            </select>                            
                        </div>
                </div>

            <div class="row mt-4 col mx-2" id="inv_tbl" style="display:none;">
            <h4 class="text-muted font-weight-bold">Invoice Details</h4>
            <table class="table table-sm table-responsive rounded" id="tbl">
            <thead class="table-active">
                    <tr>
                    <th scope="col" class="text-muted">S/N</th>
                    <th scope="col" class="text-muted" style="display:none">invid</th>
                    <th scope="col" class="text-muted">Invoice Date</th>
                    <th scope="col" class="text-muted">Invoice Number</th>
                    <th scope="col" class="text-muted">Description</th>
                    <th scope="col" class="text-muted">Quantity</th>
                    <th scope="col" class="text-muted">Unit Price</th>
                    <th scope="col"class=" text-muted">Amount</th>
                    <th scope="col" class="text-muted">Amount Paid</th>  
                    <th scope="col" class="text-muted ">Amount To Pay</th>        
                    </tr>
                </thead>
                <tbody id="t-body">
                </tbody>
                <tfoot>
                    <tr><td colspan="8" class="font-weight-bold text-right">Total:</td><td><input type="text" name="invtotal" id="invtotal" class="form-control form-control-sm"  disabled></td></tr>
                </tfoot>
                </table>
                <h5 class="text-danger mx-auto" id="error"></h5>
            </div>

                <div class="row my-3">
                    <button type="button" class="btn btn-info mx-auto" id="submit">Save</button>
                </div>
          <input type="text" id="gen_inv" value="" hidden>
          <input type="text" id="gen_inflowid" value="" hidden>
          <input type="text" id="gen_incometype" value="" hidden>


    </form>
    

    


</div>
</div>

<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title" id="staticBackdropLabel"></div>
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
            <!--  <span aria-hidden="true">&times;</span>-->
            <!--</button>-->
            
          </div>
          <div class="modal-body" id="modal-msg">
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
            <button type="button" data-dismiss="modal" id="generate_invoice" class="btn btn-success">Generate Receipt</button>
          </div>
        </div>
      </div>
    </div>


</body>
</html>

<script>

    var ajaxurl='manage_cashinflow.php';
    var page='cash_inflow.php';
    
    $("#close_btn").click(function(){
       $("#wrapper").hide('slow'); 
    });

    $("#amount").on("keyup", function(){
        var amnt=$(this).val();
        //var formatprice=parseInt(amnt.replace(/\D/g,''),10);
        //$(this).val(formatprice.toLocaleString());
    });
    
    $("#income_type").change(function(){
        var text = $("#income_type option:selected").text();
        var inctype = $("#income_type").val();
        
        

        if(text=='Grants'){
            $("#invoice, #client, #projects, #lender,#other_client, #inv_tbl, #purpose").hide();
            $("#donor, #projects, #banks").show('slow');
        }
        if(text=='Services'){
            $("#projects, #donor, #lender, #other_client, #inv_tbl, #purpose").hide();
            $("#client, #banks" ).show('slow');
           
        }
        if(text=='Loan'){
            $("#invoice, #projects, #client, #donor, #other_client, #inv_tbl, #purpose").hide();
            $("#lender, #projects, #banks").show('slow');            
        }
        if(text=='Others'){
            $("#invoice, #donor, #client, #projects, #lender, #other_client, #inv_tbl").hide();
            $("#other_client, #banks, #purpose").show('slow');
        }
        
        
        if(text=='Select income type'){
            $("#projects, #donor, #lender, #other_client, #client, #invoice, #inv_tbl, #banks" ).hide(); 
        }
        
    });

    $("#bank").on('change', function(){
        var bk_id = $(this).val();
        $("#bnk-loader").show();
        $("#bankacct").hide();
        $.ajax({
            method:"POST",
            url:ajaxurl,
            data:{bk_id:bk_id,dataname:'showacct'},
            success:function(data){
                var seloption = 'option value=""Select account number</option>';
                $("#acct").html(data);
                $("#acct").prepend(seloption);
                $("#acct").val("");
                $("#bnk-loader").hide();
                $("#bankacct").show('slow');

            }
        });
    });

    $("#client_name").on("change", function(){
        var clientid=$(this).val();
        $("#inv_tbl").hide('slow');
        $("#invtotal").val('');
        $("#invoice").hide();  
        $("#inv-loader").show();
        $.ajax({
            method:"POST",
            url:ajaxurl,
            data:{clientid:clientid,dataname:'getinvoice'},
            success:function(data){
                var seloption = '<option value="">Select invoice</option>';
                $("#invoice_name").html(data);
                $("#invoice_name").prepend(seloption);
                $("#invoice_name").val("");
                $("#inv-loader").hide();
                $("#invoice").show('slow');          
           }
        });
    });
    $("#invoice_name").change(function(){
        var invno=$(this).val();
        $("#inv_tbl").show('slow');
        $("#t-body").html('<tr><td colspan="9" class="text-danger text-center mx-auto"><h5><span class="spinner-border spinner-border-sm"></span> Loading Invoice</h5></td></tr>');
        
        $.ajax({
        method:"POST",
        url:ajaxurl,
        data:{invno:invno,dataname:'getinvdetails'},
        success:function(data){
                $("#t-body").html(data);
                $("#invtotal").val('');
            }
        });
    });
    
    $("#tbl").on("keyup", ".amount", function(){
        $("#error").html('');
        var tr = $(this).closest("tr");
        var amt=tr.find('td:eq(9) input').val();
        var total=0;
        $("#tbl tbody tr").each(function(){
            var getamt=$(this);
            var calcamt=getamt.find('td:eq(9) input').val();
            total+=Number(calcamt);
        });
        // var fmttot=parseInt(total.replace(/\D/g,''),10);
        // console.log(fmttot.toLocaleString());
        // var tot = parseInt(total);
        
        // var formatprice=(tot.replace(/\D/g,''),10);
        // $(this).val(formatprice.toLocaleString());
        // console.log(formatprice.toLocaleString());

        $("#invtotal").val(total);
    });
    
    $("#submit").click(function(){
        var text = $("#income_type option:selected").text();
        var inflowdate=$("#inflow_date").val();
        var currency=$("#currency").val();
        var income_type=$("#income_type").val();
        var client_id=$("#client_name option:selected").text();
        var docref=$("#docref").val();
        var bank=$("#bank").val();
        var projectid = $("#project_name").val();
        var inputamount=parseInt($("#amount").val());  
        var acct = $("#acct").val();  
        
        if(inflowdate == ""){
            $("#inflow_date").focus();
            alert("Please enter date");
            return false;
        }
        if($("#amount").val() == ""){
            $("#amount").focus();
             alert("Please enter amount");
            return false;
        }
        if(currency == ""){
             $("#currency").focus();
            alert("Please select currency");
            return false;
        }
        // if(docref == ""){
        //     $("#docref").focus();
        //     alert("Please enter document reference");
        //     return false;
        // }
        
        if($("#income_type").val() == ""){
            $("#income_type").focus();
            alert("Please select income type");
            return false;
        }
        
        if(text=='Grants'){
            var donor = $("#donor_name").val();
            if(donor == ""){
                $("#donor_name").focus();
                alert("Please enter name of donor");
                return false;
            }
            if(projectid == ""){
                $("#project_name").focus();
                alert("Please select project");
                return false;
            }
            if(bank == ""){
             $("#bank").focus();
            alert("Please select bank");
            return false;
            }
            if($("#acct").val() == ""){
                $("#acct").focus();
                alert("Please select bank account");
                return false;
            }
            
            $(this).html('<span class="spinner-border spinner-border-sm"></span> Loading...');
            $(this).prop("disabled", true);
            $.ajax({
                type:"POST",
                url:ajaxurl,
                dataType:"JSON",
                data:{acct:acct,inflowdate:inflowdate,currency:currency,inputamount:inputamount,income_type:income_type,docref:docref,donor:donor,projectid:projectid,bank:bank,dataname:'savegrant'},
                success:function(data){
                    $(this).html('Save');
                    $(this).prop("disabled", false);
                    if(data.err == ''){
                        $('#staticBackdrop').modal(); 
                        $("#modal-msg").html(data.msg);
                        $("#gen_inflowid").val(data.inflowid);
                        $("#gen_inv").val(data.inv);
                        $("#gen_incometype").val(data.incometype);
                    }
                    else{
                        alert(data.msg);
                    }
                }
            });
        }  

        else if(text=='Services'){
            var totalinput=parseInt($("#invtotal").val());
            var invoice=$("#invoice_name").val();
            var check=inputamount-totalinput;
            
            if($("#client_name").val() == ""){
                $("#client_name").focus();
                alert("Please select client");
                return false;
            }
            if(invoice == ""){
                $("#invoice_name").focus();
                alert("Please select invoice");
                return false;
            }
            if(bank == ""){
                $("#bank").focus();
                alert("Please select bank");
                return false;
            }
            if($("#acct").val() == ""){
                $("#acct").focus();
                alert("Please select bank account");
                return false;
            }
        
            if(check==0){     
                var invarray=[];
                var balance=[];
                $("#tbl tbody tr").each(function(){
                    var tr=$(this);
                    var sn=parseInt(tr.find('td:eq(1)').text());
                    var amnt=parseInt(tr.find('td:eq(7)').text());
                    var amountpaid=parseInt(tr.find('td:eq(8) input').val());
                    var amounttopay=parseInt(tr.find('td:eq(9) input').val());
                    var bal ={};
                    bal = amnt-(amountpaid+amounttopay);
                    var invoicearr={};
                    invoicearr.col1=amnt;
                    invoicearr.col2=amounttopay;
                    invoicearr.col3=amountpaid;
                    invoicearr.col4=sn;
                    invarray.push(invoicearr);
                    if(bal<0){
                        balance.push(bal);
                    }
                });
                var balcount= ((balance).length);
                if(balcount>0){
                    $("#error").html('Error! Input values exceed designated amount <br> Crosscheck input amount');
                    return false;
                }
                else{              
                            var invdetails=JSON.stringify(invarray);
                            //console.log(invdetails);
                            // $(this).html('<span class="spinner-border spinner-border-sm"></span> Saving...');
                            // $(this).prop("disabled", true);
                            $.ajax({
                                type:"POST",
                                dataType:"JSON",
                                url:ajaxurl,
                                data:{acct:acct,inflowdate:inflowdate,currency:currency,income_type:income_type,client_id:client_id,docref:docref,bank:bank,invoice:invoice,invdetails:invdetails,dataname:'savecashinvoice'},
                                success:function(data){
                                    $(this).html('Save');
                                    $(this).prop("disabled", false);         
                                    if(data.err == ''){
                                        $('#staticBackdrop').modal(); 
                                        $("#modal-msg").html(data.msg);
                                        $("#gen_inflowid").val(data.inflowid);
                                        $("#gen_inv").val(data.inv);
                                        $("#gen_incometype").val(data.incometype);
                                    }
                                    else{
                                        alert(data.msg);
                                    }
                                }
                            });
                    }   
            }
            else{
                $("#error").html('Error! Input amount doesn\'t match total value');            
            }
        }

        else if(text=='Loan'){
            var lender = $("#lender_name").val();
            if(lender == ""){
                $("#lender_name").focus();
                alert("Please enter name of lender");
                return false;
            }
            if(projectid == ""){
                $("#project_name").focus();
                alert("Please select project");
                return false;
            }
            if(bank == ""){
                $("#bank").focus();
                alert("Please select bank");
                return false;
            }
            if($("#acct").val() == ""){
                $("#acct").focus();
                alert("Please select bank account");
                return false;
            }
            $(this).html('<span class="spinner-border spinner-border-sm"></span> Loading...');
            $(this).prop("disabled", true);
            $.ajax({
                type:"POST",
                dataType:"JSON",
                url:ajaxurl,
                data:{acct:acct,inflowdate:inflowdate,currency:currency,inputamount:inputamount,income_type:income_type,docref:docref,lender:lender,projectid:projectid,bank:bank,dataname:'saveloan'},
                success:function(data){
                    $(this).html('Save');
                    $(this).prop("disabled", false);
                    if(data.err == ''){
                        $('#staticBackdrop').modal(); 
                        $("#modal-msg").html(data.msg);
                        $("#gen_inflowid").val(data.inflowid);
                        $("#gen_inv").val(data.inv);
                        $("#gen_incometype").val(data.incometype);
                    }
                    else{
                        alert(data.msg);
                    }
                }
            });

        }

        else if(text=='Others'){
            var client = $("#other_clientname").val();
            var purpose = $("#purpose").val();
            if(client == ""){
                $("#other_clientname").focus();
                alert("Please enter payer name");
                return false;
            }
            if(bank == ""){
                $("#bank").focus();
                alert("Please select bank");
                return false;
            }
            if($("#acct").val() == ""){
                $("#acct").focus();
                alert("Please select bank account");
                return false;
            }
            if($("#purpose").val() == ""){
                $(this).focus();
                alert("Please enter description of payment");
                return false;
            }
            $(this).html('<span class="spinner-border spinner-border-sm"></span> Loading...');
            $(this).prop("disabled", true);
            $.ajax({
                type:"POST",
                //dataType:"JSON",
                url:ajaxurl,
                data:{acct:acct,inflowdate:inflowdate,purpose:purpose,currency:currency,inputamount:inputamount,income_type:income_type,docref:docref,client:client,bank:bank,dataname:'saveothers'},
                success:function(data){
                    $("#submit").html('Save');
                    $("#submit").prop("disabled", false);
                    if(data.err == ''){
                        $('#staticBackdrop').modal(); 
                        $("#modal-msg").html(data.msg);
                        $("#gen_inflowid").val(data.inflowid);
                        $("#gen_inv").val(data.inv);
                        $("#gen_incometype").val(data.incometype);
                    }
                    else{
                        alert(data.msg);
                    }
                }                
            });
        }
        
    });
    
    $("#generate_receipt").click(function() {
        var incometype = $("#gen_incometype").val();
        if(incometype == 1){
            var inflow_id = $("#gen_inflowid").val();
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data:{inflow_id:inflow_id,dataname:'view_grant_receipt'}, 
                success:function(data){
                    $("#print").show();
                    $("#cont").html(data);
                }
            });
        }
        
        if(incometype == 3){
            var inv_no = $("#gen_inv").val();
            var receipt_num = $("#gen_inflowid").val();
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data:{inv_no:inv_no,receipt_num:receipt_num,dataname:'view_service_receipt'}, 
                success:function(data){
                    $("#print").show(); 
                    $("#cont").html(data);
                }
             });
        }
        
        if(incometype == 4){
            var inflow_id = $("#gen_inflowid").val();
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data:{inflow_id:inflow_id,dataname:'view_grant_receipt'}, 
                success:function(data){
                    $("#print").show();
                    $("#cont").html(data);
                }
            });
        }
        
        if(incometype == 6){
            var inflow_id = $("#gen_inflowid").val();
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data:{inflow_id:inflow_id,dataname:'view_other_receipt'}, 
                success:function(data){
                    $("#print").show(); 
                    $("#cont").html(data);
                }
            });
        }
    });
    
    $("#close").click(function(e){
        e.preventDefault();
        window.location='cash_inflow.php';
    });
    
    //Print receipt
    $(document).on("click", "#printreceipt", function(){
        $(".receipt-content").printElement({
            keepHide: [],
            title:'',
            css:'extend',
            lcss: ['print.css', 'css/bootstrap/css/bootstrap.min.css'],
        });
    
     });
</script>