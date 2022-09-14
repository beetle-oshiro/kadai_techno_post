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
        echo $alert = "<script>alert(\"URLのセッションが失敗\");</script>";
    }

    //投稿内容を各変数に入れる
    if(isset($_POST['name_submit_post'])){          //メインページで投稿ボタンが押されたか

        if($_POST['name_textarea'] !== ""){         //内容テキストボックスが空でなければ
            $text = $_POST['name_textarea'];

            if($_POST['name_text_name'] !== ""){    //投稿者名テキストボックスが空でなければ
                $name = $_POST['name_text_name'];
            }else{
                $name = "匿名";                     //投稿者名が無い場合は"匿名"を入れる
            }
            if($_POST['name_text_title'] !== ""){   //タイトルテキストボックスが空でなければ
                $title = $_POST['name_text_title'];
            }else{
                $title = "no-title";                //タイトルが無い場合は"no-title"を入れる
            }

            $datetime =  date('Y-m-d H:i:s');       //日時取得
        }else{
            $page_back = $_SESSION['url'];
            $_SESSION['insert_text_judge'] = "none";    //投稿内容が無いのでnoneを入れる
            $_SESSION['url_judge'] = "ok";
            header("Location: ".$page_back);        //メインページに戻るためにリダイレクト？
            exit();                                 //プログラムを強制終了？
        }
    }else{
        // echo $alert = "<script>alert(\"投稿ボタンが押されていない\");</script>";
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>投稿ページ</title>
    <link rel="stylesheet" href="css/post.css">
</head>
<body>
    <div class="class_insert_data wrapper">
        <form action="#" method = "POST" onsubmit="return cancelsubmit()">
            <h1>下の投稿を登録しますか？</h1>
            <div class="class_judge_insert">
                <input type="submit"  class = "class_submit_insert_data" name = "name_submit_insert_data" value = "決定">
                <input type="submit"  class = "class_submit_back_data" name = "name_submit_back_data" value = "戻る">
            </div>
            
            <div class="class_insert_area">
                <!-- <p>投稿者ID：<input type="text" id = "id_p_id" name = "name_text_id_post" value = ""></p> -->
                <p>投稿者名：<input type="text" id = "id_p_name" name = "name_p_name" value = "<?php echo $name; ?>"></p>
                <p>タイトル：<input type="text" id = "id_p_title" name = "name_p_title" value = "<?php echo $title; ?>"></p>
                <p>投稿日時：<input type="text" id = "id_p_datetime" name = "name_p_datetime" value = "<?php echo $datetime; ?>"></p>
                <p>内　容　：<input type="text" id = "id_p_text" name = "name_p_text" value = "<?php echo $text; ?>"></p>
            </div>
        </form>
    </div>
</body>
</html>

<script>
    //各テキストボックスに空欄が無いかのチェック
    function cancelsubmit(){
        var name_inside = document.getElementById('id_p_name').value;
        var title_inside = document.getElementById('id_p_title').value;
        var datetime_inside = document.getElementById('id_p_datetime').value;
        var text_inside = document.getElementById('id_p_text').value;
        
        if(name_inside !== "" && title_inside !== "" && datetime_inside !== "" && text_inside !== ""){
        }else{
            alert("空欄があります");
            return false;
        }
    }

</script>

<?php

    // INSERT処理(投稿)
    if(isset($_POST['name_submit_insert_data'])){
        $name = $_POST['name_p_name'];
        $title = $_POST['name_p_title'];
        $datetime = $_POST['name_p_datetime'];
        $text = $_POST['name_p_text'];

        //INSERT(投稿を登録)
        $sql = "INSERT INTO post_tables(post_name,post_title,post_text,post_date_time) VALUES('$name','$title','$text','$datetime')";
        $insert_posts = $pdo->prepare($sql);
        $res = $insert_posts->execute();
        $pdo = null;

        if ($res) {                                 //SQLが正常に実行されたかチェック
            $_SESSION['insert_judge'] = "ok";       //登録成功
        }else{
            $_SESSION['insert_judge'] = "ng";       //登録失敗
        }

        $page_back = $_SESSION['url'];
        $_SESSION['url_judge'] = "ok";
        header("Location: ".$page_back);            //メインページに戻るためにリダイレクト？
        exit();                                     //プログラムを強制終了？
        
    }

    //戻るボタンを押したとき（メインページに戻る）
    if(isset($_POST['name_submit_back_data'])){
        $page_back = $_SESSION['url'];
        $_SESSION['url_judge'] = "ok";
        header("Location: ".$page_back);           //リダイレクト？
        exit();                                    //プログラムを強制終了？
    }

?>