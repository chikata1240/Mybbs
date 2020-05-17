<?php
// 入力の確認
class Confirmation{
  private $insert = [];
  private $empty = [];

  public function __construct()
  {
    unset($this->insert);
    unset($this->empty);
  }

  public function inputConfirmation($posts){
    if(!empty($posts)){
      if(!empty($posts['投稿者'])){
        $this->insert[0] = 1;
      }else{
        $this->empty[0] = 1;
      }
      if(!empty($posts['本文'])){
        $this->insert[1] = 1;
      }else{
        $this->empty[1] = 1;
      }
      return [$this->insert,$this->empty];
    }
  }
}

// データベースへの登録
class Entry {
  private $id;
  private $name;
  private $text;
  private $db;
  private $statment;
  private $updata;
  private $ini;
  private $count;

  public function __construct($post)
  {
    $this->id = $post['投稿ID'];
    $this->name = $post['投稿者'];
    $this->text = $post['本文'];
    // 例外処理
    try {
      $this->ini = parse_ini_file('db.ini', false);
      $this->db = new PDO('mysql:host=' . $this->ini['host'] . ';dbname=' . $this->ini['dbname'] . ';charset=utf8', $this->ini['dbusr'], $this->ini['dbpass']);
    } catch (PDOException $e) {
        print('DB接続エラー：' . $e->getMessage());
    }
  }

  public function insertEntry($insert){
    if(is_array($insert)){
      $this->count = count($insert);
      // 空欄がなければ登録処理
      if($this->count == 2){
        $this->statment = $this->db->prepare('INSERT INTO bbs_table SET 投稿者=?, 投稿日時=?, 本文=?');
        $this->statment->execute(array(
          $this->name,
          date('Y-m-d H:i:s'),
          $this->text,
        ));
        header('Location: index.php');
        exit;
      }
    }
  }

  public function updataEntry($insert){
    if(is_array($insert)){
      $this->count = count($insert);
      // 空欄がなければ登録処理
      if($this->count == 2){
        $this->updata = $this->db->prepare('UPDATE bbs_table SET 投稿者=?, 本文=? WHERE 投稿ID=?');
        $this->updata->execute(array(
          $this->name,
          $this->text,
          $this->id,
        ));
        
        header('Location: index.php');
        exit;
      }
    }
  }
}
?>