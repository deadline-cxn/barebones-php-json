<?php
/***
 * DB
 * A simple json db class
 */
class DB
{
  private $path = '';
  private $db = [];

  /**
   * CONSTRUCTOR
   * 
   * @param $path: string (default 'db.json')
   */
  public function __construct($path = "db.json"){
    
    $this->path = $path;

    if(!file_exists($path)){
      // If the .json extension is not provided, append it
      if(strpos($path, '.json') === false){ $path .= '.json'; }

      $fp = fopen($path,"wb");
      fwrite($fp, "{}");
      fclose($fp);
    }

    // Get the contect of the current path
    $this->db = json_decode(file_get_contents($path), true);

    
  }

  /**
   * SAVE
   * Save the new db
   */
  private function save(){
    $json = ($this->db === "{}") ? $this->db : json_encode($this->db);
    echo "$this->path<br>";
    file_put_contents($this->path, $json);
  }

  /**
   * INSERT
   * 
   * @param $data: array
   * @param $key: string (optional)
   * 
   * @return DB
   */
  public function insert($data, $key = ""){
    if($key !== "")
      $this->db[$key] = $data;
    else
      $this->db[] = $data;

    $this->save();
    
    return $this;
  }
  
  /**
   * UPDATE
   * 
   * @param $data: array
   * @param $key: string
   * 
   * @return DB
   */
  public function update($data, $key){
    if($key !== "")
      $update = array_merge($this->db[$key], $data);
      $this->db[$key] = $update;

    $this->save();

    return $this;
  }

  /**
   * DELETE
   * 
   * @param $key: string
   * 
   * @return DB
   */
  public function delete($key){
    unset($this->db[$key]);

    $this->save();

    return $this;
  }

  /**
   * GET SINGLE
   * 
   * @param $key: string
   * 
   * @return array
   */
  public function getSingle($key) {
    if(!empty($this->db[$key]))
      return $this->db[$key];
    else {
      $data=Array();
      $data["name"]="null";
      return $data;
    }
  }

  /**
   * GET LIST
   * 
   * @param $conditions: array (optional)
   * @param $orderBy: array (optional)
   * 
   * @return array
   */
  public function getList($conditions = [], $orderBy = []){
    $result = [];

    if(empty($conditions)){
      $result = $this->db;
    }else{
      foreach($this->db as $key => $value){
        $requirements = true;

        foreach($conditions as $k => $v){
          if($value[$k] !== $v){
            $requirements = false;
          }
        }

        if($requirements) $result[$key] = $value;
      }
    }

    if(!isset($orderBy["on"])) $orderBy["on"]="";
    if(!isset($orderBy["order"])) $orderBy["order"]="";

    if($orderBy['on'] !== '' && $orderBy['order'] !== ''){
      usort($result, function($first, $second) use($orderBy){
        if($orderBy['order'] === "ASC"){
          return strcmp($first[$orderBy['on']], $second[$orderBy['on']]) > 0;
        }else{
          return strcmp($first[$orderBy['on']], $second[$orderBy['on']]) < 0;
        }
      });
    }

    return $result;
  }

  /**
   * CLEAR
   * 
   * @return DB
   */
  public function clear(){
    $this->db = "{}";

    $this->save();

    return $this;
  }
}
?>