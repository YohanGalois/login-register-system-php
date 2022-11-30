<?php
$error=0;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo(__DIR__);
$db = new SQLite3(__DIR__.'/LOGIN.db');
$db->exec('PRAGMA encoding="UTF-16"');

//$db = new SQLite3('analytics.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
//$db->close();
//$db = new SQLite3('/LOGIN.db');
$db->exec('CREATE TABLE IF NOT EXISTS USER(id_user INTEGER PRIMARY KEY AUTOINCREMENT,roles TEXT NOT NULL,nom TEXT NOT NULL,prenom TEXT NOT NULL,adressemail TEXT NOT NULL,passwords TEXT NOT NULL);');
if(!empty($_POST)) 
  {
    if(!empty($_POST['Nom']) && !empty($_POST['Prenom'])&& !empty($_POST['email']) && !empty($_POST['password'])&& !empty($_POST['roles'])) 
    {
        echo $_POST['Nom'];
        $pattern ="/^[a-zA-Z0-9]*@[a-zA-z.0-9]*[a-zA-Z]$/";
        preg_match($pattern, $_POST['email'], $matches);
        if ((
            ($matches == NULL) || (strlen($_POST['email'])>320) 
            || ($_POST['email']==null) || (strlen(substr($_POST['email'],0,strpos($_POST['email'],'@')))>=63)
            )){
                $errorMessage="Email incorrect";
                echo $errorMessage;$error=1;
            };
            $pattern ="/^[A-Z][a-zA-Z]*-?[A-Z][a-zA-Z]*$/";
            $patterns ="/^[A-Z][a-zA-Z]*$/";
            preg_match($pattern, $_POST['Prenom'], $matchess);
            preg_match($patterns, $_POST['Prenom'], $matchesss);
            if(strlen($_POST['Prenom'])>20 && ($matchess!=NULL||$matchesss!=NULL)){
                $errorMessage="Nom incorrect";echo $errorMessage;$error=1;
            };
            $patterns ="/^[A-Z][a-zA-Z]*$/";
            preg_match($patterns, $_POST['Nom'], $matchesss);
            if(strlen($_POST['Nom'])>20 && $matchess!=NULL){
                $errorMessage="Prenom incorrect";echo $errorMessage;$error=1;
            };
            if(strlen($_POST['password'])<8){
                $errorMessage="password incorrect";echo $errorMessage;$error=1;
            };

    };
    
}
else{echo "<p>Veuillez Saisir vos Informations </p>";$error=1;}
if($error!=1){
  $roles= $_POST['roles'] ; $nom= $_POST['Nom'] ; $prenom= $_POST['Prenom'] ; $email= $_POST['email'] ; $password=$_POST['password'] ;
  $pass=crypt($password, '$6$rounds=5000$'.$email.'$');
  $db->exec("INSERT INTO USER (roles,nom,prenom,adressemail,passwords) VALUES ('$roles', '$nom', '$prenom', '$email', '$pass');");
  //$stmt->bindValue(':ints', "1", SQLITE3_INTEGER);
  //$stmt->bindParam($_POST['roles'],roles);
  //$stmt->bindParam($_POST['Nom'],nom);
  //$stmt->bindParam($_POST['Prenom'],prenom);
  //$stmt->bindParam($_POST['email'],adressemail);
  //$stmt->bindParam($_POST['password'],passwords);
  //$result = $stmt->execute();
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
        <legend>Creation de compte </legend>
        <?php
          // Rencontre-t-on une erreur ?
          if(!empty($errorMessage)) 
          {
            echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
          }
        ?>
        <p>
          <label for="Roles">Roles :</label> 
          <input type="text" name="roles" id="roles" value="" />
        </p>
        <p>
          <label for="Nom">Nom :</label> 
          <input type="text" name="Nom" id="Nom" value="" />
        </p>
        <p>
          <label for="Prenom">Prenom :</label> 
          <input type="text" name="Prenom" id="Prenom" value="" />
        </p>
       <p>
          <label for="email">email :</label> 
          <input type="text" name="email" id="email" value="" />
        </p>
        <p>
          <label for="password">Password :</label> 
          <input type="password" name="password" id="password" value="" /> 
        <p></p>


          <input type="submit" name="submit" value="Se logguer" />
        </p>
      </fieldset>
    </form>
  </body>
</html>