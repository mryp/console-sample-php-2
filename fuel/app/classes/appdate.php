<?php
/**
 * アプリ全体で使用する日付関連ユーティリティ
 */
class AppDate
{
	/**
	 * 現在の日付を取得する（YYYY-MM-DD）
	 * @return String 日付文字列
	 */
	public static function nowDate()
	{
		if (Fuel::$env == Fuel::DEVELOPMENT && isset($_SERVER['DEVELOP_NOWDATE']))
		{
			return $_SERVER['DEVELOP_NOWDATE'];
		}
		else
		{
			return date('Y-m-d');
		}
	}
	
	/**
	 * 現在の日時を取得する（YYYY-MM-DD HH:MM:SS）
	 * @return String 日時文字列
	 */
	public static function nowTime()
	{
		if (Fuel::$env == Fuel::DEVELOPMENT && isset($_SERVER['DEVELOP_NOWDATE']))
		{
			return $_SERVER['DEVELOP_NOWDATE'] . ' ' . date("H:i:s");
		}
		else
		{
			return date('Y-m-d H:i:s');
		}
	}
	
	/**
	 * 指定した日時の日付を取得する
	 * @param String $time 時間文字列
	 * @return String YYYY-MM-DD
	 */
	public static function getDate($time)
	{
		return date('Y-m-d', strtotime($time));
	}
	
	/**
	 * 指定した日付開始日時を取得する
	 * @param String $time 時間文字列
	 * @return String YYYY-MM-DD 0:00:00
	 */
	public static function getStartDateTime($time)
	{
		return date('Y-m-d', strtotime($time)) . ' 0:00:00';
	}
	
	/**
	 * 指定した日付終了日時を取得する
	 * @param String $time 時間文字列
	 * @return String YYYY-MM-DD 23:59:59
	 */
	public static function getEndDateTime($time)
	{
		return date('Y-m-d', strtotime($time)) . ' 23:59:59';
	}
	
	/**
	 * 指定した日付の開始月日を取得する
	 * @param String $date 日付文字列
	 * @return String YYYY-MM-DD
	 */
	public static function getStartMonth($date)
	{
		return date("Y-m-01", strtotime($date));
	}
	
	/**
	 * 指定した日付の終了月日を取得する
	 * @param String $date 日付文字列
	 * @return String YYYY-MM-DD
	 */
	public static function getEndMonth($date)
	{
		return date("Y-m-t", strtotime($date));
	}
	
	/**
	 * 指定した日付から指定した月分前の日付を取得する
	 * @param type $targetDate
	 * @param type $agoMonth
	 * @return type
	 */
	public static function getMonthAgoDate($targetDate, $agoMonth)
	{
		return date("Y-m-d", strtotime("-" . $agoMonth . " month", strtotime($targetDate)));
	}
	
	/**
	 * 指定した日の次の日を取得する
	 * @param type $targetDate
	 * @return type
	 */
	public static function getDateTomorrow($targetDate)
	{
		return date("Y-m-d", strtotime("+1 day", strtotime($targetDate)));
	}
	
	/**
	 * 指定した日時からの分前の日時を取得する
	 * @param type $targetDateTime 対象日時
	 * @param type $agoMinute 分
	 * @return type 
	 */
	public static function getMinuteAgoDateTime($targetDateTime, $agoMinute)
	{
		return date("Y-m-d H:i:s", strtotime("-" . $agoMinute . " minute", strtotime($targetDateTime)));
	}
	
	/**
	 * 指定したレコードの日付を除いた作成時刻を取得する
	 * @param type $record created_atを含むレコードオブジェクト
	 * @return string 時間文字列（HH:MM:SS）
	 */
	public static function getCreateTimeFromRecord($record)
	{
		if ($record == null || !isset($record['created_at']))
		{
			return "";
		}
		
		return date('H:i:s', strtotime($record['created_at']));
	}
	
	/**
	 * 開始日から終了日までの日付データ一覧を作成して返す
	 * @param type $start 開始日
	 * @param type $end 終了日
	 * @return type 日付文字列配列
	 */
	public static function getDateList($start, $end)
	{
		$startDate = self::getDate($start);
		$endDate = self::getDate($end);
		$dayList = array();
		for ($date = $startDate; ;$date = self::getDateTomorrow($date))
		{
			$dayList[] = $date;
			if ($date == $endDate)
			{
				break;
			}
		}

		return $dayList;
	}
}
