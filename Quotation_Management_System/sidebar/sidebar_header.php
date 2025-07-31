<!DOCTYPE html>
<lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            <?php
            include 'sidebar.css';
            ?>
        </style>
    </head>
</head>

<body>
<div class="container-fluid">
        <div class="row">
            <div class="col">

                <div class="d-flex">
                    <nav class="sidebar d-flex flex-column flex-shrink-0 position-fixed">
                        <button href="" class="toggle-btn" onclick="toggleSidebar()">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div class="p-4">
                            <h4 class="logo-text fw-bold mb-0">Quotation System</h4>
                            <p class="text-muted small hide-on-collapse">Dashboard</p>
                        </div>

                        <div class="nav flex-column">
                            <a href="/Quotation_Management_System/customer/customer.php"
                                class="sidebar-link text-decoration-none p-3">
                                <i class="fas fa-home me-3"></i>
                                <span class="hide-on-collapse">Manage Customers</span>
                            </a>
                            <a href="/Quotation_Management_System/item/item.php" class="sidebar-link text-decoration-none p-3">
                                <i class="fas fa-chart-bar me-3"></i>
                                <span class="hide-on-collapse">Manage Items</span>
                            </a>
                            <a href="/Quotation_Management_System/term/term.php" class="sidebar-link text-decoration-none p-3">
                                <i class="fas fa-chart-bar me-3"></i>
                                <span class="hide-on-collapse">Manage Terms & Condition</span>
                            </a>
                            <a href="/Quotation_Management_System/quotation/quote.php" class="sidebar-link text-decoration-none p-3">
                                <i class="fas fa-chart-bar me-3"></i>
                                <span class="hide-on-collapse">Manage Quotation</span>
                            </a>
                        </div>

                        <div class="profile-section mt-auto p-4">
                            <div class="d-flex align-items-center">
                                <img src="https://randomuser.me/api/portraits/men/69.jpg" style="height:60px"
                                    class="rounded-circle" alt="Profile">
                                <div class="ms-3 profile-info">
                                    <h6 class="text-white mb-0"><a href="/Quotation_Management_System/account/logout.php" style="color:#6b8cff;text-decoration:none;font-weight:bold;font-size:1.3rem;">Logout</a></h6>
                                    <small class="text-muted">Admin</small>
                                </div>
                            </div>
                        </div>
                    </nav>