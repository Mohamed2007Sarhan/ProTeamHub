<?php
    $conx = mysqli_connect("localhost","root","","proteamhub");
    if(!$conx){
        echo 'Connection Failed';
    }
