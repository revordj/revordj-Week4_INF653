<?php
    require("database.php");
    $newtask = filter_input(INPUT_POST, "newtask", FILTER_SANITIZE_STRING);
    $newdesc = filter_input(INPUT_POST, "newdesc", FILTER_SANITIZE_STRING);
    

    if ($newtask){
        $query = "INSERT INTO todoitems
                      (Title, Description)
                    VALUES
                        (:newtask, :newdesc)";
        $statement = $db->prepare($query);
        $statement->bindValue(':newtask', $newtask);
        $statement->bindValue(':newdesc', $newdesc);

        $statement->execute();
        $statement->closeCursor();


    }


    $query = 'SELECT * FROM todoitems';
    

    $statement = $db->prepare($query);
    $statement->execute();

    $results = $statement->fetchAll();
    $statement->closeCursor();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Week 4 Project</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <main>
        <?php
            if (!empty($results)) {      ?>
                <section>
                <table id="results_table">
                <tr>
                     <h2>ToDo List</h2>
                </tr>
                <?php foreach ($results as $result) {
                    $task = $result['Title'];
                    $desc = $result['Description'];
                    $id = $result['ItemNum'];
                        
                ?>
                <tr>
                    <form class="delete" action="delete_record.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                        <td id="data"> <strong> <?php echo $task ?> </strong> <br> <?php echo $desc ?> </td><td id = "button"><button class='delbtn'>Delete </button> </td>
                    </form>
                </tr>
                    <?php } ?>
                    </table>
                    </section>
        <?php } else { ?>
            <p>Sorry, no results. </p>
        <?php } ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="newtask"> Task:</label>
                <input type="text" id="newtask" name="newtask" maxlength="20" required>
                <label for="newdesc">Description::</label>
                <input type="text" id="newdesc" name="newdesc" maxlength="50" required>
                <button> Add new Task </button>
        </form>

    </main>
</body>
</html>