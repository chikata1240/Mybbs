<?php
// 選択した情報をデータベースから取り出し
class Edit {
  private $editid;
  private $edits;
  private $edit;
  private $db;
  private $message;
  private $ini;

  public function __construct($request)
  {
    $this->editid = $request['id'];
    // 例外処理
    try {
      $this->ini = parse_ini_file('db.ini', false);
      $this->db = new PDO('mysql:host=' . $this->ini['host'] . ';dbname=' . $this->ini['dbname'] . ';charset=utf8', $this->ini['dbusr'], $this->ini['dbpass']);
    } catch (PDOException $e) {
        print('DB接続エラー：' . $e->getMessage());
    }
  }

  public function editData(){
    $this->edits = $this->db->prepare('SELECT * FROM bbs_table WHERE 投稿ID=?');
    $this->edits->bindParam(1, $this->editid, PDO::PARAM_INT);
    $this->edits->execute();
    $this->edit = $this->edits->fetch(); 
    $this->message = '>>' . hsc($this->edit['投稿者']) . '　';
    return [$this->edit,$this->message];
  }
}
?>