<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
<?php
//DB接続設定
$dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    
    //送信ボタンが押された時
    if(isset($_POST["submit1"]))
    //hidden番号が存在しないとき
    { if (isset($_POST["name1"]) && $_POST["name1"]!="" 
     &&isset($_POST["comment1"]) && $_POST["comment1"]!=""
     &&$_POST["num2"]=="") 
 
    //テーブルに名前とコメント、パスワードを入力
   {$sql1 = $pdo -> prepare("INSERT INTO mission5_1 (name, comment, password1) VALUES (:name, :comment, :password1)");
    $sql1 -> bindParam(":name", $name, PDO::PARAM_STR);
    $sql1 -> bindParam(":comment", $comment, PDO::PARAM_STR);
    $sql1 -> bindParam(":password1", $password1, PDO::PARAM_STR);
    $name = $_POST["name1"];
    $comment = $_POST["comment1"];
    //フォームに入力されたパスワード
    $password1 = $_POST["passwordedit"];
    
    $sql1 -> execute();}
    
    //hidden番号が存在するとき
    elseif(isset($_POST["name1"]) && $_POST["name1"]!="" 
     &&isset($_POST["comment1"]) && $_POST["comment1"]!=""
     &&isset($_POST["num2"])&&$_POST["num2"]!="")
    {$id = $_POST["num2"]; //変更する投稿番号
    $name =$_POST["name1"];
    $comment = $_POST["comment1"];
        
    $sql = 'UPDATE mission5_1 SET name=:name,comment=:comment WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
        
    }
    }
   
   //削除ボタンが押された時
   elseif(isset($_POST["submit2"]))
   //削除番号が入力されているとき
   {if (isset($_POST["num"]) && $_POST["num"]!=""&& isset($_POST["password2"]) && $_POST["password2"]!="")
   //パスワードが一致している時
    {$num=$_POST["num"];
    $password2=$_POST["password2"];
    $id = $num;
    $select = 'SELECT * FROM mission5_1';
    $stmt = $pdo->query($select);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
       //パスワードと削除番号が一致している時
        if($row['id']==$num&&$row["password1"]==$password2)
          {
    //対象番号を削除
    $del = 'delete from mission5_1 where id=:id';
    $stmt = $pdo->prepare($del);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();}}}}
    
    
    //編集ボタンがおされた時
    elseif(isset($_POST["submit3"]))
    {if (isset($_POST["num1"]) && $_POST["num1"]!=""&&isset($_POST["password3"]) && $_POST["password3"]!="" )
    {$password3=$_POST["password3"];
    $num1 =$_POST["num1"];
    $id = $num1; 
    $select = "SELECT * FROM mission5_1";
    $stmt = $pdo->query($select);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
    //編集番号とパスワードがテーブルの内容と一致した時
    if($row["id"]==$num1&&$row["password1"]==$password3)
    {
    $name1 = $row["name"];
    $comment1 = $row["comment"]; //変更したい名前、変更したいコメントは自分で決めること
    $editnum= $row["id"];
    $editpass= $row["password1"];
        
        }}
    }}

?>


   <form action=""method="post">
        入力フォーム<br>
  <input type = "hidden" name="num2"value ="<?php 
    if(isset($editnum)){echo $editnum;}
    else{echo "";}?>">
    <input type= "text" name="name1" placeholder="名前"
    value = "<?php if(isset($name1)){echo $name1;}
    else{echo "";}?>">
    <input type="text" name="comment1" placeholder="コメント"
    value ="<?php if(isset($comment1)){echo $comment1;}else{echo "";}?>">
    <input type="text" name="passwordedit" placeholder="パスワード設定"
    value = "<?php if(isset($editpass)){echo $editpass;}
    else{echo "";}?>">
    <input type="submit" name="submit1"><br>
    
    削除番号指定<br>
     <input type="number" name="num" placeholder = "削除番号">
     <input type="text" name="password2" placeholder="パスワード">
    <input type="submit" name="submit2"value="削除"><br>
    
    編集番号指定<br>
     <input type="number" name="num1" placeholder = "編集番号">
     <input type="text" name="password3" placeholder="パスワード">
    <input type="submit" name="submit3"value="編集"><br><br>
</form>
<?php 
$dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
   $sql = "SELECT * FROM mission5_1";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        
        echo $row["id"].",";
        echo $row["name"].",";
        echo $row["comment"]."<br>";
    echo "<hr>";
    }
  ?>
    </body>
    </html>
