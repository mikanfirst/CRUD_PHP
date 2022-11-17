<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモ詳細</title>
</head>
<body>
    <?php
    require('dbconnect.php');
    $stmt = $db->prepare('select * from memos where id=?');
    if (!$stmt) {
        die($db->error);
    }
    //メモの詳細ページをURLパラメータで受け取る
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    //URLパラメーターからの不正なIDを処理
    if (!$id) {
        echo '表示するメモを指定してください';
        exit();
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    //データベースから何の変数に割り当てるかを指定
    $stmt->bind_result($id, $memo, $created);
    $result = $stmt->fetch();
    if (!$result) {
        echo '指定されたメモは見つかりませんでした';
        exit();
    }
    ?>

    <div><pre><?php echo htmlspecialchars($memo); ?></pre></div>
    <p>
        <a href="update.php?id=<?php echo $id; ?>">編集する</a> | 
        <a href="delete.php?id=<?php echo $id; ?>">削除する</a> | 
        <a href="/memo">一覧へ</a>
    </p>
</body>
</html>