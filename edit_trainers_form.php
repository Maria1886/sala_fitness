<?php
require "../database/connection.php";
$trainers_id=$_GET['trainers_id'];
$sql="SELECT * FROM `antrenori` WHERE id=$trainers_id ";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $trainers = $result->fetch_assoc();
 ?>
 <div class="hide_edit_form">
        <form action="" method="post" class="register_form" enctype="multipart/form-data">
            <label for="nume">Nume</label>
            <input type="text" placeholder="numele antrenorului" name="nume" id="nume" value="<?php echo $trainers['nume']?>" required>
            <label for="prenume">Prenume</label>
            <input type="text" placeholder="prenumele antrenorului" name="prenume" id="prenume" value="<?php echo $trainers['prenume']?>" required>
            <label for="descriere">Descriere</label> 
            <textarea placeholder="descriere" name="descriere" id="descriere" cols="30" rows="10" value="<?php echo $trainers['descriere']?>"></textarea>
            <label for="imagine">Imagine</label>
            <input type="file" name="imagine" id="imagine" value="<?php echo $trainers['imagine']?>" required>
            <button type="submit" >Editeaza</button>

        </form>
        </div>
 <?php
}else {
 echo "Nu s-au găsit antrenori.";
}
?>
