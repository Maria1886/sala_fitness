<?php
$currentPath = __FILE__;
$parentPath = dirname(dirname($currentPath));
$thirdPath = $parentPath . '/database';
var_dump(__DIR__ . "/../");
// require $thirdPath . '/connection.php';

// require "../database/connection.php";
$sql="SELECT * FROM `antrenori`";
$result = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrenori</title>
    <link rel="stylesheet" href="../css/style.css"> 

    <!-- folosim biblioteci pentru adaugare de icon pe pagina -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> 
</head>
<body>
    <div class="admin">
        <div class="admin_nav">
        <?php require "admin_navigation.php"?>
        </div>
        <div class="admin_table">
        <div class="admin_info">
        <div>
        <button class="add_trainers_btn"> 
          <i class="fa-solid fa-user-plus"></i>
          <span>Antrenor nou</span>
        </button>
        </div>
        <table class="trainers_table">
        <tr>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Actiuni</th>
        </tr>
       <?php
       if ($result->num_rows > 0) {
        foreach ($result as $row) {
            ?>
            <tr>
                <td>
                    <?php echo $row["nume"]?>
                </td>
                <td>
                    <?php echo $row["prenume"]?>
                </td>
                <td class="trainers_actions">
                <a href="#" class="edit-trainer-btn" data-id="<?php echo $row['id']; ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                 <form action="delete_trainer.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                    <button type="submit" onclick="return confirm('Sunteți sigur că doriți să ștergeți')">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
                </form>
                    <!-- <form action="" method="POST">
                        <button type="submit">
                        <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form> -->
                </td>
            </tr>
            <?php
        }
       }else {
        echo "Nu s-au găsit antrenori.";
    }
       ?>
        </table>
       
        </div>
        <div class="admin_add_trainer">
        <?php require "add_trainers_form.php" ?>
        <?php require "edit_trainers_form.php" ?>
        </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
        $(document).ready(function(){
            $(".edit-trainer-btn").click(function(e){
                e.preventDefault();
                var trainerId = $(this).data('id');
                $.ajax({
                    url: 'edit_trainers_form.php',
                    type: 'POST',
                    data: { id: trainerId },
                    success: function(response){
                        $(".admin_add_trainer").html(response);
                    }
                });
            });
        });
    </script>
   <script src="../js/script.js"></script>
</body>
</html>