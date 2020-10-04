<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    <?php
            $filename="mission_3-5.txt";
            if (isset($_POST["e_num"]) and isset($_POST["pass3"])) {
                if(strlen($_POST["e_num"])!=0 and strlen($_POST["pass3"])!=0){
                    $ediCon = file($filename);
                    $fp_2 = fopen($filename, "w");
                    for ($k= 0; $k < count($ediCon); $k++) {
                        $ediDate = explode("<>", $ediCon[$k]);
                        if ($ediDate[0] == $_POST["e_num"]) {
                            if($ediDate[4]==$_POST["pass3"]){
                                $str1=$ediDate[2];
                                $str2=$ediDate[3];
                                $str3=$ediDate[0];
                                $pass0=$ediDate[4];
                                fwrite($fp_2, $ediCon[$k]);
                            }
                            else{
                                fwrite($fp_2,$ediCon[$k]);
                            }
                        }
                        else{
                            fwrite($fp_2,$ediCon[$k]);
                        }
                    }
                    fclose($fp_2);    
                }   
                else{
                    echo "";   
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
            echo"<br>";
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
            //73~97行目は"編集する場合、投稿番号またはパスワードを再確認し、編集フォームに2つとも入れ直して下さい。<br>";と、
            //"編集したい投稿の番号とパスワードを入力してください。<br>";   をフォームの下に表示させるためだけの条件分岐。
            if (isset($_POST["e_num"]) and isset($_POST["pass3"])) {
                if(strlen($_POST["e_num"])!=0 and strlen($_POST["pass3"])!=0){
                    $ediCon = file($filename);
                    $fp_2 = fopen($filename, "w");
                    for ($k= 0; $k < count($ediCon); $k++) {
                        $ediDate = explode("<>", $ediCon[$k]);
                        if ($ediDate[0] == $_POST["e_num"]) {
                            if($ediDate[4]==$_POST["pass3"]){
                                fwrite($fp_2, $ediCon[$k]);
                            }
                            else{
                                fwrite($fp_2, $ediCon[$k]);
                                echo "<font color=\"red\">投稿を編集する場合、投稿番号またはパスワードを再確認し、編集フォームに2つとも入れ直して下さい。</font><br>";
                            }
                        }
                        else{
                            fwrite($fp_2, $ediCon[$k]);
                        }
                    }
                    fclose($fp_2);    
                }   
                else{
                    echo "<font color=\"blue\">編集したい投稿の番号とパスワードを入力してください。</font><br>";   
                }
            }
            if(isset($_POST["str1"]) and isset($_POST["str2"])) {
                $fp = fopen($filename,"a");
                if(strlen($str1)!=0 and strlen($str2)!=0 and strlen($pass)!=0){
                    if(strlen($str3==0)){
                        $postCon = file($filename);
                        if (file_exists($filename)) {
                            $postDate = explode("<>", $postCon[count($postCon)-1]);
                            $num=$postDate[0]+1;
                        } 
                        else {
                            $num = 1;
                        }
                        $str=$num."<>".$date."<>".$str1."<>".$str2."<>".$pass."<>";
                        $str=$str.PHP_EOL;
                        fwrite($fp,$str);
                    }
                    else{
                        $rewriteCon=file($filename);
                        $fp_0=fopen($filename,"w");
                        ////ファイルを書き込みモードでオープン＋中身を空に
                        foreach ($rewriteCon as $reline) {
                            $rewDate=explode("<>", $reline);
                            if ($rewDate[0] == $str3){
                                if($_POST["pass"]==$rewDate[4]){
                                    fwrite($fp_0, $str3."<>".$date ."<>".$str1."<>".$str2."<>".$pass0."<>"."\n");
                                }
                                else{
                                    fwrite($fp_0, $reline);
                                    echo "<font color=\"red\">投稿を編集する場合、投稿番号またはパスワードを再確認し、編集フォームに2つとも入れ直して下さい。</font><br>";
                                }
                            }
                            else{
                                fwrite($fp_0, $reline);
                            }
                        }
                    fclose($fp_0);
                    }
                }
                else{
                    fwrite($fp);
                    echo "<font color=\"orange\">名前とコメントとパスワードを入力してください。</font><br>";
                }
                fclose($fp);
            }
            if (isset($_POST["d_num"]) and isset($_POST["pass2"])) {
                if(strlen($_POST["d_num"])!=0 and strlen($pass2)!=0){
                    $delCon = file($filename);
                    $fp_1 = fopen($filename, "w");
                    for ($j = 0; $j < count($delCon); $j++) {
                        $delDate = explode("<>", $delCon[$j]);
                        if ($delDate[0] == $d_num) {
                            if($delDate[4]==$pass2){
                                fwrite($fp_1);
                            } 
                            else{
                                fwrite($fp_1, $delCon[$j]);
                                echo "<font color=\"red\">投稿を削除する場合、投稿番号またはパスワードを再確認し、削除フォームに2つとも入れ直して下さい。</font><br>";
                            }
                        }
                        else{
                            fwrite($fp_1, $delCon[$j]);
                        }
                    }
                    fclose($fp_1);
                }
                else{
                    echo "<font color=\"blue\">削除したい投稿の番号とパスワードを入力してください。</font><br>";
                }
            }
            else{
                echo"";
            }
            if(file_exists($filename)){
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                         $comment = explode("<>",$line);
                         $com_2=$comment[0]." ".$comment[1]." ".$comment[2]." ".$comment[3];
                         echo $com_2."<br>";
                    }
            }               
    ?>
</body>
</html>