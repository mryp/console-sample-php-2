<?php
/**
 * コンソール画面コントローラー
 */
class Controller_Console extends Controller_Template
{
	//フィールド
	//--------------------------------------------------------------------------
	public $template = 'template';
	
	//前処理
	//--------------------------------------------------------------------------
	/**
	 * 起動前処理
	 */
	public function before()
	{
		$this->template = 'template_cl';
		parent::before();
		
		$method = Uri::segment(2);
		if ($method != "login" && !Auth::check())
		{
			//まだログインしていない
			Response::redirect('console/login');
		}
	}
	
	//ログイン処理
	//--------------------------------------------------------------------------
	/**
	 * ログイン
	 */
	public function action_login()
	{
		$data = array();
		if (Input::post())
		{
			if (Auth::login(Input::post('username'), Input::post('password')))
			{
				Response::redirect('console/index');
				return;
			}
			else
			{
				$data['username'] = Input::post('username');
				$data['error_message'] = 'ユーザー名またはパスワードが異なります';
			}
		}
		
		$this->template = View::forge('template_login');
		$this->template->content = View::forge('console/login', $data);
	}
	
	/**
	 * ログアウト
	 */ 
	public function action_logout()
	{
       	Auth::logout();
		Response::redirect('console/login');
	}
	
	/**
	 * ユーザー設定
	 */
	public function action_profile()
	{
		$data = array();
		if (Input::post())
		{
			$data['username'] = Auth::get('username');
			$data['email'] = Input::post('email', '');
			$data['groupname'] = Auth::group('Simplegroup')->get_name(Auth::get('group'));
			if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
			{
				$data['error_message'] = "メールアドレスのフォーマットが不正です";
			}
				
			if (!isset($data['error_message']))
			{
				if (Auth::update_user(
					array('email' => $data['email'])
				))
				{
					$data['success_message'] = "更新処理が正常に完了しました";
				}
			}
		}
		else
		{
			$data['username'] = Auth::get('username');
			$data['email'] = Auth::get('email');
			$data['groupname'] = Auth::group('Simplegroup')->get_name(Auth::get('group'));
		}
		
		$this->template->content = View::forge('console/profile', $data);
		$this->template->set('title', 'ユーザー設定');
		$this->template->content->set('title', 'ユーザー設定');
	}
	
	//端末状況
	//--------------------------------------------------------------------------
	public function action_index()
	{
		$data['title'] = "通信履歴一覧";
		$data['target_date'] = Input::post("target_date", AppDate::nowDate());
		$data['show_limit'] = Input::post("show_limit", 25);
		$data['ping_item_list'] = Model_Ping::findDateLatest($data['target_date'], $data['show_limit']);
		
		$this->template->content = View::forge('console/index', $data);
		$this->template->set('title', $data['title']);
	}
		
	//サーバー設定
	//--------------------------------------------------------------------------
	public function action_optionsite()
	{
		$data['title'] = "全般設定";
		$setting = Model_Sitesetting::getValue();
		$data['service_name'] = Input::post("service_name", $setting->getServiceName());
		$data['footer_text'] = Input::post("footer_text", $setting->getFooter());
		
		if (Input::post())
		{
			if ($data['service_name'] == '' || $data['footer_text'] == '')
			{
				$data['error_message'] = "未入力の項目があります";
			}
			else
			{
				$result = Model_Sitesetting::setRecord($data['service_name'], $data['footer_text']);
				if ($result == 0)
				{
					$data['success_message'] = "データを登録しました";
				}
				else
				{
					$data['error_message'] = "データの登録に失敗しました";
				}
			}
		}
		
		$this->template->content = View::forge('console/optionsite', $data);
		$this->template->set('title', $data['title']);
		if (isset($data['error_message']))
		{		
			$this->template->content->set_safe('error_message', $data['error_message']);
		}
	}
    
	//ユーザー設定
	//--------------------------------------------------------------------------
	/**
	 * ユーザー一覧
	 */
	public function action_userlist()
	{
		$data['title'] = "ユーザー一覧";
		if (Input::post())
		{
			$deleteIdList = Input::post("delete");
			if (count($deleteIdList) > 0)
			{
				foreach (array_keys($deleteIdList) as $id)
				{
					$user = Model_Users::find_one_by('id', $id);
					if ($user != null)
					{
						Auth::delete_user($user['username']);
						break;
					}
				}
			}
		}
		
		$this->template->content = View::forge('console/userlist', $data);
		$this->template->set('title', $data['title']);
	}
	
	/**
	 * ユーザー追加
	 */
	public function action_useradd()
	{
		$data = array();
		$data['title'] = "ユーザー追加";
		$data['username'] = Input::post("username", '');
		$data['email'] = Input::post("email", '');
		$data['groupid'] = Input::post("groupid", '');
		$data['password'] = Input::post("password", '');
		$data['passwordcnf'] = Input::post("passwordcnf", '');
		if (Input::post())
		{
			$val = Validation::forge();
			$val->add('username', 'ユーザー名')
				->add_rule('required')
				->add_rule('min_length', 3)
				->add_rule('valid_string', array('alpha', 'numeric', 'dashes'));
			$val->add('email', 'メールアドレス')
				->add_rule('required')
				->add_rule('valid_email');
			$val->add('groupid', '権限グループ')
				->add_rule('required');
			$val->add('password', 'パスワード')
				->add_rule('required')
				->add_rule('min_length', 6)
				->add_rule('max_length', 20);				
			
			if ($data['password'] != $data['passwordcnf'])
			{
				$data['error_message'] = "パスワードと確認用パスワードが一致しません";
			}
			else
			{
				if ($val->run())
				{
					try
					{
						if (Auth::create_user($val->validated('username')
						, $val->validated('password')
						, $val->validated('email')
						, $val->validated('groupid')))
						{
							$data['username'] = '';
							$data['email'] = '';
							$data['groupid'] = '';
							$data['password'] = '';
							$data['passwordcnf'] = '';
							$data['success_message'] = $val->validated('username') . "を追加しました";
						}
						else
						{
							$data['error_message'] = "ユーザーの追加に失敗しました";
						}
					}
					catch (Exception $e) 
					{
						$data['error_message'] = "ユーザーの追加に失敗しました<br />" . $e->getMessage();
					}
				}
				else 
				{
					$data['error_message'] = $val->show_errors();
				}
			}
		}
		
		$this->template->content = View::forge('console/useradd', $data);
		$this->template->set('title', $data['title']);
		if (isset($data['error_message']))
		{		
			$this->template->content->set_safe('error_message', $data['error_message']);
		}
	}
	
	/**
	 * ユーザー一括追加
	 */ 
	public function action_usercsv()
	{
		$data['title'] = "ユーザー一括追加";
		if (Input::post())
		{ 
			Upload::process(array(
				'path' => APPPATH . 'tmp/csvuser',
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
					$count = Model_Users::createUserFromCsvFile($filePath);
					if ($count > 0)
					{
						$data['success_message'] = $count . " 件のデータを登録しました";
					}
					else
					{
						$data['error_message'] = "登録可能なデータが見つかりませんでした。<br />書式が間違っているか、すべて登録済みの可能性があります。";
					}
				}
				else
				{
					$data['error_message'] = "ファイルの保存に失敗しました";
				}
			}
			else
			{
				$data['error_message'] = "ファイルのアップロードに失敗しました";
			}
		}
		
		$this->template->content = View::forge('console/usercsv', $data);
		$this->template->set('title', $data['title']);
		if (isset($data['error_message']))
		{		
			$this->template->content->set_safe('error_message', $data['error_message']);
		}
	}
	
	//デバッグ
	//--------------------------------------------------------------------------
	/**
	 * REST API
	 */
	public function action_debugrestapi()
	{
		$data['title'] = "REST API";
		
		$this->template->content = View::forge('console/debugrestapi', $data);
		$this->template->set('title', $data['title']);
	}
	
}
