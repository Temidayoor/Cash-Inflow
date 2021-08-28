<?php
session_start();
include('../include/config.php');
include('../../../include/config.php');
$staffid=implode(',', array_map(function($el){ return $el['idno']; }, get_user($_SESSION['loginid'])));

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Generate Receipt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="print.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="divjs/divjs.js"></script>
</head>
<body>
    
    <div class="container-responsive">
        <div class="row d-flex justify-content-center">
            
            <h6 class="mt-2 mr-3"> <span class="badge badge-secondary p-1">View Receipt</span></h6>
            <button type="button" class="close" id="close-tab">
                 <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
    </div>
    <div class="container" id="cont">
        <div class="row mb-3">
            <div class="col-sm-4 my-3" id="">
                <label>Select cash inflow type</label>
                <select name="inflowtype" id="inflowtype" class="form-control form-control-sm">
                        <option value="">Select cash inflow type</option>                     
                            <?php
                                $sql="SELECT * FROM income_types";
                                $result = $con->query($sql);
                                while($searchrow = $result->fetch()){
                                    echo "<option value=".$searchrow['income_type_id'] .">" . ucfirst($searchrow['income_type']) ."</option>";
                                }            
                            ?>
                </select>
            </div>

            <div class="col-sm-4 mx-3 my-3" id="services" style="display:none">
                <label>Select invoice number to view receipts</label>
                <select name="inflow" id="inflow" class="form-control form-control-sm">
                        <option value="">Select cash inflow entry</option>                      
                            <?php
                                $sql="SELECT DISTINCT inv_no, name FROM invoices LEFT JOIN clients ON invoices.clientname=clients.id ORDER BY inv_no DESC";
                                $result = $con->query($sql);
                                while($searchrow = $result->fetch()){
                                    echo "<option value=".$searchrow['inv_no'] .">" . $searchrow['inv_no'] ." | ". ucfirst($searchrow['name'])."</option>";
                                }            
                            ?>
                </select>
            </div>

            <div class="col-sm-4 mx-3 my-3" style="display: none" id="grantdiv">
                <label>Select cash inflow entry</label>
                <select name="grant" id="grant" class="form-control form-control-sm">
                    <option value="">Select cash inflow entry</option> 
                    <?php
                        $sql = "SELECT * FROM cash_inflow
                        JOIN costcentres ON cash_inflow.costcentre_id=costcentres.costid WHERE income_type_id = 1 ORDER BY inflow_date DESC";
                        $result = $con->query($sql);
                        while ($searchrow = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=".$searchrow['inflow_id'] .">" . ucfirst($searchrow['income_source']) ." | ". ucfirst($searchrow['costcentre'])."</option>";                      
                        }
                    ?>
                </select>
            </div>
            
            <div class="col-sm-4 mx-3 my-3" style="display: none" id="receiptdiv">
                <label>Select cash inflow entry</label>
                <select name="receipts" id="receipts" class="form-control form-control-sm">
                    
                </select>
            </div>

            <div class="col-sm-4 mx-3 my-3" style="display: none" id="loandiv">
                <label>Select cash inflow entry</label>
                <select name="loan" id="loan" class="form-control form-control-sm">
                    <option value="">Select cash inflow entry</option> 
                    <?php
                        $sql = "SELECT * FROM cash_inflow
                        JOIN costcentres ON cash_inflow.costcentre_id=costcentres.costid WHERE income_type_id = 4 ORDER BY inflow_date DESC";
                        $result = $con->query($sql);
                        while ($searchrow = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=".$searchrow['inflow_id'] .">" . ucfirst($searchrow['income_source']) ." | ". ucfirst($searchrow['costcentre'])."</option>";                      
                        }
                    ?>
                </select>
            </div>

            <div class="col-sm-4 mx-3 my-3" style="display: none" id="otherdiv">
                <label>Select cash inflow entry</label>
                <select name="other" id="other" class="form-control form-control-sm">
                    <option value="">Select cash inflow entry</option> 
                    <?php
                        $sql = "SELECT * FROM cash_inflow WHERE income_type_id = 6 ORDER BY inflow_date DESC";
                        $result = $con->query($sql);
                        while ($searchrow = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=".$searchrow['inflow_id'] .">" . ucfirst($searchrow['income_source'])."</option>";                      
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="row mx-auto my-2">
            <div id="print" style="display: none">
                <button class="btn-sm btn-primary" id="printinv"><i class="fa fa-print"></i> Print Receipt</button>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-sm-8">
                <div id="loading" class="text-danger mx-5 my-5" style="display:none">
                    <span class="spinner-border spinner-border-sm"></span> 
                        Loading...
                </div>
                
                <div id="pr_invoice" class="scrollit mb-4" style="overflow:scroll; width:1000px; height:500px; display: none">
                    
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>

<script>
 var ajaxurl = 'manage_cashinflow.php';

   $("#printinv").on("click", function(){
        
        $(".receipt-content").printElement({
            keepHide: [],
            title:'',
            css:'extend',
            lcss: ['print.css', 'css/bootstrap/css/bootstrap.min.css'],
        });
    
     });

    $("#close-tab").click(function(){
        $("#cont").hide();
    });
    
    $("#inflowtype").on("change", function(){
        var invtype = $(this).val();
        $("#print, #pr_invoice").hide();
        $("#pr_invoice").empty();
       
        if(invtype == 1){
            $("#services, #loandiv, #otherdiv").hide();
            $("#grantdiv").show('slow');
        }

        if(invtype== 3){
            $("#grantdiv, #loandiv, #otherdiv").hide();
            $("#services").show('slow');
        }

        if(invtype== 4){
            $("#grantdiv, #services, #otherdiv").hide();
            $("#loandiv").show('slow');
        }
        
        if(invtype== 6){
            $("#grantdiv, #loandiv, #services").hide();
            $("#otherdiv").show('slow');
        }

    });
    

    $("#loan").on("change", function(){
        var inflow_id = $(this).val();
         $("#print, #pr_invoice").hide();
         $("#loading").show();
         
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data:{inflow_id:inflow_id,dataname:'view_grant_receipt'}, 
            success:function(data){
                $("#loading").hide();
                $("#pr_invoice").html(data);
                $("#print, #pr_invoice").show();
            }
        });
    });

    $("#grant").on("change", function(){
        var inflow_id = $(this).val();
        $("#print, #pr_invoice").hide();
        $("#loading").show();
        
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data:{inflow_id:inflow_id,dataname:'view_grant_receipt'}, 
            success:function(data){
                $("#loading").hide();
                $("#pr_invoice").html(data);
                $("#print, #pr_invoice").show();
            }
        });
    });


    $("#inflow").on("change", function(){
        var inv_no = $("#inflow").val();
        $("#print, #pr_invoice, #receiptdiv").hide();
        //$("#loading").show();
        
        $.ajax({
           type:"POST",
           url: ajaxurl,
           data:{inv_no:inv_no,dataname:'getreceiptnum'},
           success:function(data){
               $("#receipts").html(data);
               $("#receipts").prepend('<option value="">Select receipt number</option>');
               $("#receiptdiv").show();
           }
        });
    });
    
    $("#receipts").on("change", function(){
        var receipt_num = $(this).val();

        $("#print, #pr_invoice").hide();
        $("#loading").show();
    
        $.ajax({
        type: "POST",
        url: ajaxurl,
        data:{receipt_num:receipt_num,dataname:'view_service_receipt'}, 
        success:function(data){
            $("#loading").hide();
            $("#pr_invoice").html(data);
            $("#print, #pr_invoice").show();
        }
      });
    });
    
    
    $("#other").on("change", function(){
        var inflow_id = $(this).val();
        $("#print, #pr_invoice").hide();
        $("#loading").show();
        
        $.ajax({
        type: "POST",
        url: ajaxurl,
        data:{inflow_id:inflow_id,dataname:'view_other_receipt'}, 
        success:function(data){
            $("#loading").hide();
            $("#pr_invoice").html(data);
            $("#print, #pr_invoice").show();
        }
      });
    });



</script>