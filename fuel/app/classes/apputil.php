<?php
/**
 * アプリ全体で使用する便利関数
 */
class AppUtil
{
    /**
     * SJISファイルをUTF8に変換してファイルをオープンする
     * 使用後は fclose() でクローズすること
     */
    public static function fopenConvertUtf8($csvFilePath)
    {
        $buffer = mb_convert_encoding(file_get_contents($csvFilePath), "UTF-8", "sjis-win");
        $fp = tmpfile();
        fwrite($fp, $buffer);
        rewind($fp);
        
        return $fp;
    }
		
	/**
	 * 指定した文字列データをファイルとしてZIP圧縮する
	 * @param type $data 文字列データ
	 * @param type $filename ファイル名
	 * @param type $password パスワード（使用しない場合は空文字）
	 * @return string 作成したZIPファイル名（失敗した場合は空文字）を返す
	 */
	public static function createZipFile($data, $filename, $password)
	{
		$basedir = APPPATH . 'tmp';
		$createFilePath = $basedir . '/' . $filename;
		if (file_exists($createFilePath))
		{
			File::delete($createFilePath);
		}
		if (is_array($data))
		{
			File::create($basedir, $filename, "");
			foreach ($data as $item)
			{
				File::append($basedir, $filename, $item);
			}
		}
		else
		{
			File::create($basedir, $filename, $data);
		}
		
		//ZIPファイル作成
		$fileList[] = $filename;
		$zipFilePath = self::createZipFileFromFileList($fileList, $password);
		
		//後始末
		File::delete($createFilePath);	//作成したファイルを削除
		
		return $zipFilePath;
	}
	
	/**
	 * 指定したファイル一覧をZIPファイルに格納する
	 * フォルダ構成はすべて無視する
	 * @param type $fileList
	 * @param type $password
	 * @return string
	 */
	public static function createZipFileFromFileList($fileList, $password)
	{
		$basedir = APPPATH . 'tmp';
		$zipfile = $basedir.'/'.Str::random('unique').'.zip';
		if (file_exists($zipfile))
		{
			File::delete($zipfile);
		}
		
		$passcmd = "";
		if ($password != null && $password != "")
		{
			$passcmd = " -P $password";
		}
		$zipcmd = "cd $basedir; zip -j $passcmd $zipfile ";
		foreach ($fileList as $file)
		{
			$zipcmd .= $file . ' ';
		}
				
		$return_var = 0;
		$output = false;
		exec($zipcmd, $output, $return_var);
		if ($return_var !== 0)
		{
			return "";
		}
		
		return $zipfile;	
	}
	
	/**
	 * 指定したオブジェクトをダンプして保存する
	 * @param type $fileName 保存ファイル名
	 * @param type $obj オブジェクトデータ
	 */
	public static function dumpObjectData($fileName, $obj)
	{
		$debugDumpDir = APPPATH.'logs/';
		if (File::exists($debugDumpDir . $fileName))
		{
			File::delete($debugDumpDir . $fileName);
		}
		File::create($debugDumpDir, $fileName, self::createVarDumpString($obj));
	}
	
	/**
	 * var_dumpの内容を文字列として返す
	 * @param type $variable
	 * @return type
	 */
	public static function createVarDumpString($variable)
	{
		$dump_object = '';
		ob_start();
		{
			var_dump( $variable );
			$dump_object = ob_get_contents();
		}
		ob_end_clean();
		return mb_convert_encoding($dump_object, 'UTF-8');
	}
	
	/**
	 * createFromCsvFileメソッドを持つクラス似た指定アップロードされたCSVファイルの登録を行う
	 * @param type $className createFromCsvFileクラスメソッドを持つクラス名
	 * @param type $tempDirName アップロードされたCSVを保存するフォルダ名
	 * @return array success_message または  error_message を持つ配列データ（どちらも持たない場合はファイルがポストされていない）
	 */
	public static function uploadSettingCsv($className, $tempDirName, $option=null)
	{
		$result = array();
		if (Input::post())
		{ 
			Upload::process(array(
				'path' => APPPATH . 'tmp/' . $tempDirName,
   				'randomize' => true,
    			'ext_whitelist' => array('csv', 'txt'),
			));
			
			if (Upload::is_valid())
			{
				Upload::save();
				$file = Upload::get_files(0);
		
				if (isset($file['error']) && $file['error'] == false)
				{
					$filePath = $file['saved_to'] . $file['saved_as'];
					if ($option != null)
					{
						$count = $className::createFromCsvFile($filePath, $option);
					}
					else
					{
						$count = $className::createFromCsvFile($filePath);
					}
					if ($count > 0)
					{
						$result['success_message'] = $count . " 件のデータを登録しました";
					}
					else
					{
						$result['error_message'] = "登録可能なデータが見つかりませんでした。<br />書式が間違っていないか確認してください。";
					}
				}
				else
				{
					$result['error_message'] = "ファイルの保存に失敗しました";
				}
			}
			else
			{
				$result['error_message'] = "ファイルのアップロードに失敗しました";
			}
		}
			
		return $result;
	}
}
