<?php 
session_start();
echo "Hello ".$_SESSION['nom']." ".$_SESSION['prenom']; 
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Formulaire d'authentification</title>
  </head>
  <body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <legend>Application</legend>
        <?php
          // Rencontre-t-on une erreur ?
          if(!empty($errorMessage)) 
          {
            echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
          }
        ?>

       <p>
    </form>
  </body>
</html>