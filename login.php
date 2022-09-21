<?php
    session_start();            //セッションスタート

    $_SESSION['login_type'] = "new";    //ラジオボタンは新規でスタートする
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>ログイン画面</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <form action="index.php" method = "POST" class = "class_login wrapper">
        <div class="class_radio_login">
            <div class="class_radio_insert">
                <input type="radio" id = "id_radio_login1" name = "name_radio_login" value = "new" onchange = "post_insert()" checked>
                <label for="id_radio_login1">新規</label>
            </div>
            <div class="class_radio_update">
                <input type="radio" id = "id_radio_login2" name = "name_radio_login" value = "edit" onchange = "post_update()">
                <label for="id_radio_login2">編集</label>
            </div>
        </div>
        <div class="class_login_text_button">
            <input type="text" id = "id_text_login" name = "name_text_login" value = "↓の投稿を押してください">
            <input type="submit" id = "id_submit_login" name = "name_submit_login" value = "投稿">
        </div>
        <input type="text" id = "id_dummy_text" name = "name_dummy_text" value = "new">
    </form>
</body>
</html>

<script>

    //新規（ラジオ）を押したら
    function post_insert(){
        document.getElementById('id_text_login').value ="↓の投稿を押してください";
        document.getElementById('id_text_login').disabled = true;
        document.getElementById('id_submit_login').value ="投稿";
        document.getElementById('id_dummy_text').value = $("input[name='name_radio_login']:checked").val();
    }
    //編集（ラジオ）を押したら
    function post_update(){
        document.getElementById('id_text_login').value ="";
        document.getElementById('id_text_login').disabled = false;
        document.getElementById('id_text_login').placeholder = "投稿IDを入力してください";
        document.getElementById('id_submit_login').value ="ログイン";
        document.getElementById('id_dummy_text').value = $("input[name='name_radio_login']:checked").val();
    }


// $(function () {
//     // ラジオボタンを選択変更したら実行
//     $('input[name="name_radio_login"]').change(function () {

//         // value値取得
//         // var val = $(this).checked();
//         var val2 = $('input[name="name_radio_login"]:checked').label();
//         alert(val2);
//         // コンソールログで確認
//         // console.log(val);
//       /*
//        ここに好きな処理
//        */
//     });
// });
</script>