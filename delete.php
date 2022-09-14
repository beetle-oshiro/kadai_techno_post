<?php

    session_start();            //セッションスタート

    //データベースへアクセス
    $dsn = 'mysql:host=mysql630.db.sakura.ne.jp;dbname=beetle45046_db;charset=utf8mb4';
    $username = 'beetle45046';
    $password = 'seiko5_porterswans';

    try {
    $pdo = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
    }

    //前ページのURLをセッションに入れる
    if($_SESSION['url_judge'] !== "ng"){
        $_SESSION['url_judge'] = "ng";
        $_SESSION['url'] = $_SERVER['HTTP_REFERER'];
    }else{
        echo $alert = "<script>alert(\"セッションは失敗\");</script>";
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>削除ページ</title>
    <link rel="stylesheet" href="css/delete.css">
</head>
<body>
    <div class="class_delete_data wrapper">
        <form action="#" method = "POST">
            <h1>下の投稿を削除しますか？</h1>
            <div class="class_judge_delete">
                <input type="submit"  class = "class_submit_dlete_data" name = "name_submit_delete_data" value = "決定">
                <input type="submit"  class = "class_submit_back_data" name = "name_submit_back_data" value = "戻る">
            </div>
            
            <div class="class_delete_area">
                <p>投稿者ID：<input type="text" id = "id_p_id" name = "name_text_id_delete" value = ""></p>
                <p>投稿者名：<input type="text" id = "id_p_name" value = ""></p>
                <p>タイトル：<input type="text" id = "id_p_title" value = ""></p>
                <p>投稿日時：<input type="text" id = "id_p_datetime" value = ""></p>
                <p>内　容　：<input type="text" id = "id_p_text" value = ""></p>
            </div>
        </form>
    </div>
</body>

</html>

<?php 

    //メインフォームのデータを取得して各テキストボックスに出力
    if(isset($_POST['name_dummy_text_id'])){
        $id = $_POST['name_dummy_text_id'];
        $name = $_POST['name_dummy_text_name'];
        $title = $_POST['name_dummy_text_title'];
        $datetime = $_POST['name_dummy_text_datetime'];
        $text = $_POST['name_dummy_text_text'];

        echo "<script>document.getElementById('id_p_id').value = " . "\"" . $id . "\"" . ";</script>";
        echo "<script>document.getElementById('id_p_name').value = " . "\"" . $name . "\"" . ";</script>";
        echo "<script>document.getElementById('id_p_title').value = " . "\"" . $title . "\"" . ";</script>";
        echo "<script>document.getElementById('id_p_datetime').value = " . "\"" . $datetime . "\"" . ";</script>";
        echo "<script>document.getElementById('id_p_text').value = " . "\"" . $text . "\"" . ";</script>";
    }

    // DELETE処理(生徒)
    if(isset($_POST['name_text_id_delete'])){
        
        //戻るボタンが押されていないかチェック
        if(isset($_POST['name_submit_back_data'])){
            $page_back = $_SESSION['url'];
            $_SESSION['url_judge'] = "ok";
            header("Location: ".$page_back);
            exit();
        }else{      //戻るボタンが押されていない場合は決定ボタンが押されているので削除を実行する
            $id = $_POST['name_text_id_delete'];
            $sql = "DELETE FROM post_tables WHERE post_id = $id";
            $delete_posts = $pdo->prepare($sql);
            $res = $delete_posts->execute();
            $pdo = null;
    
            if ($res) {
                // echo $alert = "<script>alert(\"削除成功\");</script>";
                $_SESSION['delete_judge'] = "ok";
            }else{
                // echo $alert = "<script>alert(\"削除失敗\");</script>";
                $_SESSION['delete_judge'] = "ng";
            }
            $page_back = $_SESSION['url'];
            $_SESSION['url_judge'] = "ok";
            header("Location: ".$page_back);
            exit();
        }
    }else{
        // echo $alert = "<script>alert(\"できていない\");</script>";
    }

?>