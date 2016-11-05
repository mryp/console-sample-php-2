<?php
/**
 * 公開APIコントローラー
 */
class Controller_Api extends Controller_Rest
{
	//通知処理
	//--------------------------------------------------------------------------
	/**
     * PING通知
     */
    public function post_ping()
    {
        $termid = Input::post("termid", 0);
		if ($termid == 0 || !is_numeric($termid))
		{
			return $this->response(array('status' => -1)); 
		}		
				
		//通知を保存
        $result = Model_Ping::addRecord($termid);
        return $this->response(array('status' => $result)); 
    }
    
    /**
     * 疎通確認チェック
     * @return type
     */
    public function post_echo()
    {
        $message = Input::post("message", "");
		
        //そのまま何もせずに返す
        return $this->response(array('message' => $message)); 
    }
	
	//デバッグ用
	//--------------------------------------------------------------------------
	/**
	 * データの削除
	 * @return type
	 */
	public function post_dataclear()
	{
        $password = Input::post("password", '');
		if ($password != AppDefine::DATA_CLEAR_PASSWORD)
		{
			return $this->response(array('status' => -1)); 
		}
		
		AppDbUtil::deleteAll(Model_Ping::TABLE_NAME);

        return $this->response(array('status' => 0)); 
	}
}
