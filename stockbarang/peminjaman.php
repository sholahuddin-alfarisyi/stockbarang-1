<?php
require 'function.php';
require 'cek.php';

//Get data 
//ambil data total
$get1 = mysqli_query($conn,"select * from peminjaman");
$count1 = mysqli_num_rows($get1); //menghitung seluruh kolom

//ambil data peminjaman yang statusnya dipinjam
$get2 = mysqli_query($conn,"select * from peminjaman where status='Dipinjam'");
$count2 = mysqli_num_rows($get2); //menghitung seluruh kolom yang statusnya dipinjam

//ambil data peminjaman yang statusnya kembali
$get3 = mysqli_query($conn,"select * from peminjaman where status='Kembali'");
$count3 = mysqli_num_rows($get3); //menghitung seluruh kolom yang statusnya dipinjam
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Stock - Peminjaman Barang</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style> 
        .zoomable{
            width: 50px;
        }
        .zoomable:hover {
            transform: scale(2);
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
                    <h1 class="mt-4">Peminjaman Barang</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                Tambah Data
                            </button>
                            <br>
                            <div class="row mt-4 text-white">
                                <div class="col">
                                    <div class="card bg-info p-2"><h3>Total Data: <?=$count1;?></h3></div>
                                </div>
                                <div class="col">
                                    <div class="card bg-warning p-2"><h3>Total Dipinjam: <?=$count2;?></h3></div>
                                </div>
                                <div class="col">
                                    <div class="card bg-success p-2"><h3>Total Kembali: <?=$count3;?></h3></div>
                                </div>
                            </div>
                                <div class="row mt-4">
                                    <div class="col">
                                    <form method="post" class="form-inline">
                                        <input type="date" name="tgl_mulai" class="form-control">
                                        <input type="date" name="tgl_selesai" class="form-control ml-3">
                                        <button type="submit" name="filter_tgl" class="btn btn-info ml-3">Filter</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Gambar</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Penerima</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if(isset($_POST['filter_tgl'])){
                                            $mulai = $_POST['tgl_mulai'];
                                            $selesai = $_POST['tgl_selesai'];

                                            if($mulai!=null || $selesai!=null){
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from peminjaman p, stock s where s.idbarang = p.idbarang and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY) order by idpeminjaman DESC");
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from peminjaman p, stock s where s.idbarang = p.idbarang order by idpeminjaman DESC");
                                            }

                                            
                                        } else {
                                            $ambilsemuadatastock = mysqli_query($conn, "select * from peminjaman p, stock s where s.idbarang = p.idbarang order by idpeminjaman DESC");
                                        }
                                        
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $idk = $data['idpeminjaman'];
                                            $idb = $data['idbarang'];
                                            $tanggal = $data['tanggalpinjam'];
                                            $namabarang = $data['namabarang'];
                                            $qty = $data['qty'];
                                            $penerima = $data['peminjam'];
                                            $status = $data['status'];

                                             //cek ada gambar atau tidak
                                             $gambar = $data['image']; //ambil gambar
                                             if($gambar==null){
                                                 //jika tidak ada gambar
                                                 $img = 'No Photo';
                                             } else {
                                                 //jika ada gambar
                                                 $img = '<img src="images/'.$gambar.'" class="zoomable">';
                                             }

                                        ?>
                                            <tr>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $img; ?></td>
                                                <td><?= $namabarang; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $penerima; ?></td>
                                                <td><?= $status ; ?></td>
                                                <td>
                                                    <?php
                                                            //cekstatus
                                                            if($status=='Dipinjam'){
                                                                echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit'.$idk.'">
                                                                Selesai
                                                            </button>';
                                                            } else {
                                                                //jika statusnya sudah dipinjam (sudah kembali)
                                                            }

                                                    ?>
                                                    
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idk; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Selesaikan</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah barang ini sudah selesai dipinjam?
                                                                <input type="hidden" name="idpinjam" value="<?= $idk; ?>">
                                                                <input type="hidden" name="idbarang" value="<?= $idb; ?>">
                                                                <button type="submit" class="btn btn-primary" name="barangkembali">Iya</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

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
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Peminjaman</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <select name="barangnya" class="form-control">
                        <?php
                        $ambilsemuadatanya = mysqli_query($conn, "select * from stock");
                        while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                        ?>

                            <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <input type="number" name="qty" class="form-control" placeholder="Quantity" required>
                    <br>
                    <input type="text" name="penerima" class="form-control" placeholder="Penerima" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="pinjam">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>

</html>