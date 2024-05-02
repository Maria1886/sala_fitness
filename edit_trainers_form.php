<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    if (isset($_GET['id'])) {
        $trainer_id = $_GET['id'];
        var_dump($trainer_id);
        require "../database/connection.php";
    
        $sql = "SELECT * FROM antrenori  WHERE id=$trainer_id";
        $result = $connection->query($sql);
        var_dump($result);
        if ($result->num_rows > 0) {
            $antrenor = $result->fetch_assoc();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
                $nume = $_POST['nume'];
                $prenume = $_POST['prenume'];
                $descriere = $_POST['descriere'];
            
    
                if (isset($_FILES['imagine']) && $_FILES['imagine']['error'] === UPLOAD_ERR_OK) {
                    if (!empty($antrenor['imagine'])) {
                        $imagePathToDelete = dirname(__FILE__) . '_image_trainers/' . $antrenor['imagine'];
                        if (file_exists($imagePathToDelete)) {
                            unlink($imagePathToDelete);
                        }
                    }
    
                    $directoryPath = dirname(__FILE__);
                    $directoryName = '_image_trainers';
    
                    if (!file_exists($directoryPath . $directoryName)) {
                        mkdir($directoryPath . $directoryName, 0775, true);
                        chmod($directoryPath . $directoryName, 0775);
                    }
    
                    $imagePath = $directoryPath . $directoryName . '/' . uniqid() . '_' . basename($_FILES['imagine']['name']);
                    if (move_uploaded_file($_FILES['imagine']['tmp_name'], $imagePath)) {
                        $imagePathData = basename($imagePath);
                    } else {
                        echo "A apărut o eroare la încărcarea imaginii.";
                    }
                } else {
                    $imagePathData = $antrenor['imagine'];
                }
    
                // Actualizați înregistrarea în baza de date
                $update_sql = "UPDATE antrenori SET nume='$nume', prenume='$prenume', descriere='$descriere', imagine='$imagePathData' WHERE id=$trainer_id";
    
                if ($connection->query($update_sql) === TRUE) {
                    echo " a fost actualizat cu succes.";
    
                    exit;
                } else {
                    echo "Eroare la actualizarea ";
                }
            }
    
            $conn->close();
        } else {
            echo " nu a fost găsit.";
        }
    }

 ?>
 <div class="hide_edit_form">
        <form method="post" class="register_form" enctype="multipart/form-data">
            <label for="nume">Nume</label>
            <input type="text" placeholder="numele antrenorului" name="nume" id="nume" value="<?php echo $trainers['nume']?>" >
            <label for="prenume">Prenume</label>
            <input type="text" placeholder="prenumele antrenorului" name="prenume" id="prenume" value="<?php echo $trainers['prenume']?>" >
            <label for="descriere">Descriere</label> 
            <textarea placeholder="descriere" name="descriere" id="descriere" cols="30" rows="10"><?php echo $trainers['descriere']?></textarea>
            <label for="imagine">Imagine</label>
            <input type="file" name="imagine" id="imagine" value="<?php echo $trainers['imagine']?>" >
            <button type="submit" >Editeaza</button>

        </form>
        </div>
 <?php

}else {
        echo "Acces interzis.";
    }
?>
