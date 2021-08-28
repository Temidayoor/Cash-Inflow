<?php
    session_start();
    include('../include/config.php');
    include('../../../include/config.php');
    $staffid=implode(',', array_map(function($el){ return $el['idno']; }, get_user($_SESSION['loginid'])));
    $appid= $_SESSION['appid'];
    $submenuid=$_SESSION['csubmenuid'];
    extract($_POST);
    if($dataname=='getgrants'){
        $cashflowin->getgrant($inctype, $start_date, $end_date);
        $comment =$staffid . ' viewed grants cash inflow report';
        logguser($staffid,$comment,$appid, $submenuid);
        exit();
    }
    
    if($dataname=='getinv'){
        $cashflowin->getinv($inctype, $start_date, $end_date);
        $comment =$staffid . ' viewed invoices cash inflow report';
        logguser($staffid,$comment,$appid, $submenuid);
        exit();
    }
    
    if($dataname=='getloan'){
        $cashflowin->getloan($inctype, $start_date, $end_date);
        $comment =$staffid . ' viewed loan cash inflow report';
        logguser($staffid,$comment,$appid, $submenuid);
        exit();
    }
    
    if($dataname=='getothers'){
        $cashflowin->getothers($inctype, $start_date, $end_date);
        $comment =$staffid . ' viewed other cash inflow report';
        logguser($staffid,$comment,$appid, $submenuid);
        exit();
    }
    if($dataname=='getall'){
        $cashflowin->getall($start_date, $end_date);
        $comment =$staffid . ' viewed all cash inflow report';
        logguser($staffid,$comment,$appid, $submenuid);
        exit();
    }

?>