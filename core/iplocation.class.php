<?php
class IpLocation 
{
	/**
	 * QQWry.Dat�ļ�ָ��
	 * @var resource
	 */
	var $fp;
	
	/**
	 * ��һ��IP��¼��ƫ�Ƶ�ַ
	 * @var int
	 */
	var $firstip;
	
	/**
	 * ���һ��IP��¼��ƫ�Ƶ�ַ
	 * @var int
	 */
	var $lastip;
	
	/**
	 * IP��¼�����������������汾��Ϣ��¼��
	 * @var int
	 */
	var $totalip;
    
	/**
	 * ���ض�ȡ�ĳ�������
	 * @access private
	 * @return int
	 */
	function getlong() 
	{
		$result = unpack('Vlong', fread($this->fp, 4));	//����ȡ��little-endian�����4���ֽ�ת��Ϊ��������
		return $result['long'];
	}
    
	/**
	* ���ض�ȡ��3���ֽڵĳ�������
	* @access private
	* @return int
	*/
	function getlong3() 
	{
		$result = unpack('Vlong', fread($this->fp, 3).chr(0));	//����ȡ��little-endian�����3���ֽ�ת��Ϊ��������
		return $result['long'];
	}
    
	/**
	* ����ѹ����ɽ��бȽϵ�IP��ַ
	* @access private
	* @param string $ip
	* @return string
	*/
	function packip($ip) 
	{
		// ��IP��ַת��Ϊ���������������PHP5�У�IP��ַ�����򷵻�False��
		// ��ʱintval��Flaseת��Ϊ����-1��֮��ѹ����big-endian������ַ���
		return pack('N', intval(ip2long($ip)));			//intaval ��ȡ����������ֵ
	}
    
	/**
	* ���ض�ȡ���ַ���
	* @access private
	* @param string $data
	* @return string
	*/
	function getstring($data = "") 
	{
		$char = fread($this->fp, 1);
		while (ord($char) > 0)					// �ַ�������C��ʽ���棬��\0���� ord()�õ��ַ���ASCII��
		{
			$data .= $char;				// ����ȡ���ַ����ӵ������ַ���֮��
			$char = fread($this->fp, 1);
		}
		return $data;
	}
    
	/**
	* ���ص�����Ϣ
	* @access private
	* @return string
	*/
	function getarea() 
	{
		$byte = fread($this->fp, 1);				// ��־�ֽ�
		switch (ord($byte)) {
			case 0:						// û��������Ϣ
				$area = "";
				break;
			case 1:
			case 2:						// ��־�ֽ�Ϊ1��2����ʾ������Ϣ���ض���
				fseek($this->fp, $this->getlong3());
				$area = $this->getstring();
				break;
			default:					// ���򣬱�ʾ������Ϣû�б��ض���
				$area = $this->getstring($byte);
				break;
		}
		return $area;
	}
    
	/**
	* �������� IP ��ַ�������������ڵ�����Ϣ
	* @access public
	* @param string $ip
	* @return array
	*/
	function getlocation($ip = '') 
	{
		if (!$this->fp) return null;				// ��������ļ�û�б���ȷ�򿪣���ֱ�ӷ��ؿ�
		if($ip == '') $ip = $this->clientIp();
		$location['ip'] = gethostbyname($ip);			// �����������ת��ΪIP��ַ
		$ip = $this->packip($location['ip']);			// �������IP��ַת��Ϊ�ɱȽϵ�IP��ַ
		
		$l = 0;                            				// �������±߽�
		$u = $this->totalip;            				// �������ϱ߽�
		$findip = $this->lastip;        				// ���û���ҵ��ͷ������һ��IP��¼��QQWry.Dat�İ汾��Ϣ��
		while ($l <= $u)					// ���ϱ߽�С���±߽�ʱ������ʧ��
		{
			$i = floor(($l + $u) / 2);			// ��������м��¼
			fseek($this->fp, $this->firstip + $i * 7);
			$beginip = strrev(fread($this->fp, 4));        // ��ȡ�м��¼�Ŀ�ʼIP��ַ
			
			if ($ip < $beginip)         			// �û���IPС���м��¼�Ŀ�ʼIP��ַʱ
			{
				$u = $i - 1;            			// ���������ϱ߽��޸�Ϊ�м��¼��һ
			}
			else 
			{
				fseek($this->fp, $this->getlong3());
				$endip = strrev(fread($this->fp, 4));	// ��ȡ�м��¼�Ľ���IP��ַ
				if ($ip > $endip)			// �û���IP�����м��¼�Ľ���IP��ַʱ
				{
					$l = $i + 1;			// ���������±߽��޸�Ϊ�м��¼��һ
				}
				else					// �û���IP���м��¼��IP��Χ��ʱ
				{
					$findip = $this->firstip + $i * 7;
					break;				// ���ʾ�ҵ�������˳�ѭ��
				}
			}
		}
		
		/* ��ȡ���ҵ���IP����λ����Ϣ */
		fseek($this->fp, $findip);
		$location['beginip'] = long2ip($this->getlong());	// �û�IP���ڷ�Χ�Ŀ�ʼ��ַ
		$offset = $this->getlong3();
		fseek($this->fp, $offset);
		$location['endip'] = long2ip($this->getlong());	// �û�IP���ڷ�Χ�Ľ�����ַ
		$byte = fread($this->fp, 1);				// ��־�ֽ�
		switch (ord($byte)) 
		{
			case 1: 					// ��־�ֽ�Ϊ1����ʾ���Һ�������Ϣ����ͬʱ�ض���
				$countryOffset = $this->getlong3();	// �ض����ַ
				fseek($this->fp, $countryOffset);
				$byte = fread($this->fp, 1);		// ��־�ֽ�
				switch (ord($byte)) 
				{
					case 2:				// ��־�ֽ�Ϊ2����ʾ������Ϣ�ֱ��ض���
						fseek($this->fp, $this->getlong3());
						$location['country'] = $this->getstring();
						fseek($this->fp, $countryOffset + 4);
						$location['area'] = $this->getarea();
						break;
					default:			// ���򣬱�ʾ������Ϣû�б��ض���
						$location['country'] = $this->getstring($byte);
						$location['area'] = $this->getarea();
						break;
				}
				break;
			case 2: 					// ��־�ֽ�Ϊ2����ʾ������Ϣ���ض���
				fseek($this->fp, $this->getlong3());
				$location['country'] = $this->getstring();
				fseek($this->fp, $offset + 8);
				$location['area'] = $this->getarea();
				break;
			default:					// ���򣬱�ʾ������Ϣû�б��ض���
				$location['country'] = $this->getstring($byte);
				$location['area'] = $this->getarea();
				break;
		}
		
		if ($location['country'] == " CZ88.NET")		// CZ88.NET��ʾû����Ч��Ϣ
		{
			$location['country'] = "δ֪";
		}
		if ($location['area'] == " CZ88.NET") 
		{
			$location['area'] = "";
		}
		return $location;
	}
	
	/**
	 * ��ȡ�ͻ���IP��ַ
	 * */
	function clientIp(){
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
		unset($onlineipmatches);
		return $onlineip;
	}
    
	/**
	 * ���캯������ QQWry.Dat �ļ�����ʼ�����е���Ϣ
	 * @param string $filename
	 * @return IpLocation
	 */
	function IpLocation($filename = "") 
	{
		if(!$filename) $filename = dirname(__FILE__) . '/qqwry/qqwry.dat';
		if(!file_exists($filename)) exit('qqwry.dat is not exists!');
		if (($this->fp = @fopen($filename, 'rb')) !== false) 
		{
			$this->firstip = $this->getlong();
			$this->lastip = $this->getlong();
			$this->totalip = ($this->lastip - $this->firstip) / 7;
			register_shutdown_function(array(&$this, '_IpLocation'));
		}
	}
    
	/**
	* ����������������ҳ��ִ�н������Զ��رմ򿪵��ļ���
	*/
	function _IpLocation() 
	{
		fclose($this->fp);
	}
}
?>