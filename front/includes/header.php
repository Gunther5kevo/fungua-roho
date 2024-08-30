<?php 

include '../admin/functions.php';

include '../config/fetch.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($pageTitle)) {echo $pageTitle;} else{echo webSetting('title') ?? "Fungua Roho";}?></title>
    
    <meta name="description" content="<?= webSetting('meta_description') ?? "Meta Desc"; ?>">
    <meta name="keyword" content="<?= webSetting('meta_keyword') ?? "Meta Keyword"; ?>">
    
    <meta name="description" content="Explore confessions on love, family, deep secrets, and more.">
    <meta name="keywords" content="confessions, love, secrets, family, Fungua Roho">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    .sidebar {
        background-color: #f8f9fa;
        padding: 15px;
    }
</style>
<?php include 'navbar.php';?>
<body>
