<?php
    // 读取database配置文件
    $database = require('../phpapp/application/database.php');
    $servername = $database['hostname'];
    $databasename = $database['database'];
    $username = $database['username'];
    $password = $database['password'];
    $port = $database['hostport'];
    $prefix = $database['prefix'];
    $sqlFile = 'install.sql';
    // 安装程序
    echo '<title>安装程序</title><h1>安装程序</h1>';
    echo '当前php版本为'.PHP_VERSION.'<br>';
    echo '当前已安装扩展：<br>';
    foreach(get_loaded_extensions() as $k)
    {
       echo $k.'<br>'; 
    }
    // 检测是否安装过
    
    // 检测是否符合安装环境
    echo '检测是否符合安装环境：<br>';
    $needExtensions = ['mysqli','PDO','gd','redis','openssl'];
    $isFullExtension = true;
    foreach ($needExtensions as $k)
    {
        if (!extension_loaded($k))
        {
            echo '<span style="color:red;">'.$k.' 未安装</span><br>';
            $isFullExtension = false;
        }else{
            echo '<span style="color:green;">'.$k.' 已安装</span><br>';
        }
    }
    if(!$isFullExtension){
        echo '请安装扩展后刷新<br>';
        die;
    }
    // 开始安装程序
    echo '开始安装:<br>';
    // 创建连接
    $conn = new mysqli($servername, $username, $password);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    echo "连接数据库成功<br>";
    // 导入sql文件
    if(!file_exists($sqlFile))
    {
        echo '<span style="color:red;">缺少sql文件</span><br>';
        die;
    }
    $sqlData = file_get_contents($sqlFile);
    
    // 创建数据库
    $sql = ['DROP DATABASE IF EXISTS '.$databasename.';','CREATE DATABASE '.$databasename.'  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;'];
    foreach($sql as $k)
    {
        if ($conn->query($k) === TRUE) {
            // echo "数据库创建成功";
        }else{
            echo "创建数据库错误: " . $conn->error;
        }
    }
    echo $databasename."数据库创建成功<br>";
    $conn->close();
    // 创建数据表
    $conn = new mysqli($servername, $username, $password,$databasename);
    $reSqlData = str_replace('[prefix_]',$prefix,$sqlData);
    $sqlArr = explode(';',$reSqlData);
    unset($sqlArr[count($sqlArr)-1]);
    foreach($sqlArr as $k)
    {
        if ($conn->query($k) === TRUE) {
            // echo "新记录插入成功";
        } else {
            echo "Error: " . $k . "<br>" . $conn->error;
            die;
        }
    }
    echo '数据表创建成功<br>新记录插入成功<br>';
    $conn->close();
    // 修改本文件
    echo "安装完成";
    
    
    