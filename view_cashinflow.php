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
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    <!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>   

    <title>View Cash Inflow</title>
        
    <style>
        .container-responsive {
            border: 1px solid;
            background-color: white;
        }
    </style>
</head>

<body style="background-color: #c0c0c0">
    <div class="container">
        <div class="row d-flex justify-content-center">
            
            <h6 class="mt-2 mr-3"> <span class="badge badge-secondary p-1">View Cash Inflow</span></h6>
            <button type="button" id="close_btn" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
    </div>

<div class="pr-4" style="margin-right: 200px;">
    <div class="container-responsive mx-auto" id="cont">
    <!-- <button type="button" id="close_btn" class="close float-left mb-5" aria-label="Close">-->
    <!--    <span aria-hidden="true">&times;</span>-->
    <!--</button>-->
    <header class="font-bold" style=" sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; background: rgb(61, 55, 55); border-radius: 0.25em; color: #FFF; margin-top: 50px; ">
        <h3>View Cash Inflow</h3>
    </header>
    <br><br>

    <div class="row mt-2 mx-auto">
                    <div class="col-md-3 col-sm-6">
                        <label for="start_date" class="text-muted font-weight-bold">Select start date:</label>
                        <input placeholder="Enter Date" type="date" name="start_date" id="start_date" class="form-control form-control-sm" required>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label for="end_date" class="text-muted font-weight-bold">Select end date:</label>
                        <input placeholder="Enter Date" type="date" name="end_date" id="end_date" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <label for="income_type" class="text-muted font-weight-bold">Select income type:</label>
                        <select name="income_type" id="income_type" class="form-control form-control-sm">
                            <option value="">Select income type</option>                      
                            <?php
                                $sql="SELECT * FROM income_types";
                                $result = $con->query($sql);
                                while($searchrow = $result->fetch()){
                                echo '<option value='.$searchrow["income_type_id"].'>' . ucfirst($searchrow["income_type"]) .'</option>';
                                }  
                                          
                            ?>
                            <option value="all">Select All</option>
                        </select>
                    </div>
                    <div class="col-md-2 mt-4 ml-2"> 
                         <button type="button" class="btn btn-info mx-auto" id="search">Search</button>
                    </div>

    </div>

    <div class="row mt-5 col">
            <table class="table table-hover table-responsive mt-3" id="inflow_tbl">
                <thead >
                    <tr id="thead_tr">
                        <th scope="col" class="text-muted">#</th>
                        <th scope="col" class="text-muted">Date</th>
                        <th scope="col" class="text-muted">Amount</th>
                        <th scope="col" class="text-muted">Currency</th>
                        <th scope="col" class="text-muted">Project</th>
                        <th scope="col" class="text-muted">Income_type</th>
                        <th scope="col" class="text-muted">Paid by</th>
                        <th scope="col" class="text-muted">Document_ref</th>
                        <th scope="col" class="text-muted">Invoice_ref</th>
                        <th scope="col" class="text-muted">Bank</th>
                        <th scope="col" class="text-muted">Account_number</th>
                    </tr>
                </thead>
                <tbody id="t_body">                 
                </tbody>
            </table>
    </div>
 

</div>
</div>

</body>
</html>

<script>

 var ajaxurl = 'cashinflow_report_control.php';
 var page = 'view_cashinflow.php';
 $("#close_btn").click(function(){
       $("#cont").hide('slow'); 
    });

    $("#search").click(function(){
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();   
        var inctype = $("#income_type").val();
        var text = $("#income_type option:selected").text();
        //console.log(inctype);
        if(text=='Grants'){
            $.ajax({
                method:"POST",
                url:ajaxurl,
                data:{inctype:inctype,start_date:start_date,end_date:end_date,dataname:'getgrants'},
                success:function(data){
                    $("#t_body").html(data);
                }
            });
        }

        if(text=='Services'){
            $.ajax({
                method:"POST",
                url:ajaxurl,
                data:{inctype:inctype,start_date:start_date,end_date:end_date,dataname:'getinv'},
                success:function(data){
                    $("#t_body").html(data);
                }
            });
        }

        if(text=='Loan'){
            $.ajax({
                method:"POST",
                url:ajaxurl,
                data:{inctype:inctype,start_date:start_date,end_date:end_date,dataname:'getgrants'},
                success:function(data){
                    $("#t_body").html(data);
                }
            });
        }

        if(text=='Others'){
            $.ajax({
                method:"POST",
                url:ajaxurl,
                data:{inctype:inctype,start_date:start_date,end_date:end_date,dataname:'getothers'},
                success:function(data){
                    $("#t_body").html(data);
                }
            });
        }

        if(text=='Select All'){
            $.ajax({
                method:"POST",
                url:ajaxurl,
                data:{inctype:inctype,start_date:start_date,end_date:end_date,dataname:'getall'},
                success:function(data){
                    $("#t_body").html(data);
                }
            });
        }
    });



</script>