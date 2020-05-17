<?php

// ページ数のMaxを確認
class Maxpage{
  private $counts;
  private $count;
  private $max_page;
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

  public function maxPage(){
    $this->counts = $this->db->query('SELECT COUNT(*) as cnt FROM bbs_table');
    $this->count = $this->counts->fetch();
    $this->max_page = ceil($this->count['cnt'] / 5);
    return $this->max_page;
  }
}

// ページの誘導
class Induction{
  private $max_page;
  private $page;

  public function __construct($max)
  {
    $this->max_page = $max;
  }
  
  public function pageInduction($request){
    if(isset($request['page']) && is_numeric($request['page'])){
      $this->page = $request['page'];
      $this->page = max($this->page,1);
      $this->page = min($this->page,$this->max_page);
      return $this->page;
    }else{
      $this->page = 1;
      return $this->page;
    }
  }
}

// コンテンツの引き出し
class Contens{
  private $db;
  private $start;
  private $contents;

  public function __construct($page)
  {
    $this->page = $page;
    try {
      $this->ini = parse_ini_file('db.ini', false);
      $this->db = new PDO('mysql:host=' . $this->ini['host'] . ';dbname=' . $this->ini['dbname'] . ';charset=utf8', $this->ini['dbusr'], $this->ini['dbpass']);
    } catch (PDOException $e) {
        print('DB接続エラー：' . $e->getMessage());
    }
  }

  public function pageing(){
    $this->start = ($this->page - 1) * 5;
    $this->contents = $this->db->prepare('SELECT * FROM bbs_table ORDER BY 投稿日時 DESC LIMIT ?,5');
    $this->contents->bindParam(1, $this->start, PDO::PARAM_INT);
    $this->contents->execute();
    return $this->contents;
  }
}
?>