<?php

  $host ="Localhost";
  $user ="root";
  $pass ="";
  $db ="db_kelulusan";

  $koneksi = mysqli_connect($host,$user,$pass,$db);
  $nisn = $_GET['nisn'];
  $npsn= $_GET['npsn'];
  $sql1 = "select * from siswa where nisn ='$nisn' and npsn='$npsn'";

  $q1 = mysqli_query ($koneksi,$sql1);
  $hasil= mysqli_fetch_array($q1);

?>

<style>
    th{
        background-color: #dedede;
        color: #333333;
        font-weight: bold;
    }
    table{
        border-collapse: collapse;
        width: 100%;
    }
    tr{
        background-color: #dedede;
    }
    img{
        margin-top: 20mm;
    }
</style>


<table border="1">
    <tr>
        <td style="width: 20%; text-align: right;">NISN</td>
        <td style="width: 30%;"><?php echo $hasil['nisn']; ?></td>
    </tr>
    <tr>
        <td style="width: 20%; text-align: right;">Nama</td>
        <td style="width: 30%;"><?php echo $hasil['nama']; ?></td>
    </tr>
    <tr>
        <td>
            <img src="image_view.php?id=<?php echo $hasil['nisn']; ?>" alt="">
        </td>
    </tr>
</table>
<br><br>
<table border="1" >
   <tr>
      <td> <img style="height: 100px;" src="img.png" alt=""> </td> 
    </tr> 
</table>
