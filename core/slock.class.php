<?php

/**
* ������ 
* ����php����ͬ��ʱʹ��
* add by weego 20120917
*/

class slock
{
    /**
    * $lock_timeout ���õȴ���������
    * $lock_wait_func ���õȴ�����,����ʹ��usleep+mt_rand����ȴ�,����ȴ��������������
    * $add_func ���������������־����,����ʹ��PHP��APC���apc_add����,apc_add�趨��ռ������Ϊ5s,��������ռ��
    * $del_func ��������ɾ������־����,����ʹ��PHP��APC���apc_delete����
    */
    private $locks;
    private $lock_timeout = 200;
    private $lock_wait_func;
    private $add_func;
    private $del_func;
    public function __construct()
    {
        $this->add_func = function($mutex)
        {
		 
			return apc_add('sl:'.$mutex,1,5);;
			
			
        };

        $this->del_func = function($mutex)
        {
            return apc_delete('sl:'.$mutex);
        };

        $this->lock_wait_func = function()
        {
			usleep(mt_rand(1000,5000));
        };
    }

    public function __destruct()
    {
        $this->clean();
    }

    /**
    * �����ǰ�������õ���,�ڵ�ǰ��php�����п������ö����
    */
    public function clean()
    {
        if($this->locks)
        {
            foreach($this->locks as $lock => $tmp)
            call_user_func($this->del_func ,$lock);
            $this->locks = null;
        }
    }

    /**
    * �½���һ����
    * ���Ȼ��ж�������־�Ƿ��Ѿ����壬������������ж�Ϊ����
    * ���ʹ��apc�����ڴ淽ʽaddһ������־,���ʧ�������ȴ�ʱ��,ֱ����ʱ
    */
    public function lock($mutex)
    {
        if($this->locks[$mutex]!=null)
        {
            throw new Exception('System Queue...');
            return false;
        }

        while(call_user_func($this->add_func ,$mutex) == false)
        {
			//������ǰһ��û�����꣬����Ķ���ֹ����
			echo "System busy!";
			die;
            return false;
			
			//�����Ǹ߲������Ŷӻ���
			/*
            ++$i;
            if($i > $this->lock_timeout)
            {
                throw new Exception('lock timeout.');
                return false;
            }
            call_user_func($this->lock_wait_func);
			*/
        }
        $this->locks[$mutex] = 1;
        return $mutex;
    }

    /**
    * �ֶ��ͷ���,һ�㲻��,
    * �ڵ�ǰ��������ʱ���Զ��ͷ�������
    */
    public function release($mutex)
    {
        if($mutex == false) return false;
        unset($this->locks[$mutex]);
        call_user_func($this->del_func ,$mutex);
        return true;
    }
}

?>