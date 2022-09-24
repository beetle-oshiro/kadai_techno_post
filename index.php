<?php

    session_start();                    //セッションスタート

    $_SESSION['url_judge'] = "ok";      //削除ページで$_SERVER['HTTP_REFERER']を読み込むため

    //データベースへアクセス
    $dsn = 'mysql:host=mysql630.db.sakura.ne.jp;dbname=beetle45046_db;charset=utf8mb4';
    $username = 'beetle45046';
    $password = 'seiko5_porterswans';

    try {
    $pdo = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
    }


    //登録できているかの判断
    if($_SESSION['insert_judge'] !== ""){
        switch ($_SESSION['insert_judge']) {
            case 'ok':
                echo $alert = "<script>alert(\"登録成功しました。\");</script>";
                break;
            case 'ng';
                echo $alert = "<script>alert(\"登録失敗しました。\");</script>";
                break;
            default:
            echo $alert = "<script>alert(\"登録リセットされてる\");</script>";
                break;
        }
        $_SESSION['insert_judge'] = "";
    }

    //削除できているかの判断
    if($_SESSION['delete_judge'] !== ""){
        switch ($_SESSION['delete_judge']) {
            case 'ok':
                echo $alert = "<script>alert(\"削除成功しました。\");</script>";
                break;
            case 'ng';
                echo $alert = "<script>alert(\"削除失敗しました。\");</script>";
                break;
            default:
            echo $alert = "<script>alert(\"削除リセットされてる\");</script>";
                break;
        }
        $_SESSION['delete_judge'] = "";
    }

    if($_SESSION['insert_text_judge'] === "none"){      //投稿内容が無かった場合は
        echo $alert = "<script>alert(\"投稿内容がありません\");</script>";
        $_SESSION['insert_text_judge'] = "have";
    }


    //SELECT(全ての投稿情報を取ってくる)
    $contents = [[]];                               //配列にする
    $y = 0;
    $sql = "SELECT * FROM post_tables";
    $select_posts = $pdo->query($sql);
    foreach($select_posts as $record){
        $contents[$y][] = $record['post_id'];
        $contents[$y][] = $record['post_name'];
        $contents[$y][] = $record['post_title'];
        $contents[$y][] = $record['post_date_time'];
        $contents[$y][] = $record['post_text'];
        $y += 1;
    }
    $contents_sum = count($contents);               //コンテンツの総数
    
    $max = 10;                                      //1ページの表示数
    $max_page = ceil($contents_sum / $max);         //ページの最大値

    if (!isset($_GET['page'])) {
        $page = 1;
      } else {
        $page = $_GET['page'];
      }
    
      $start = $max * ($page - 1);                              //スタートするページを取得
      $view_page = array_slice($contents, $start, $max, true);  //表示するページを取得

    //SELECT(投稿情報を表示)
    $sql = "SELECT * FROM post_tables";
    $select_posts = $pdo->query($sql);
    // $pdo = null;
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>掲示板</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="class_form">
        <form action = "post.php" method = "POST" class = "class_form_postarea wrapper">
            <div class="class_text_name">
                <label for="id_text_name">投稿者名</label>
                <input id = "id_text_name" type="text" name = "name_text_name">
            </div>
            <div class="class_text_title">
                <label for="id_text_title">タイトル</label>
                <input id = "id_text_title" type="text" name = "name_text_title">
            </div>
    
            <textarea name="name_textarea" id="id_textarea" cols="30" rows="4"></textarea>
            <div class="class_button_top">
                <button><a href="login.php" class = "class_a_top">TOP</a></button>
                <input type="submit" name = "name_submit_post" value = "投稿">
            </div>
        </form>
        
        <div class="class_reset wrapper">
            <form action="#" method = "POST">
                <input type="submit" class = "class_submit_reset" value = "再読込">
            </form>
        </div>
    </div>
    <!-- 投稿を表示していく -->
    <section class = "class_section wrapper">
        <?php if( !empty($view_page) ){ ?>
            <?php foreach( $view_page as $value ){ ?>
                <form action="delete.php"  id = "id_form_post" method = "POST" name = "name_form_display">
                    <article class = "class_article_data">
                        <input type="text" id = "id_dummy_text_id" name = "name_dummy_text_id" value = <?php echo $value[0]; ?>>
                        <input type="text" id = "id_dummy_text_name" name = "name_dummy_text_name" value = <?php echo $value[1]; ?>>
                        <input type="text" id = "id_dummy_text_title" name = "name_dummy_text_title" value = <?php echo $value[2]; ?>>
                        <input type="text" id = "id_dummy_text_datetime" name = "name_dummy_text_datetime" value = <?php echo $value[3]; ?>>
                        <input type="text" id = "id_dummy_text_text" name = "name_dummy_text_text" value = <?php echo $value[4]; ?>>
                        <input type="text" id = "id_dummy_text_judge" name = "name_dummy_text_judge" value = "0"; ?>
                        <p>投稿ID：<?php echo $value[0]; ?>
                        　　投稿者名：<?php echo $value[1]; ?>
                        　　タイトル：<?php echo $value[2]; ?>
                        　　<?php echo $value[3]; ?>
                        <p><?php echo $value[4]; ?></p>
                        <div class="class_each_button">
                            <?php
                                if($_POST['name_text_login'] === $value[1]){
                                    $test_name = $value[1];
                                    echo "<p class = \"class_p_update\" ><input type=\"submit\" id = \"id_submit_update\" name = \"name_submit_update\" onclick = \"click_update()\" value = \"編集\"></p>";
                                }
                            ?>
                            <p class = "class_p_delete" ><input type="submit" id = "id_submit_delete" name = "name_submit_delete" value = "削除"></p>
                        </div>
                    </article>
                </form>
            <?php }; ?>
        <?php }; ?>
    </section>

    <!-- ページングの部分 -->
    <div class="class_page wrapper">
        <?php  if ($page > 1): ?>
          <a href="index.php?page=<?php echo ($page-1); ?>">前のページへ</a>
        <?php endif; ?>
        <?php  if ($page < $max_page): ?>
          <a href="index.php?page=<?php echo ($page+1); ?>">次のページへ</a>
        <?php endif; ?>
    </div>

</body>

</html>

<script>

    //編集ページに飛ぶようにactionの行先を変更
    function click_update(){
        alert("ラジオ");
        var form_edit = document.getElementById('id_form_post');
        alert(form_edit.id);
        // var form_edit = document.getElementById('id_form_post');
        form_edit.action = 'update.php';
    }

    // //削除ページに飛ぶようにactionの行先を変更
    // function click_delete(){
    //     var form_edit = document.getElementById('id_form_post');
    //     form_edit.action = 'delete.php';
    // }

</script>

<?php
    // 新規か編集かの判断をする
    if (isset($_POST['name_dummy_text'])) {
        $login_type = $_POST['name_dummy_text'];
        if($login_type === "new"){
        }else{
            if (isset($_POST['name_text_login'])){
                $post_update_name = $_POST['name_text_login'];
                $sql = "SELECT * FROM post_tables WHERE post_name = '$post_update_name'";
                $select_posts = $pdo->query($sql);
                foreach($select_posts as $record){
                    $test = $record['post_id'];
                    $post_name = $record['post_name'];
                    echo "<script>document.getElementById('id_text_name').value = " . "\"" . $post_name . "\"" . ";</script>"; 
                }
                if(!isset($post_name)){     //投稿者名が登録されていなかったら
                    echo $alert = "<script>alert(\"その投稿者名では登録されていません\");</script>";
                    //ログインページに移動
                    echo "<script>window.location = 'https://beetle45046.sakura.ne.jp/kadai_techno/login.php';</script>"; 
                }
            }else{
                echo $alert = "<script>alert(\"投稿者名を入力してください\");</script>";
            }
        }
        // echo $alert = "<script>alert('$login_type');</script>";
    }

    $pdo = null;
?>

