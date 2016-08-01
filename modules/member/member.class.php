<?php
/**
 */

/**
 * ��Ա��
 *
 * @author TissotCai
 */
require_once ROOT_PATH . '/modules/jianzhi/jianzhi.class.php';
require_once ROOT_PATH . '/modules/huodong/huodong.class.php';
require_once ROOT_PATH . '/modules/peixun/peixun.class.php';
require_once ROOT_PATH . '/modules/favorites/favorites.class.php';
class Member {

    const LOGIN_ERROR_USER_PWD = '�û������������';
    const LOGIN_ERROR_UCENTER = 'ucenterͬ����¼ʧ��';
	const LOGIN_STEP_EMAIL = '���伤���';
	const LOGIN_STEP_INFO  = '��Ϣ���Ʋ���';
	const LOGIN_STEP_AVATAR = 'ͷ���ϴ�����';
    
    const ADDMEMBER_ERROR_REAL_NAME = '������Ч';
	const ADDMEMBER_ERROR_USER_EXISTS = '��Ա���ظ�';
	const ADDMEMBER_ERROR_MAIL_EXISTS = '�����ظ�';

    const PERFECTUSER_ERROR_UPDATE_USER = '�û���Ϣ����ʧ��';
    const PERFECTUSER_ERROR_UPDATE_RESUME = '������Ϣ����ʧ��';

	const UPDATEMEMBER_MAIL_EXISTS = '�����ظ�';
	const UPDATEMEMBER_ERROR_USER = '��Ա��Ϣ����ʧ��';
	const UPDATEMEMBER_ERROR_REAL_NAME = '������Ч';
	
	const ADDFAVORITES_MODULE_NULL = '����ģ�鲻��Ϊ��';
	const ADDFAVORITES_NAME_NULL = '���ⲻ��Ϊ��';
	const ADDFAVORITES_URL_NULL = '���ӵ�ַ����Ϊ��';
	const ADDFAVORITES_NOT_EXISTS_USER = '�û�������';
	const ADDFAVORITES_NOT_EXISTS_MODULE = 'ģ�鲻����';
	
    const ACTIVE_KEY = 1281226088;
    
    /**
     * �û�ע��
	 * @param $param array
	 *		array(
	 *			'username'=>'��Ա��',
	 *			'password'=>'����',
	 *			'email'=>'����',
	 *			'gender'=>'�Ա�'
	 *		)
	 * @return String
	 *		Member::ADDMEMBER_ERROR_USER_EXISTS ��Ա���ظ�<br>
	 *		Member::ADDMEMBER_ERROR_MAIL_EXISTS �����ظ�<br>
	 *		Member::ADDMEMBER_ERROR_REAL_NAME ������Ч<br>
	 *		true �ɹ�
     */
    public static function AddMember ($param) {
        global $_G, $mysql;
        
        $data['username'] = trim($param['username']);
        $data['password'] = trim($param['password']);
        $data['email']    = trim($param['email']);
		$data['sex']      = trim($param['gender']);
		$data['realname']      = trim($param['realname']);
		# ����û���������
		if ($mysql->db_fetch_array("select 1 from {user} where username='{$data['username']}'")) {
			return self::ADDMEMBER_ERROR_USER_EXISTS;
		}
		if ($mysql->db_fetch_array("select 1 from {user} where email='{$data['email']}'")) {
			return self::ADDMEMBER_ERROR_MAIL_EXISTS;
		}
		
        $data['type_id'] = 2;
        $data['status'] = 0;
        if (isset($data['realname'])) {
            if (strlen($data['realname']) > 8 and strlen($data['realname']) <2) {
                return self::ADDMEMBER_ERROR_REAL_NAME;
            }
        }

        if (1 != $_G['system']['con_member_reg_mail']) {
            $data['status'] = 1;
        }

        $user_id = 0;
        $user = new User();
        $result = true === $user->add($data, $user_id)?true:false;
		
        return $user_id;
    }

	 /**
     * �û���¼
	 * @param $param array
	 *		array(
	 *			'key_value'=>'ֵ',
	 *			'password'=>'����',
	 *			'login_type'=>'��֤����(username/email)'
	 *		)
	 * @return
	 *		Member::LOGIN_ERROR_USER_PWD �û������������<br>
	 *		Member::LOGIN_ERROR_UCENTER ucenterͬ����¼ʧ��<br>
	 *		Member::LOGIN_STEP_EMAIL ���伤���<br>
	 *		Member::LOGIN_STEP_INFO ��Ϣ���Ʋ���<br>
	 *		Member::LOGIN_STEP_AVATAR ͷ���ϴ�����<br>
	 *		�ɹ�����array(��Ա��Ϣ)
     */
     public static function Login ($param) {
        global $mysql, $user;

		$user_name = $param['key_value'];
		if ('username' != $param['login_type']) {
			$row = $mysql->db_fetch_array("select username from {user} where {$param['login_type']}='{$param['key_value']}'");
			if (!$row) {
				return self::LOGIN_ERROR_USER_PWD;
			}
			$user_name = $row['username'];
		}
		
        $user_info = $user->login($user_name, $param['password']);
        if (!$user_info) {
            return self::LOGIN_ERROR_USER_PWD;
        }else{
			$_SESSION['username'] = $user_info['username'];
			$_SESSION['user_id'] = $user_info['user_id'];
			$_SESSION['usertype'] = 0;
			$_SESSION['usertime'] = time();
		}
        if (1 != $user_info['status']) {
			return self::LOGIN_STEP_EMAIL;
        }
        if (!$user_info['litpic']) {
			return self::LOGIN_STEP_AVATAR;
        }
        if ($user->is_uc) {
            $u_id = (int)UcenterClient::login($user_name, $param['password']);
            if ($u_id <= 0) {
                return self::LOGIN_ERROR_UCENTER;
            }
        }
		# ��ȡVIP��Ϣ
		$vip = VipUser::GetVIPUserInfo($user_info['user_id']);
		$user_info['vip_info'] = $vip;
		
        return $user_info;
    }

	/**
	 * �û��˳�
	 * @return bool true
	 */
	public static function LogOut () {
		global $user;
		
		if ($user->is_uc) {
			UcenterClient::LogOut();
		}
		if (isset($_SESSION['username'])) unset($_SESSION['username']);
		if (isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
		if (isset($_SESSION['userid'])) unset($_SESSION['userid']);
		if (isset($_SESSION['usertype'])) unset($_SESSION['usertype']);
		if (isset($_SESSION['usertime'])) unset($_SESSION['usertime']);

		return true;
	}

    /**
     * �������ʼ�
	 * @param $param
	 *		array(
	 *			'user_id'=>'��ԱID',
	 *			'email'=>'����',
	 *			'msg'=>'��Ϣ����'
	 *		)
	 * @return bool true/false
     */
    public static function SendActiveMail ($param) {
        require_once ROOT_PATH . 'plugins/mail/mail.php';
        global $mysql;

		$user_id = $param['user_id'];
		$email = $param['email'];
		$msg   = isset($param['msg'])?$param['msg']:'';
        $user_info = $mysql->db_fetch_array("select * from {user} where user_id={$user_id}");
        if (!$user_info) {
            return false;
        }
        if (!$email) {
            $email = $user_info['email'];
        }
        $result = Mail::Send("�˺�ע��ȷ��",$msg, array(array($email,'')));
		
        if ($result && $email != $user_info['email']) {
            $mysql->db_query("update {user} set email='{$email}' where user_id={$user_id}");
        }

        return true;
    }

   

    /**
     * ���ƻ�Ա����
     * @param $param ��������
	 *		array(
	 *			'user_id'=>'��ԱID'
	 *			'birthday'=>'����',
	 *			'province'=>'ʡ��',
	 *			'city'=>'����',
	 *			'area'=>'��',
	 *			'school'=>'ѧУ',
	 *			'professional'=>'רҵ',
	 *			'school_area'=>'У��'
	 *		)
	 * @return bool
     */
    public static function PerfectUserInfo ($param) {
        global $module;

		$data['birthday'] = $param['birthday'];
		$data['province'] = $param['province'];
		$data['city']     = $param['city'];
		$data['area']     = $param['area'];
		$data['school']   = $param['school'];
		$data['professional'] = $param['professional'];
		$data['school_area']  = $param['school_area'];
		
		$user_id = $param['user_id'];
		
        # �û���Ϣ
        $user_key = array(
          'birthday',
          'province',
          'city',
          'area',
        );
        # ������Ϣ
        $resume_key = array(
          'school',
          'professional',
          'school_area'
        );
        $user_info = array();
        $resume_info = array();
        foreach ($data as $key => $value) {
            if (in_array($key, $user_key)) {
                $user_info[$key] = $value;
            }
            elseif(in_array($key, $resume_key)) {
                $resume_info[$key] = $value;
            }
        }

        if ($user_info) {
            $user = new User();
			
            if (-1 === $user->update($user_info, $user_id)) {
               return self::PERFECTUSER_ERROR_UPDATE_USER;
            }
        }

        # ���¼�����Ϣ
        if ($resume_info) {
            if ($module->get_module('schoolresume')) {
                require_once ROOT_PATH . 'modules/schoolresume/schoolresume.class.php';
                if(!SchoolResume::Update($user_id, $resume_info)){
                    return self::PERFECTUSER_ERROR_UPDATE_RESUME;
                }
            }
        }

        return true;
    }

	/**
	 * �ϴ�ͷ��
	 * @param $user_id ��ԱID
	 * @param $avatar ͷ�������
	 * @param $width ͷ����
	 * @param $height ͷ��߶�
	 */
	/**
	 * @param $param
	 *		array(
	 *			'user_id'=>'��Ա��',
	 *			'avatar'=>'ͷ�������',
	 *			'width'=>'ͷ����[option]',
	 *			'height'=>'ͷ��߶�[option]'
	 *		)
	 * @return bool true/false
	 */
	public static function UploadAvatar ($param) {
		global $mysql, $upload, $user;

		$user_id = $param['user_id'];
		$avatar = $param['avatar'];
		$width  = isset($param['width'])?$param['width']:100;
		$height = isset($param['height'])?$param['height']:100;
		
		$upload->setUploadPic($width, $height);
        $pic = $upload->uploadImg($avatar);
		$data = array();

		if ($pic) {
			$data['litpic'] = $pic;
		}
        
        if ($data['litpic']) {
            $mysql->db_update('user', $data, "user_id={$user_id}");
        }

		if ($user->is_uc && $user_id > 0) {
			$u = $mysql->db_fetch_array("select username, password from {user} where user_id={$user_id}");
			if ($u) {
				UcenterClient::login($u['username'], $u['password']);
			}
		}
		
		return true;
	}

	/**
	 * ��ȡ�û���Ϣ
	 * @param $user_id ��ԱID
	 * @return array ��Ա��Ϣ
	 */
	public static function ViewMember ($user_id) {
		global $mysql;
		
		$row = $mysql->db_fetch_array("select * from {user} where user_id={$user_id}");
		
		return $row;
	}

	/**
	 * ��ȡ��Ա����
	 * @param $user_id ��ԱID
	 * @return array ������Ϣ
	 */
	public static function ViewMemberResume ($user_id) {
		global $mysql, $module;

		$row = array();
		if ($module->get_module('schoolresume')) {
			$row = $mysql->db_fetch_array("select * from {school_resume} where user_id = {$user_id}");
		}

		return $row;
	}

	/**
	 * ���»�Ա��Ϣ
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			...��Ա��Ϣ
	 *		)
	 * @return
	 *		Member::UPDATEMEMBER_MAIL_EXISTS �����ظ�<br>
	 *		Member::UPDATEMEMBER_ERROR_REAL_NAME ������Ч<br>
	 *		Member::UPDATEMEMBER_ERROR_USER ��Ա��Ϣ����ʧ��<br>
	 *		true �ɹ�
	 */
	public static function UpdateMemberInfo ($param) {
		global $mysql;

		$user_id = $param['user_id'];
		$data = $param;
		$can_not_update = array(
			'user_id',
			'username',
			'addtime',
			'addip'
		);
		$temp = $data;
		foreach ($temp as $key => $value) {
			if (in_array($key, $can_not_update)) {
				unset($data[$key]);
			}
		}

		if (isset($data['email'])) {
			$row = $mysql->db_fetch_array("select user_id from {user}
											where email='{$data['email']}'");
			if ($row) {
				if ($row['user_id'] == $user_id) {
					unset($data['email']);
				}
				else {
					return self::UPDATEMEMBER_MAIL_EXISTS;
				}
			}
		}
		if (isset($data['realname'])) {
			if (strlen($data['realname']) > 8) {
				return self::UPDATEMEMBER_ERROR_REAL_NAME;
			}
		}

		if (!empty($data)) {
			$user = new User();
			if (-1 === $user->update($data, $user_id)) {
				return self::UPDATEMEMBER_ERROR_USER;
			}
		}

		return true;
	}

	/**
	 * ��ӻ�Ա����
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			... ������Ϣ
	 *		)
	 * @return bool true/false
	 */
	public static function AddMemberResume ($param) {
		require_once ROOT_PATH . 'modules/schoolresume/schoolresume.class.php';

		$user_id = $param['user_id'];
		$data = $param;
		if(!SchoolResume::Update($user_id, $data)){
			return false;
		}

		return true;
	}

	/**
	 * ���»�Ա����
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			... ������Ϣ
	 *		)
	 * @return bool true/false
	 */
	public static function UpdateMemberResume ($param) {
		require_once ROOT_PATH . 'modules/schoolresume/schoolresume.class.php';

		$user_id = $param['user_id'];
		$data = $param;
		unset($data['user_id']);
		if(!SchoolResume::Update($user_id, $data)){
			return false;
		}

		return true;
	}

	/**
	 * ��ְ����
	 * @param $param
	 *		array(
	 *			'job_id' => '��λID',
	 *			'user_id' => '��ԱID'
	 *		)
	 * @return
	 *		PartTime::APPLY_REAPPLY �ظ�����<br>
	 *		PartTime::APPLY_HAVE_APPLY �ѱ���������λ<br>
	 *		PartTime::APPLY_ON_WORK ��ְ��Ա<br>
	 *		PartTime::APPLY_NO_VIP ��VIP��Ա<br>
	 *		PartTime::APPLY_VIP_NOACTIVE VIP�Ǽ���״̬<br>
	 *		PartTime::APPLY_NO_JOB ��λ������<br>
	 *		PartTime::APPLY_NO_START_APPLY ��λ��û��ʼ����<br>
	 *		PartTime::APPLY_END_APPLY ��λ�ѽ���Ԥ��<br>
	 *		PartTime::APPLY_FULL ������������<br>
	 *		PartTime::APPLY_SEX �Ա𲻷���<br>
	 *		PartTime::APPLY_HEIGHT ��߲�����<br>
	 *		PartTime::APPLY_WORK_TIME ����ʱ�䲻����<br>
	 *		PartTime::APPLY_HEALTH Ҫ�󽡿�֤<br>
	 *		PartTime::APPLY_BIKE Ҫ�����г�<br>
	 *		true �ɹ�
	 */
	public static function ApplyPartTime ($param) {

		$job_id  = $param['job_id'];
		$user_id = $param['user_id'];
		return PartTime::Apply($job_id, $user_id);
	}

	/**
	 * ��ְȡ������
	 * @param $param
	 *		array(
	 *			'job_id' => '��λID',
	 *			'user_id' => '��ԱID'
	 *		)
	 * @return
	 *		PartTime::CANCELAPPLY_ERROR_USER_ID ��ԱID����<br>
	 *		PartTime::CANCELAPPLY_END_TIME ������������������ȡ��<br>
	 *		true �ɹ�
	 */
	public static function CancelApplyPartTime ($param) {
		
		$job_id  = $param['job_id'];
		$user_id = $param['user_id'];
		return PartTime::CancelApply($job_id, $user_id);
	}

	/**
	 * �����
	 * @param $param
	 *		array(
	 *			'id' => '�ID',
	 *			'user_id' => '��ԱID'
	 *		)
	 * @return
	 *		HuoDong::APPLY_NO_START_APPLY ���û��ʼ����<br>
	 *		HuoDong::APPLY_FULL ������������<br>
	 *		HuoDong::APPLY_END_APPLY ���������<br>
	 *		HuoDong::APPLY_REAPPLY �ظ�����<br>
	 *		HuoDong::APPLY_NOT_EXISTS �������<br>
	 *		true �ɹ�
	 */
	public static function ApplyHuoDong ($param) {

		$id = $param['id'];
		$user_id = $param['user_id'];
		return HuoDong::Apply($id, $user_id);
	}

	/**
	 * �ȡ������
	 * @param $param
	 *		array(
	 *			'id' => '�ID',
	 *			'user_id' => '��ԱID'
	 *		)
	 * @return
	 *		HuoDong::CANCELAPPLY_END_TIME ������������������ȡ��<br>
	 *		true �ɹ�
	 */
	public static function CancelApplyHuoDong ($param) {

		$id  = $param['id'];
		$user_id = $param['user_id'];
		return HuoDong::CancelApply($id, $user_id);
	}
	
	/**
	 * ��ȡ�����ĸ�λ
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(number=>123,...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(��λ��Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'page_size' => ÿҳ��¼��
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function GetApplyPartTime ($param) {
		
		$user_id   = $param['user_id'];
		$page      = $param['page'];
		$where     = $param['where'];
		$page_size = $param['epage'];

		return PartTime::GetMemberApplyList($user_id, $page, $where, $page_size);
	}

	/**
	 * ��ȡ��Ա¼ȡ�ļ�ְ�б�
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(number=>123,...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(��λ��Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'page_size' => ÿҳ��¼��
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function GetMemberWork ($param) {

		$user_id   = $param['user_id'];
		$page      = $param['page'];
		$where     = $param['where'];
		$page_size = $param['epage'];

		return PartTime::GetMemberWorkList($user_id, $page, $where, $page_size);
	}

	/**
	 * ��ȡ��ְ��λ�б�
	 * @param $param
	 *		array(
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(name like 'abc',...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(��λ��Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function GetJob ($param) {
		
		$page      = $param['page'];
		$where     = $param['where'];
		$page_size = $param['epage'];

		$where['status'] = 1;
		
		return PartTime::GetJobList($page, $where, $page_size);
	}

	/**
	 * ��ȡ�����Ļ
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(id=>12,...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(���Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'page_size' => ÿҳ��¼��
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function GetApplyHuoDong ($param) {

		$user_id = $param['user_id'];
		$page    = isset($param['page'])?(int)$param['page']:1;
		$where   = isset($param['where'])?$param['where']:array();
		$page_size = isset($param['epage'])?(int)$param['epage']:20;
		
		return HuoDong::GetApply($user_id, $page, $where, $page_size);
	}

	/**
	 * ��ȡ��б�
	 * @param $param
	 *		array(
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(id=>12,...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(���Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'page_size' => ÿҳ��¼��
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function GetHuoDong ($param) {

		$page = isset($param['page'])?(int)$param['page']:1;
		$where = isset($param['where'])?$param['where']:array();
		$page_size = isset($param['epage'])?(int)$param['epage']:20;
		
		return HuoDong::Get($page, $where, $page_size);
	}

	/**
	 * ��ѵ����
	 * @param $param
	 *		array(
	 *			'id' => '��ѵID',
	 *			'user_id' => '��ԱID'
	 *		)
	 * @return
	 *		PeiXun::APPLY_NO_START_APPLY ��ѵ��û��ʼ����<br>
	 *		PeiXun::APPLY_FULL ������������<br>
	 *		PeiXun::APPLY_END_APPLY ��ѵ��������<br>
	 *		PeiXun::APPLY_REAPPLY �ظ�����<br>
	 *		PeiXun::APPLY_NOT_EXISTS ��ѵ������<br>
	 *		true �ɹ�
	 */
	public static function ApplyPeiXun ($param) {

		$id = $param['id'];
		$user_id = $param['user_id'];
		return PeiXun::Apply($id, $user_id);
	}

	/**
	 * ��ѵȡ������
	 * @param $param
	 *		array(
	 *			'id' => '��ѵID',
	 *			'user_id' => '��ԱID'
	 *		)
	 * @return
	 *		HuoDong::CANCELAPPLY_END_TIME ������������������ȡ��<br>
	 *		true �ɹ�
	 */
	public static function CancelApplyPeiXun ($param) {

		$id  = $param['id'];
		$user_id = $param['user_id'];
		return PeiXun::CancelApply($id, $user_id);
	}
	
	/**
	 * ��ȡ��������ѵ
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(id=>12,...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(��ѵ��Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'page_size' => ÿҳ��¼��
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function GetApplyPeiXun ($param) {

		$user_id = $param['user_id'];
		$page    = isset($param['page'])?(int)$param['page']:1;
		$where   = isset($param['where'])?$param['where']:array();
		$page_size = isset($param['epage'])?(int)$param['epage']:20;

		return PeiXun::GetApply($user_id, $page, $where, $page_size);
	}

	/**
	 * ��ȡ��ѵ�б�
	 * @param $param
	 *		array(
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(id=>12,...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(��ѵ��Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'page_size' => ÿҳ��¼��
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function GetPeiXun ($param) {

		$page = isset($param['page'])?(int)$param['page']:1;
		$where = isset($param['where'])?$param['where']:array();
		$page_size = isset($param['epage'])?(int)$param['epage']:20;

		return PeiXun::Get($page, $where, $page_size);
	}
	
	/**
	 * ��ȡVIP������
	 * @return array VIP������
	 */
	public static function GetVIPType () {

		return VipUser::CardType();
	}


	/**
	 * ����VIP
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱVIP',
	 *			'card_type' => 'VIP����ID',
	 *			'card_number' => '����',
	 *			'password' => 'VIP������',
	 *		)
	 * @return
	 *		VipUser::USER_NOT_EXISTS ��Ա������<br>
	 *		VipUser::USER_NOT_RESUME ��Աû�м���<br>
	 *		VipUser::USER_IS_VIP �Ѿ���VIP��Ա<br>
	 *		VipUser::CARD_NOT_EXISTS VIP��������<br>
	 *		VipUser::CARD_IS_USED VIP ���ѱ�ʹ��<br>
	 *		VipUser::CARD_ERROR_PASSWORD VIP���������<br>
	 *		VipUser::INVALID_CARD_TYPE VIP������Ч<br>
	 *		true �ɹ�
	 */
	public static function ActiveVIP ($param) {
		global $mysql;

		$user_name = '';
		$user_id   = $param['user_id'];
		$vct_id    = $param['card_type'];
		$card_number = $param['card_number'];
		$password    = $param['password'];
		
		$user = $mysql->db_fetch_array("select username from {user} where user_id={$user_id}");
		if ($user) {
			$user_name = $user['username'];
		}

		$result = VipUser::AddVipUser($user_name, $vct_id, $card_number, $password);
		if (true !== $result) {
			return $result;
		}

		return VipUser::GetVIPUserInfo($user_id);
	}

	/**
	 * ����VIP��
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID'
	 *			'month' => '��������'
	 *		)
	 * @return
	 *		VipUser::FREEZE_NO_ACTIVE_STATUS �Ǽ���״̬�޷�����<br>
	 *		VipUser::FREEZE_MORE_TIMES ���ᳬ��2��<br>
	 *		VipUser::FREEZE_INVALID_TIME ����ʱ����Ч<br>
	 *		true �ɹ�
	 */
	public static function FreezeVIP ($param) {
		global $mysql;

		$user_id = $param['user_id'];
		$month   = $param['month'];

		$vu = $mysql->db_fetch_array("select card_number from {vip_user} where user_id={$user_id}");
		if (!$vu) {
			return false;
		}
		$vc = $mysql->db_fetch_array("select id from {vip_card} where serial_number='{$vu['card_number']}'");
		if (!$vc) {
			return false;
		}
		
		return VipUser::FreezeCard($vc['id'], $month);
	}

	/**
	 * ���VIP����
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID'
	 *		)
	 * @return bool true/false
	 */
	public static function ReleaseFreezeVIP ($param) {
		global $mysql;

		$user_id = $param['user_id'];

		$vu = $mysql->db_fetch_array("select card_number from {vip_user} where user_id={$user_id}");
		if (!$vu) {
			return false;
		}
		
		$vc = $mysql->db_fetch_array("select id,status from {vip_card} where serial_number='{$vu['card_number']}'");
		if (!$vc) {
			return false;
		}
		if (1 == $vc['status']) {
			return true;
		}
		else {
			if (2 != $vc['status']) {
				return false;
			}
		}

		return VipUser::ActiveCard($vc['id']);
	}

	/**
	 * ����ղ�
	 * @param $param
	 *		array(
	 *			'user_id' => '��Ա��',
	 *			'code' => '����ģ��',
	 *			'aid' => '����ID',
	 *			'name' => '����',
	 *			'url' => '���ӵ�ַ',
	 *			'remark' => '��ע'
	 *		)
	 * @return
	 *		Member::ADDFAVORITES_MODULE_NULL ����ģ�鲻��Ϊ��<br>
	 *		Member::ADDFAVORITES_NAME_NULL ���ⲻ��Ϊ��<br>
	 *		Member::ADDFAVORITES_URL_NULL ���ӵ�ַ����Ϊ��<br>
	 *		Member::ADDFAVORITES_NOT_EXISTS_USER �û�������<br>
	 *		Member::ADDFAVORITES_NOT_EXISTS_MODULE ģ�鲻����<br>
	 *		true �ɹ�
	 */
	public static function AddFavorites ($pram) {

		$user_id  = isset($pram['user_id'])?(int)($pram['user_id']):0;
		$module = isset($pram['code'])?$pram['code']:'';
		$aid  = isset($pram['aid'])?(int)($pram['aid']):'';
		$name = isset($pram['name'])?trim($pram['name']):'';
		$url  = isset($pram['url'])?trim($pram['url']):'';
		$remark = isset($pram['remark'])?trim($pram['remark']):'';
		
		if (!$module) {
			return self::ADDFAVORITES_MODULE_NULL;
		}
		if (!$name) {
			return self::ADDFAVORITES_NAME_NULL;
		}
		if (!$url) {
			return self::ADDFAVORITES_URL_NULL;
		}
		
		$result = Favorites::AddFavorites ($user_id, $module, $name, $url, $aid, $remark);
		if (Favorites::NOT_EXISTS_USER === $result) {
			return self::ADDFAVORITES_NOT_EXISTS_USER;
		}
		elseif (Favorites::NOT_EXISTS_MODULE === $result) {
			return self::ADDFAVORITES_NOT_EXISTS_MODULE;
		}
		
		return true;
	}

	/**
	 * ��ȡ�ղ��б�
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			'code' => '����ģ��',
	 *			'page' => 'ҳ��',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(�ղ���Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'page_size' => ÿҳ��¼��
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function GetFavorites ($param) {

		$user_id   = $param['user_id'];
		$module    =  isset($param['code'])?$param['code']:'';
		$page      = isset($param['page'])?$param['page']:1;
		$page_size = isset($param['epage'])?$param['epage']:20;

		return Favorites::ListFavorites($user_id, $module, '', $page, $page_size);
	}

	/**
     * ���ܼ�������
	 * @param $id
	 * @return String
     */
    public static function EnActionCode ($id) {
        
        return base64_encode((string)($id * 3 + self::ACTIVE_KEY));
    }

    /**
     * ���ܼ�������
	 * @param $id
	 * @return String
     */
    public static function DeActionCode ($id) {
        
        return (base64_decode($id) - self::ACTIVE_KEY) / 3;
    }

}
?>
