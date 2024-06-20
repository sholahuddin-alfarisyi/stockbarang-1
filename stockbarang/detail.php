<?php
require 'function.php';
require 'cek.php';

//Dapetin id barang yang di passing di halaman sebelumnya
$idbarang = $_GET['id']; //get id barang
//Get informasi barang berdasarkan database
$get = mysqli_query($conn, "select * from stock where idbarang='$idbarang'");
$fetch = mysqli_fetch_assoc($get);
//set variabel
$namabarang = $fetch['namabarang'];
$deskripsi = $fetch['deskripsi'];
$stock = $fetch['stock'];

//cek ada gambar atau tidak
$gambar = $fetch['image']; //ambil gambar
if($gambar==null){
    //jika tidak ada gambar
    $img = 'No Photo';
} else {
    //jika ada gambar
    $img = '<img src="images/'.$gambar.'" class="zoomable">';
}

//generate QR
$urlview = 'http://localhost/stockbarang/view.php?id='.$idbarang;
$qrcode = 'https://chart.googleapis.com/chart?chs=350x350&cht=qr&chl='.$urlview.'&choe=UTF-8';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Stock - Title Barang</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style> 
        .zoomable{
            width: 300px;
        }
        .zoomable:hover {
            transform: scale(1.5);
            transition: 0.3s ease;
        }
    </style>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
        <img src="images/Logo_BAZNAS_RI-Hijau-01.png" alt="" width="60" height="50">
        <a class="navbar-brand" href="index.php">BAZNAS Kota Depok</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="bg-success sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-upload"></i></div>
                            Barang keluar
                        </a>
                        <a class="nav-link" href="peminjaman.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-business-time"></i></div>
                            Peminjaman Barang
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Kelola Admin
                        </a>
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-power-off text-danger"></i></div>
                            Logout
                        </a>


                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Detail Barang</h1>

                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <h2><?=$namabarang;?></h2>
                            <?=$img;?>
                            <img src="<?=$qrcode;?>">
                        </div>
                        <div class="card-body">

                        <div class="row">
                            <div class="col-md-3">Deskripsi</div>
                            <div class="col-md-9"><?=$deskripsi;?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">Stock</div>
                            <div class="col-md-9"><?=$stock;?></div>
                        </div>

                        <br><br>

                            <h3>Barang Masuk</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="barangmasuk" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $ambildatamasuk = mysqli_query($conn,"select * from masuk where idbarang='$idbarang'");
                                        $i = 1;
                                        while($fetch=mysqli_fetch_array($ambildatamasuk)){
                                            $tanggal = $fetch['tanggal'];
                                            $keterangan = $fetch['keterangan'];
                                            $quantity = $fetch['qty'];

                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $keterangan; ?></td>
                                                <td><?= $quantity; ?></td>
                                            </tr>


                                        <?php
                                        };

                                        ?>

                                    </tbody>
                                </table>
                            </div>

                            <br><br>

                            <h3>Barang Keluar</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="barang keluar" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Penerima</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $ambildatakeluar = mysqli_query($conn,"select * from keluar where idbarang='$idbarang'");
                                        $i = 1;
                                        while($fetch=mysqli_fetch_array($ambildatakeluar)){
                                            $tanggal = $fetch['tanggal'];
                                            $penerima = $fetch['penerima'];
                                            $quantity = $fetch['qty'];

                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $penerima; ?></td>
                                                <td><?= $quantity; ?></td>
                                            </tr>


                                        <?php
                                        };

                                        ?>

                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-2 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; INVENTARIS BAZNAS KOTA DEPOK 2024</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>
<!-- Modal tambah barang baru -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
                    <br>
                    <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control" required>
                    <br>
                    <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                    <br>
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>

</html>