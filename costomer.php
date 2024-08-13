<?php

    function geturl($url){
        $headerArray =array("Content-type:application/json;","Accept:application/json");  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);  
        $output = curl_exec($ch);
        curl_close($ch);  
        // $output = json_decode($output,true);  
        return $output;  
    } 

    //建立會員
    function cre_member($post=""){
        $data = geturl("http://localhost:80/remaapi/cre_member?".$post);
    }

    //建立訂單
    function cre_order($post=""){
        $data = geturl("http://localhost:80/remaapi/cre_order?".$post);
    }
    
    //訂單修改
    function upd_order($post=""){
        $data = geturl("http://localhost:80/remaapi/upd_order?".$post);
    }

    //訂單結案
    function upd_order_complete($post=""){
        $data = geturl("http://localhost:80/remaapi/upd_order_complete?".$post);
        return $data;
    }

    //查詢訂單商品庫存
    function get_stock($post=""){
        $data = geturl("http://localhost:80/remaapi/get_stock?".$post);
        return $data;
    }

    //查詢一個商品庫存
    function get_stock_one($post=""){
        $data = geturl("http://localhost:80/remaapi/get_stock_one?".$post);
        return $data;
    }

    //退貨
    function upd_order_cancel($post=""){
        $data = geturl("http://localhost:80/remaapi/upd_order_cancel?".$post);
        return $data;
    }
?>