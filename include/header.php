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
    <nav class="navbar navbar-expand-lg navbar-light shadow p-3 mb-5 bg-white rounded container">
        <a class="navbar-brand" href="#">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link font-weight-bold" href="#">User List <span class="sr-only">(current)</span></a>
                </li>
                <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li> -->
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <div class="btn-group" id="userDropdown">
                    <button type="button" class="btn btn-info"><i class="fa-solid fa-user"></i> USER</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off"></i> Logout</a>
                    </div>
                </div>
            </form>
        </div>
    </nav>