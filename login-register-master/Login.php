<?php
  $error=0;
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  echo(__DIR__);
  echo("\n".$_SERVER['SERVER_NAME']);
  $db = new SQLite3(__DIR__.'/LOGIN.db');
  $db->exec('PRAGMA encoding="UTF-16"');
  //$stmt2 = $db->prepare('SELECT * FROM USER ');

  /*foreach ($stmt2->execute()->fetchArray() as $c => $k){
    echo $c."->".$k."\n";
  };*/
  $errorMessage = '';
    //$passwordds=$db->query('SELECT * from USER where adressemail="yohan@galois.fr";')->fetchArray()['passwords'];
    
    //echo $passwordds;
    if(!empty($_POST)) 
  {
    if(isset($_POST['redirection'])){header('Location: Register.php');};
    // Les identifiants sont transmis ?
    if(!empty($_POST['login']) && !empty($_POST['password'])) 
    {  
      $mail=$_POST['login'];echo $mail;
      $stmt = $db->prepare('SELECT * FROM USER WHERE adressemail=:id');
      $stmt->bindValue(':id', $mail, SQLITE3_TEXT);
      
      $password=$stmt->execute()->fetchArray()['passwords'];
      echo $password;
      //$passwordsssss=$db->query('SELECT * from USER where adressemail='.$mail.';')->fetchArray();
      //echo $passwordsssss;
      $email=$_POST['login'];
      $pass=crypt($password, '$6$rounds=5000$'.$email.'$');
      $pass=crypt($_POST['password'], '$6$rounds=5000$'.$_POST['login'].'$');
      if($pass !== $password) 
      {
        $errorMessage = 'Mauvais password !';
      }
      else{
        $nom=$stmt->execute()->fetchArray()['nom'];
        $prenom=$stmt->execute()->fetchArray()['prenom'];
        session_start();
        $_SESSION['nom']=$nom;
        $_SESSION['prenom']=$prenom;
        header('Location: main.php');
        //echo "hello".$nom." ".$prenom;
        // On enregistre le login en session
        //$_SESSION['login'][] = $_SESSION['login'];
        //$_SESSION['log']= $_POST['login'];
        // On redirige vers le fichier admin.php
        //header('Location: 2.php');
        //exit();
      };
    }
  }
      else
    {
      $errorMessage = 'Veuillez inscrire vos identifiants svp !';
    }
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Formulaire d'authentification</title>
  </head>
  <body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <fieldset>
        <legend>Identifiez-vous</legend>
        <?php
          // Rencontre-t-on une erreur ?
          if(!empty($errorMessage)) 
          {
            echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
          }
        ?>
       <p>
          <label for="login">Login :</label> 
          <input type="text" name="login" id="login" value="" />
        </p>
        <p>
          <label for="password">Password :</label> 
          <input type="password" name="password" id="password" value="" /> 
          <input type="submit" name="submit" value="Se logguer" />
        </p><p>
          <label for="pasdecomptes">Vous n'avez pas de comptes :</label> 
          <input type="submit" name="redirection" value="Cliquez ici" />
        </p>
      </fieldset>
      
    </form>
  </body>
</html>