<?php
/**
 * 接続PINGデータテーブルクラス
 */ 
class Model_Ping extends \Model_Crud
{
	//定数
	//--------------------------------------------------------------------------
	//テーブル定数
	const TABLE_NAME = 'ping';
	const COL_ID = 'id';
	const COL_TERMID = 'termid';
	const COL_CREATED_AT = 'created_at';

	//フィールド
	//--------------------------------------------------------------------------
	//Model_Crud用メンバ変数
	protected static $_table_name = self::TABLE_NAME;
    protected static $_properties = array(
        self::COL_ID,
        self::COL_TERMID,
        self::COL_CREATED_AT,
    );	
    protected static $_mysql_timestamp = true;
    protected static $_created_at = self::COL_CREATED_AT;
    //protected static $_updated_at = '';   //使用しない
    
	//メソッド
	//--------------------------------------------------------------------------
    /**
     * 1件分のデータを追加する
     */
    public static function addRecord($termid)
    {
		DB::insert(self::TABLE_NAME)->set(array(
			self::COL_TERMID => $termid,
			self::COL_CREATED_AT => AppDate::nowTime(),
		))->execute();
		return 0;
    }
	
	/**
	 * 指定した日の最新データを取得する
	 * @param type $date 日付
	 * @param type $limit 最大取得件数
	 * @return type レコードデータリスト（みつからなかったときはnull）
	 */
	public static function findDateLatest($date, $limit=20)
	{
        $dataList = null;
        if (strtotime($date) != 0)
        {
			$start = AppDate::getStartDateTime($date);
			$end = AppDate::getEndDateTime($date);
            $findParam = array(
                'where' => array(
					array(self::COL_CREATED_AT, 'between', array($start, $end)),
				),
				'order_by' => array(
					self::COL_CREATED_AT => 'desc',
				),
				'limit' => $limit,
            );
			
            $dataList = self::find($findParam);   
        }
        
        return $dataList;
	}
	
	/**
	 * 指定したデータの最新の1件を取得する
	 * @param type $date 日付
	 * @param type $termid 端末番号
	 * @return type レコードデータ（見つからなかったときはnull）
	 */
	public static function findOneLatest($date, $termid)
	{
        $dataList = null;
        if (strtotime($date) != 0)
        {
			$start = AppDate::getStartDateTime($date);
			$end = AppDate::getEndDateTime($date);
            $findParam = array(
                'where' => array(
					self::COL_TERMID => $termid,
					array(self::COL_CREATED_AT, 'between', array($start, $end)),
				),
				'order_by' => array(
					self::COL_CREATED_AT => 'desc',
				),
				'limit' => 1,
            );
			
            $dataList = self::find($findParam);
        }
        
		if (count($dataList) > 0)
		{
			return $dataList[0];
		}
		else
		{
			return null;
		}
	}	
	
	/**
	 * 日付に関係なく最後のデータを取得する
	 * @param type $termid
	 * @return type
	 */
	public static function findOneLatestAllDate($termid)
	{
		$findParam = array(
			'where' => array(
				self::COL_TERMID => $termid,
			),
			'order_by' => array(
				self::COL_CREATED_AT => 'desc',
			),
			'limit' => 1,
		);

		$dataList = self::find($findParam);
		if (count($dataList) > 0)
		{
			return $dataList[0];
		}
		else
		{
			return null;
		}
	}	
}