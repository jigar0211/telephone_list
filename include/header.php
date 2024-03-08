<?php
include('database.php');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <?php include("link.php") ?>
    <title>Telephone - list</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow p-3 mb-5 bg-white rounded container">
        <div class="row">
            <div class="col-auto">
                <a class="navbar-brand font-weight-bold" href="user_list.php">LOGO</a>
            </div>
            <div class="col">
                <div class="vl d-none d-lg-block"></div>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link font-weight-bold" href="user_list.php">User List <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0 ml-auto">
                <div class="btn-group" id="userDropdown">
                    <button type="button" class="btn btn-info"><i class="fa-solid fa-user"></i> USER</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="logout.php" id="logoutBtn"><i class="fa-solid fa-power-off"></i> Logout</a>
                    </div>
                    
                </div>
            </form>
        </div>
    </nav>