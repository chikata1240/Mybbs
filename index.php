<?php
require_once('class/DatabaseEntry.php');
require_once('class/Pagenation.php');

// エスケープ処理
function hsc($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// ページ数のMaxを確認
$mxs = new Maxpage;
$mx = $mxs->maxPage();

// ページの誘導
$pgs = new Induction($mx);
$pg = $pgs->pageInduction($_REQUEST);

// コンテンツの引き出し
$cons = new Contens($pg);
$con = $cons->pageing();

// 入力の確認
$confirmation = new Confirmation();
list($insert,$empty) = $confirmation->inputConfirmation($_POST);

// データベースの登録
$de = new Entry($_POST);
$de->insertEntry($insert);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿一覧</title>
  <!-- style -->
  <link rel="stylesheet" href="css/reset/reset.css">
  <link rel="stylesheet" href="css/board/board.css">
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
        <div>
          <label for="投稿者">投稿者</label>
          <input type="text" name="投稿者" maxlength="13" value="<?php echo(hsc($_POST['投稿者']))?>">
          <?php if($empty[0] == 1): ?>
            <p class="empty">入力してください</p>
          <?php endif;?>
        </div>
        <div>
          <p>本文</p>
          <textarea class="form_textarea" name="本文" rows="4" cols="50" maxlength="64" placeholder=""><?php echo(hsc($_POST['本文']))?></textarea>
          <?php if($empty[1] == 1): ?>
            <p class="empty">入力してください</p>
          <?php endif;?>
        </div>
        <div>
          <input class="form_submit" type="submit" value="投稿">
        </div>
      </form>
    </div>
  <hr>

  <!-- コンテンツ一覧 -->
  <?php foreach($con as $item): ?>
    <div class="board_parts">
      <!-- コンテンツ -->
      <div class="board_name_time">
        <p>投稿者：<?php echo(hsc($item['投稿者']));?></p>
        <p>/</p>
        <p>投稿日時：<?php echo(hsc($item['投稿日時']));?></p>
      </div>
      <div class="board_text"><?php echo(hsc($item['本文']));?></div>
      <!-- オプション -->
      <div class="board_option">
        <div class="board_option_parts">
          <a href="edit.php?id=<?php echo(hsc($item['投稿ID']));?>">
            <div class="board_option_parts_button">
              編集
            </div>
          </a>
        </div>
        <div class="board_option_parts">
          <a href="delete.php?id=<?php echo(hsc($item['投稿ID']));?>">
            <div class="board_option_parts_button">
              削除
            </div>
          </a>
        </div>
        <div class="board_option_parts">
          <a href="reply.php?id=<?php echo(hsc($item['投稿ID']));?>">
            <div class="board_option_parts_button">
              返信
            </div>
          </a>
        </div>
      </div>
    </div>
  <?php endforeach;?>

  <!-- ページネーション  -->
    <div class="board_pagenation">
      <?php if($pg >= 2): ?>
        <div class="board_pagenation_parts">
          <a href="index.php?page=<?php echo($pg-1);?>"><?php echo($pg-1);?>ページへ</a>
        </div>
      <?php endif; ?>
      <?php if($pg >= 2 && $pg < $mx): ?>
        <div class="board_pagenation_parts">
          |
        </div>
      <?php endif; ?>
      <?php if($pg < $mx): ?>
        <div class="board_pagenation_parts">
          <a href="index.php?page=<?php echo($pg+1);?>"><?php echo($pg+1);?>ページへ</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>