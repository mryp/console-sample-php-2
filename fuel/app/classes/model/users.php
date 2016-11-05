<?php
/**
 * Simpleauthユーザー情報取得クラス（操作は\Authクラスを使用する）
 */ 
class Model_Users extends \Model_Crud
{
    protected static $_table_name = 'users';
    
    /**
     * CSVファイルからユーザーを追加する
     * @return 成功件数を返す
     */
    public static function createUserFromCsvFile($csvFilePath)
    {
        $successCount = 0;
        $fp = AppUtil::fopenConvertUtf8($csvFilePath);
        while (($line = fgetcsv($fp, 1000, ",")) !== false) 
        {
            if (count($line) < 4)
            {
                continue;
            }
            $name = $line[0];
            $email = $line[1];
            $groupid = $line[2];
            $password = $line[3];
            
            try
            {
                if (!self::validateCreateUser($name, $email, $groupid, $password))
                {
                    continue;
                }
                if (Auth::create_user($name, $password, $email, $groupid))
                {
                    $successCount++;
                }
                else
                {
                    Log::warning("error create_user", 'Model_Crud#createUserFromCsvFile');
                }
            }
            catch (Exception $e) 
            {
                Log::warning($e->getMessage(), 'Model_Crud#createUserFromCsvFile');
            }
        }
        fclose($fp);
                
        return $successCount;
    }
    
    /**
     * ユーザー作成用パラメーター検証
     */
    private static function validateCreateUser($name, $email, $groupid, $password)
    {
        $configGroupList = Config::get('simpleauth.groups');
        if (strlen($name) < 3)
        {
            return false;
        }
        if (!preg_match("/^[-_a-zA-Z0-9]+$/", $name))    //アルファベット、数字、ハイフン、アンダーバー以外
        {
            return false;    
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
        if (!isset($configGroupList[$groupid]))
        {
            return false;
        }
        if (strlen($password) < 6 || strlen($password) > 20)
        {
            return false;
        }
        
        return true;
    }
}
