<?php


/**
 * Main SMS-API class
 *
 * Example:
 * <code>
 * <?php
 * require_once ("sms_api.php");
 * $mysms = new sms();
 * echo $mysms->session;
 * echo $mysms->getbalance();
 * // $mysms->token_pay("1234567890123456"); //spend voucher with SMS credits
 * $mysms->send ("38160123", "netsector", "TEST MESSAGE");
 * ?>
 * </code>
 * @package sms_api
 */


class sms {

    var $api_id = "YOUR_gateway_API_NUMBER";

    /**
    * gateway username
    * @var mixed
    */
    var $sms_user = "USERNAME";

    /**
    * gateway password
    * @var mixed
    */
    var $sms_password = "PASSWORD";

    /**
    * Use SSL (HTTPS) protocol
    * @var bool
    */
    var $use_ssl = false;

    /**
    * Define SMS balance limit below class will not work
    * @var integer
    */
    var $balace_limit = 0;

    /**
    * Gateway command sending method (curl,fopen)
    * @var mixed
    */
    var $sending_method = "fopen";

    /**
    * Does to use facility for delivering Unicode messages
    * @var bool
    */
    var $unicode = false;

    /**
    * Optional CURL Proxy
    * @var bool
    */
    var $curl_use_proxy = false;

    /**
    * Proxy URL and PORT
    * @var mixed
    */
    var $curl_proxy = "http://sms.satconcepts.com/sms_api.php";

    /**
    * Proxy username and password
    * @var mixed
    */
    var $curl_proxyuserpwd = "login:secretpass";

    /**
    * Callback
    * 0 - Off
    * 1 - Returns only intermediate statuses
    * 2 - Returns only final statuses
    * 3 - Returns both intermediate and final statuses
    * @var integer
    */
    var $callback = 0;

    /**
    * Session variable
    * @var mixed
    */
    var $session;

    /**
    * Class constructor
    * Create SMS object and authenticate SMS gateway
    * @return object New SMS object.
    * @access public
    */
    function sms ($sms_user,$pass, $url) {
        if ($this->use_ssl) {
            $this->base   = $url;
            $this->base_s = $url;
        } else {
            $this->base   = $url;
            $this->base_s = $this->base;
        }

        $this->sms_user = $sms_user;
	    $this->sms_password = $pass;
    }
   
    /**
    * Authenticate SMS gateway
    * @return mixed  "OK" or script die
    * @access private
    */
    function _auth() {
    	$comm = sprintf ("%s?user=%s&password=%s&", $this->base_s, $this->sms_user, $this->sms_password);
        $this->session = $this->_parse_auth ($this->_execgw($comm));
    }

    /**
    * Query SMS credis balance
    * @return integer  number of SMS credits
    * @access public
    */
    function getbalance() {
    	$comm = sprintf ("%s?username=%s&password=%s&balance=true&", $this->base, $this->sms_user, $this->sms_password);
        return $this->_parse_getbalance ($this->_execgw($comm));
    }

    /**
    * Send SMS message
    * @param to mixed  The destination address.
    * @param from mixed  The source/sender address
    * @param text mixed  The text content of the message
    * @return mixed  "OK" or script die
    * @access public
    */
    function send($to=null, $from=null, $text=null) {
       
    	/* Check SMS credits balance 
    	if ($this->getbalance() < $this->balace_limit) {
    	    die ("You have reach the SMS credit limit!");
    	};
*/
    	/* Check SMS $text length */
        if ($this->unicode == true) {
            $this->_chk_mbstring();
            if (mb_strlen ($text) > 210) {
        	    return ("Your unicode message is to long! (Current lenght=".mb_strlen ($text).")");
        	}
        	/* Does message need to be concatenate */
            if (mb_strlen ($text) > 70) {
                $concat = "&concat=3";
        	} else {
                $concat = "";
            }
        } else {
            if (strlen ($text) > 465) {
    	        return ("Your message is to long! (Current lenght=".strlen ($text).")");
    	    }
        	/* Does message need to be concatenate */
            if (strlen ($text) > 160) {
                $concat = "&concat=3";
        	} else {
                $concat = "";
            }
        }

    	/* Check $to and $from is not empty */
        if (empty ($to)) {
    	    return ("You not specify destination address (TO)!");
    	}
        if (empty ($from)) {
    	    return ("You not specify source address (FROM)!");
    	}

    	/* Reformat $to number */
        $cleanup_chr = array ("+", " ", "(", ")", "\r", "\n", "\r\n");
        $to = str_replace($cleanup_chr, "", $to);

    	/* Send SMS now */
    	$comm = sprintf ("%s?user=%s&password=%s&sender=%s&recipient=%s&message=%s&",
	    $this->base,
	    $this->sms_user,
	    $this->sms_password,
            rawurlencode($from),
            rawurlencode($to),
            $this->encode_message($text)
        );

       // return $comm;
       return $this->_parse_send ($this->_execgw($comm));
    }

    /**
    * Encode message text according to required standard
    * @param text mixed  Input text of message.
    * @return mixed  Return encoded text of message.
    * @access public
    */
    function encode_message ($text) {
        if ($this->unicode != true) {
            //standard encoding
            return rawurlencode($text);
        } else {
            //unicode encoding
            $uni_text_len = mb_strlen ($text, "UTF-8");
            $out_text = "";

            //encode each character in text
            for ($i=0; $i<$uni_text_len; $i++) {
                $out_text .= $this->uniord(mb_substr ($text, $i, 1, "UTF-8"));
            }

            return $out_text;
        }
    }

    /**
    * Unicode function replacement for ord()
    * @param c mixed  Unicode character.
    * @return mixed  Return HEX value (with leading zero) of unicode character.
    * @access public
    */
    function uniord($c) {
        $ud = 0;
        if (ord($c{0})>=0 && ord($c{0})<=127)
            $ud = ord($c{0});
        if (ord($c{0})>=192 && ord($c{0})<=223)
            $ud = (ord($c{0})-192)*64 + (ord($c{1})-128);
        if (ord($c{0})>=224 && ord($c{0})<=239)
            $ud = (ord($c{0})-224)*4096 + (ord($c{1})-128)*64 + (ord($c{2})-128);
        if (ord($c{0})>=240 && ord($c{0})<=247)
            $ud = (ord($c{0})-240)*262144 + (ord($c{1})-128)*4096 + (ord($c{2})-128)*64 + (ord($c{3})-128);
        if (ord($c{0})>=248 && ord($c{0})<=251)
            $ud = (ord($c{0})-248)*16777216 + (ord($c{1})-128)*262144 + (ord($c{2})-128)*4096 + (ord($c{3})-128)*64 + (ord($c{4})-128);
        if (ord($c{0})>=252 && ord($c{0})<=253)
            $ud = (ord($c{0})-252)*1073741824 + (ord($c{1})-128)*16777216 + (ord($c{2})-128)*262144 + (ord($c{3})-128)*4096 + (ord($c{4})-128)*64 + (ord($c{5})-128);
        if (ord($c{0})>=254 && ord($c{0})<=255) //error
            $ud = false;
        return sprintf("%04x", $ud);
    }

    /**
    * Spend voucher with sms credits
    * @param token mixed  The 16 character voucher number.
    * @return mixed  Status code
    * @access public
    */
    function token_pay ($token) {
        $comm = sprintf ("%s/send_sms.php?session_id=%s&token=%s",
        $this->base,
        $this->session,
        $token);

        return $this->_execgw($comm);
    }

    /**
    * Execute gateway commands
    * @access private
    */
    function _execgw($command) {
	  // echo $command;
        if ($this->sending_method == "curl")
            return $this->_curl($command);
        if ($this->sending_method == "fopen")
            return $this->_fopen($command);
            return "Unsupported sending method!";
    }

    /**
    * CURL sending method
    * @access private
    */
    function _curl($command) {
        $this->_chk_curl();
        $ch = curl_init ($command);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER,0);
        if ($this->curl_use_proxy) {
            curl_setopt ($ch, CURLOPT_PROXY, $this->curl_proxy);
            curl_setopt ($ch, CURLOPT_PROXYUSERPWD, $this->curl_proxyuserpwd);
        }
        $result=curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }

    /**
    * fopen sending method
    * @access private
    */
    function _fopen($command) {
        $result = '';
        $handler = @fopen ($command, 'r');
        if ($handler) {
            while ($line = @fgets($handler,1024)) {
                $result .= $line;
            }
            fclose ($handler);
            return $result;
        } else {
            return "Error while executing fopen sending method!<br>Please check does PHP have OpenSSL support and check does PHP version is greater than 4.3.0.";
        }
    }

    /**
    * Parse authentication command response text
    * @access private
    */
    function _parse_auth ($result) {
    	$session = substr($result, 4);
        $code = substr($result, 0, 2);
        if ($code!="OK") {
            return ("Error in SMS authorization! ($result)");
        }
        return $session;
    }

    /**
    * Parse send command response text
    * @access private
    */
    function _parse_send ($result) {
    	$code = substr($result, 0, 2);
       // echo $result;
    	if ($code=="OK") {
    	    $code = "OK";

    	} else {
    	    return $result;

    	}
        return $code;
    }

    /**
    * Parse getbalance command response text
    * @access private
    */
    function _parse_getbalance ($result) {
    	$result = substr($result, 8);
        return (int)$result;
    }

    /**
    * Check for CURL PHP module
    * @access private
    */
    function _chk_curl() {
        if (!extension_loaded('curl')) {
            return ("This SMS API class can not work without CURL PHP module! Try using fopen sending method.");
        }
    }

    /**
    * Check for Multibyte String Functions PHP module - mbstring
    * @access private
    */
    function _chk_mbstring() {
        if (!extension_loaded('mbstring')) {
            return ("Error. This SMS API class is setup to use Multibyte String Functions module - mbstring, but module not found. Please try to set unicode=false in class or install mbstring module into PHP.");
        }
    }

}

?>