<?php
  $host ="Localhost";
  $user ="root";
  $pass ="";
  $db ="sample";

  $koneksi = mysqli_connect($host,$user,$pass,$db);

  $sql1 = "select * from customer where Cust_country ='India'";

  $q1 = mysqli_query ($koneksi,$sql1);

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
</style>

<table border="1" >
   <img style="height: 50mm;" src="img.jpg" alt=""> 
</table>
<br>
<table border="1">
    <thead  style="height: 50mm;">
        <tr>
            <th style="width:10%">No</th>
            <th style="width:20%">Kode</th>
            <th style="width:40%">Nama</th>
            <th style="width:30%">Kota</th>
        </tr>
    </thead>
    <tbody>
        <?php
          $i =1;
          while($r1= mysqli_fetch_assoc($q1)){
        ?>
        <tr>
            <td style="width:10%"><?php echo $i++ ?></td>
            <td style="width:20%"><?php echo $r1['CUST_CODE'] ?></td>
            <td style="width:40%"><?php echo $r1['CUST_NAME'] ?></td>
            <td style="width:30%"><?php echo $r1['CUST_CITY'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
