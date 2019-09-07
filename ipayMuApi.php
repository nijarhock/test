<?php
/*

 * library untuk ipaymu

*/

class IpayMuApi
{
	// url untuk kirim api ipaymu
	protected $url;

	// data untuk di kirim ke api ipaymu
	protected $params;

	// api key dari ipaymu
	protected $key;

	// url return, notify, cancel untuk di kirim ke ipaymu
	protected $urlReturn;
	protected $urlNotify;
	protected $urlCancel;

	public function setApi($key)
	{
		$this->key = $key;
	}

	// set url callback
	public function urlCallBack($return, $notify, $cancel)
	{
		$this->urlReturn = $return;
		$this->urlNotify = $notify;
		$this->urlCancel = $cancel;
	}

	// payment method
	public function payment($params)
	{
		$this->url = "https://my.ipaymu.com/payment.htm";

		$params['key'] = $this->key;
		$params['action'] = 'payment';
		$params['ureturn'] = $this->urlReturn;
		$params['unotify'] = $this->urlNotify;
		$params['ucancel'] = $this->urlCancel;
		$params['format'] = 'json';

		$this->params = $params;

		$params_string = http_build_query($this->params);
		// open connection
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, count($this->params));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$respons = array();

		// execute post
		$request = curl_exec($ch);

		if($request === false)
		{
			$respons = array("status" => "error", "message" => "Curl Error: ". curl_error($ch));

		}
		else
		{
			$result = json_decode($request, true);

			if(isset($result['url']))
			{
				$respons = array("status" => "ok", "message" => $result['url'], "sessionid" => $result['sessionID']);
			}
			else
			{
				$respons = array("status" => "error", "message" => "Error ". $result['Status'].":".$result["Keterangan"]);
			}
		}

		return $respons;

		// close connection
		curl_close($ch);
	}

	public function cekSaldo()
	{
		$this->url = "https://my.ipaymu.com/api/CekSaldo.php?key=".$this->key;

		$params = array(
			"key"	=> $this->key,
			"format"=> "json"
		);

		$params_string = http_build_query($params);

		// open connection
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		// execute post
		$request = curl_exec($ch);

		if($request === false)
		{
			$respons = array("status" => "error", "message" => "Curl Error: ". curl_error($ch));
		}
		else
		{
			$result = json_decode($request, true);

			$respons = $result;
		}
		return $respons;
		// close connection
		curl_close($ch);
	}

	public function cekTransaski($id)
	{
		$this->url = "https://my.ipaymu.com/api/cekTransaski".$this->key;

		$params = array(
			"key"	=> $this->key,
			"id"	=> $id,
			"format"=> "json"
		);

		$params_string = http_build_query($params);

		// open connection
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$respons = array();

		// execute post
		$request = curl_exec($ch);

		if($request === false)
		{
			$respons = array("status" => "error", "message" => "Curl Error: ". curl_error($ch));

		}
		else
		{
			$result = json_decode($request, true);

			if(isset($result['url']))
			{
				$respons = array("status" => "ok", "message" => $result['url']);
			}
			else
			{
				$respons = array("status" => "error", "message" => "Error ". $result['Status'].":".$result["Keterangan"]);
			}
		}

		return $respons;

		// close connection
		curl_close($ch);
	}

	public function getProfil()
	{
		$this->url = "https://my.ipaymu.com/api/profile";

		$params = array(
			"key"	=> $this->key,
			"format"=> "json"
		);

		$params_string = http_build_query($params);

		// open connection
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		// execute post
		$request = curl_exec($ch);

		if($request === false)
		{
			$respons = array("status" => "error", "message" => "Curl Error: ". curl_error($ch));
		}
		else
		{
			$result = json_decode($request, true);

			$respons = $result;
		}
		return $respons;
		// close connection
		curl_close($ch);
	}
}
?>