<?php
// 選択した情報を削除
class Delete {
  private $delete;
  private $db;
  private $ini;

  public function __construct()
  {
    // 例外処理
    try {
      $this->ini = parse_ini_file('db.ini', false);
      $this->db = new PDO('mysql:host=' . $this->ini['host'] . ';dbname=' . $this->ini['dbname'] . ';charset=utf8', $this->ini['dbusr'], $this->ini['dbpass']);
    } catch (PDOException $e) {
        print('DB接続エラー：' . $e->getMessage());
    }
  }

  public function delete($request){
    $this->delete = $this->db->prepare('DELETE FROM bbs_table WHERE 投稿ID=?');
    $this->delete->bindParam(1, $request['id'], PDO::PARAM_INT);
    $this->delete->execute();

    header('Location:index.php');
  }
}
?>