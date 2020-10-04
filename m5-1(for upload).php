<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1(for upload)</title>
</head>
<body>
    <?php   //5-1編集機能前半　ひな型
        $dsn='データベース名';
        $user='ユーザー名';
        $password='パスワード';
        $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
        $stmt = $pdo->query($sql);
        $sql ='SHOW TABLES';
        $result = $pdo -> query($sql);
        foreach ($result as $row){
            echo $row[0];
            echo '<br>';
        }
        echo "<hr>";
        $sql ='SHOW CREATE TABLE m5_1';
        $result = $pdo -> query($sql);
        foreach ($result as $row){
            echo $row[1];
        }
        echo "<hr>";
    
        if (isset($_POST["e_num"]) and isset($_POST["pass3"])) {
            if(strlen($_POST["e_num"])!=0 and strlen($_POST["pass3"])!=0){
                $sql = 'SELECT * FROM m5_1';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    if($row['id']==$_POST["e_num"] and $row['dpass']==$_POST["pass3"]){
                        $str1=$row['name'];
                        $str2=$row['comment'];
                        $str3=$row['id'];
                        $pass0=$row['dpass'];
                    }
                }
            
            }
        }
    ?>
    <form action="" method="post">
        <input type="text" size="20" name="str1" style="width:200px;" placeholder="名前"  value="<?php if(isset($str1)) {echo $str1;} ?>">
        <input type="text" size="20" name="str2" style="width:200px;" placeholder="コメント" value="<?php if(isset($str2)) {echo $str2;} ?>">
        <input type="hidden" size="20" name="str3" style="width:200px; "placeholder="編集対象番号表示" value="<?php if(isset($str3)) {echo $str3;} ?>">
        <input type="hidden" size="20" name="pass0" style="width:200px; "placeholder="編集対象パスワード表示" value="<?php if(isset($pass0)) {echo $pass0;} ?>">
        <input type="text" size="20" name="pass" style="width:200px; "placeholder="パスワード" >
        <input type="submit" name="submit" value="送信">
        <br>
        <br>
    </form>
    <form action="" method="post">
        <input type="number" size="20" name="d_num" style="width:200px;" placeholder="削除したい投稿の番号を入力">
        <input type="text" size="20" name="pass2" style="width:200px; "placeholder="パスワード" >
        <input type="submit" name="delete" value="削除">
        <br>
        <br>
    </form>
    <form action="" method="post">
        <input type="number" size="20" name="e_num" style="width:200px;" placeholder="編集したい投稿の番号を入力">
        <input type="text" size="20" name="pass3" style="width:200px; "placeholder="パスワード" >
        <input type="submit" name="edit" value="編集">
    </form>
    <?php   
            $str1 = $_POST["str1"];
            $str2 = $_POST["str2"];
            //$str1,$str2をフォームより上に書いてはいけない。(削除ボタンや編集ボタンを押すと勝手に行数が増えるため。)
            $date = date("Y/m/d H:i:s");
            $str=$str1.$str2;
            $d_num=$_POST["d_num"];
            $e_num=$_POST["e_num"];
            $str3 = $_POST["str3"];
            $pass=$_POST["pass"];
            $pass2=$_POST["pass2"];
            $pass3=$_POST["pass3"];
            $pass0=$_POST["pass0"];
            
            //送信機能(後で編集機能も付ける)
            if(isset($_POST["str1"]) and isset($_POST["str2"])) {
                if(strlen($str1)!=0 and strlen($str2)!=0 and strlen($pass)!=0){
                    if(strlen($str3==0)){
                        $sql = $pdo -> prepare("INSERT INTO m5_1 (time, name, comment, dpass) VALUES (:time, :name, :comment, :dpass)");
                        $sql -> bindParam(':time', $time, PDO::PARAM_STR);
                        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                        $sql -> bindParam(':dpass', $dpass, PDO::PARAM_STR);
                        $time=" ".$date;
                        $name=" ".$str1;
                        $comment=" ".$str2;
                        $dpass = " ".$pass; //好きな名前、好きな言葉は自分で決めること
                        $sql -> execute();
                    }
                    elseif($_POST["pass0"]==$_POST["pass"]){
                        $id = $str3; //変更する投稿番号
                        $time=" ".$date;
                        $name = " ".$_POST["str1"];
                        $comment = " ".$_POST["str2"]; //変更したい名前、変更したいコメントは自分で決めること
                        $dpass = $pass0; //好きな名前、好きな言葉は自分で決めること
                        $sql = 'UPDATE m5_1 SET time=:time,name=:name,comment=:comment,dpass=:dpass WHERE id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':time', $time, PDO::PARAM_STR);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                        $stmt->bindParam(':dpass', $dpass, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                    
                       
                    }
                }
            }
            //削除機能(後でパスワード機能もつける。)
            //10/3 途中
         if (isset($_POST["d_num"]) and isset($_POST["pass2"])) {
                if(strlen($_POST["d_num"])!=0 and strlen($pass2)!=0){
                    $sql = 'SELECT * FROM m5_1';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        if($row['id']==$_POST["d_num"] and $row['dpass']==$_POST["pass2"]){
                        $id = $_POST["d_num"];
                        $sql = 'delete from m5_1 where id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                        }
                    }
                }
         }
         
         
         
         $sql = 'SELECT * FROM m5_1';
         $stmt = $pdo->query($sql);
         $results = $stmt->fetchAll();
         foreach ($results as $row){
      //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].',';
         echo $row['time'].',';
         echo $row['name'].',';
         echo $row['comment']."<br>";
         echo "<hr>";
         }
    ?>
</body>
</html>