<?php
include('koneksi.php');
if(isset($_GET['id'])) 
{
    $query = mysqli_query($koneksi,"select * from siswa where nisn='".$_GET['id']."'");
    $row = mysqli_fetch_array($query);
    header("Content-type: " . $row["tipe_gambar"]);
    echo $row["pasphoto"];
}
else
{
    header('location:new_html.php');
}
?>