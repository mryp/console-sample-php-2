<?php
/**
 * 全般設定テーブルクラス
 */ 
class Model_Sitesetting extends \Model_Crud
{
	//定数
	//--------------------------------------------------------------------------
	//テーブル定数
	const TABLE_NAME = 'sitesetting';
	const COL_ID = 'id';
	const COL_SERVICE_NAME = 'servicename';
	const COL_FOOTER = 'footer';
	const COL_CREATED_AT = 'created_at';
	const COL_UPDATED_AT = 'updated_at';
			
	//デフォルト値
	const DEF_SERVICE_NAME = "●●●●●コンソール";
	const DEF_FOOTER = "Copyright (C) 2016 PORING SOFT　";
	
	//フィールド
	//--------------------------------------------------------------------------
	//Model_Crud用メンバ変数
	protected static $_table_name = self::TABLE_NAME;
    protected static $_properties = array(
        self::COL_ID,
        self::COL_SERVICE_NAME,
		self::COL_FOOTER,
        self::COL_CREATED_AT,
		self::COL_UPDATED_AT,
    );	
    protected static $_mysql_timestamp = true;
    protected static $_created_at = self::COL_CREATED_AT;
    protected static $_updated_at = self::COL_UPDATED_AT;
	
	//メソッド
	//--------------------------------------------------------------------------
	/**
	 * 設定値を保存する
	 */
	public static function setRecord($serviceName, $footer)
	{
		$data = self::find_all(1);
		if (count($data) == 0)
		{
			DB::insert(self::TABLE_NAME)->set(array(
				self::COL_SERVICE_NAME => $serviceName,
				self::COL_FOOTER => $footer,
				self::COL_CREATED_AT => AppDate::nowTime(),
				self::COL_UPDATED_AT => AppDate::nowTime(),
			))->execute();
		}
		else
		{
			DB::update(self::TABLE_NAME)->set(array(
				self::COL_SERVICE_NAME => $serviceName,
				self::COL_FOOTER => $footer,
				self::COL_UPDATED_AT => AppDate::nowTime(),
			))->execute();
		}

		return 0;
	}
	
	/**
	 * 全般設定値を取得する
	 * @return \SiteSettingItem 設定値（まだ未設定の場合はデフォルト値を設定して返す）
	 */
	public static function getValue()
	{
		$serviceName = self::DEF_SERVICE_NAME;
		$footer = self::DEF_FOOTER;
		
		try
		{
			$data = self::find_all(1);
			if (count($data) > 0)
			{
				$serviceName = $data[0][self::COL_SERVICE_NAME];
				$footer = $data[0][self::COL_FOOTER];
			}
		} catch (Exception $ex) {
			//何もしない
		}

		return new SiteSettingItem($serviceName, $footer);
	}
}