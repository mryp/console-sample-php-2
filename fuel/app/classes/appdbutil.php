<?php
/**
 * アプリ全体で使用するDB関連便利関数
 */
class AppDbUtil
{
	/**
	 * 指定した日付のデータをすべて取得し配列データとして返す（CSV変換用）
	 * @param type $tableName テーブル名
	 * @param type $colmnn 日付列名
	 * @param type $date 日付
	 * @return type データリスト（見つからなかったときはnull）
	 */
	public static function findDateAsArray($tableName, $colmnn, $date)
	{		
		$start = AppDate::getStartDateTime($date);
		$end = AppDate::getEndDateTime($date);
		$result = DB::select()->from($tableName)
			->where($colmnn, 'between', array($start, $end))
			->execute();
		if (count($result) == 0)
		{
			return null;	//データなし
		}

		return $result->as_array();
	}
	
	/**
	 * 指定したカード番号をもつすべてのデータを取得し配列データとして返す
	 * @param type $tableName テーブル名
	 * @param type $colmnn カード番号列名
	 * @param type $idm カード番号
	 * @return type データリスト（見つからなかったときはnull）
	 */
	public static function findIdmAsArray($tableName, $colmnn, $idm)
	{		
		$result = DB::select()->from($tableName)
			->where($colmnn, $idm)
			->execute();
		if (count($result) == 0)
		{
			return null;	//データなし
		}

		return $result->as_array();
	}
	
	/**
	 * すべてのデータを削除する
	 */
	public static function deleteAll($tableName)
	{
		return DB::delete($tableName)->execute();
	}
}
