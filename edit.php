<?php
require_once('class/EditData.php');
require_once('class/DatabaseEntry.php');

// エスケープ処理
function hsc($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// 編集する文章をデータベースから取り出し
$edits = new Edit($_REQUEST);
list($edit,$message) = $edits->editData();

// 入力の確認
$confirmation = new Confirmation();
list($insert,$empty) = $confirmation->inputConfirmation($_POST);

// データベースの登録
$de = new Entry($_POST);
$de->updataEntry($insert);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集画面</title>
  <!-- style -->
  <link rel="stylesheet" href="css/reset/reset.css">
  <link rel="stylesheet" href="css/edit_reply/e_r.css">
</head>
<body>
  <div class="board_base">
  <!-- コンテンツヘッダー -->
    <div class="board_header">
      <p>MyBBS 掲示板</p>
    </div>

  <!-- コンテンツフォーム -->
    <div class="board_form">
      <form action="" method="post">
        <input type="hidden" name="投稿ID" value="<?php echo(hsc($edit['投稿ID']));?>">
        <div>
          <label for="投稿者">投稿者</label>
          <input type="text" name="投稿者" maxlength="13" value="<?php echo(hsc($edit['投稿者']));?>">
          <?php if($empty[0] == 1): ?>
            <p class="empty">入力してください</p>
          <?php endif;?>
        </div>
        <div>
          <p>本文</p>
          <textarea class="form_textarea" name="本文" rows="4" cols="50" maxlength="64" placeholder=""><?php echo(hsc($edit['本文']));?></textarea>
          <?php if($empty[1] == 1): ?>
            <p class="empty">入力してください</p>
          <?php endif;?>
        </div>
        <div class="edit_button">
            <input class="form_submit" type="submit" value="投稿">
          <div class="edit_button_a">
            <a href="index.php">
              <div class="board_option_parts_button">
                戻る
              </div>
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>