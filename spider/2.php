<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller
{
    protected $cookieName = array('cookie_verify', 'cookie_verify');
    protected $cookiePath = '/cookie/';
    protected $cookiePathFile = array();
    public function index()
    {
        $this->display();
    }
    public function _initialize(){
        foreach($this->cookieName as $key => $name)
        {
            $this->cookiePathFile[] = ROOT_PATH . $this->cookiePath . $this->cookieName[$key] . '_xxx.txt';
        }
    }

    /**
     * 登录xxx
     */
    public function xxxLogin()
    {
        $username = I('username');
        $password = I('password');
        $verifyCode = I('verify');
        $loginData = array(
            '__VIEWSTATE' => '/wEPDwUKMTU0MzAzOTU4NmQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgEFDExvZ2luX1N1Ym1pdL/yae69NsY163G3yuP0lxjz8oXu',                            //不把参数补全可能会不被响应哦
            '__VIEWSTATEGENERATOR' => 'DC42DE27',
            'txt_UserName'  => $username,
            'txt_PWD'  => $password,
            'txt_VerifyCode'  => $verifyCode,
            'SMONEY' => 'ABC',
            'Login_Submit.x' => '52',
            'Login_Submit.y' => '19',
        );
        $getBack = $this->_cookieRequest('http://xxx.com/noLogin.aspx', $loginData);
        if(preg_match('/<p[^\<p]*?id\s*=\s*[\'\"]{1}p_msg[\'\"]{1}.*?>(.*?)<\/p>/s', $getBack, $match)){
            echo 'matched\r\n';
            print_r($match);
        }else{
            echo $getBack, '<br />';
            $paramsFull = parse_url($getBack);
            parse_str($paramsFull['query'], $paramsFull['parsedQuery']);
            if(!empty($paramsFull['parsedQuery']['Warn'])) {
                $msg = "您好，欢迎来P，请先登录。";
                switch ($paramsFull['parsedQuery']['Warn'])
                {
                    case '2':
                        $msg = '您输入的验证码错误，请重试';
                        break;
                    case '3':
                        $msg = '该帐号不存在，还没帐号？';
                        break;
                    case '5':
                        $msg = '账户已注销';
                        break;
                    case '6':
                        $msg = '密码错误，如果连续错误3次半小时内不能登录！';
                        break;
                    case '20':
                        $msg = '今日密码错误3次及以上，请于半小时后再来登录！';
                        break;
                    case '21':
                        $msg = '今日您所在IP的所有帐号密码错误9次以上，请于半小时后再来登录！';
                        break;
                    case '22':
                        $msg = '登录失败，您所在IP今日登录的帐号过多！';
                        break;
                    case '23':
                        $msg = '登录失败，验证码失效！';
                        break;
                    case '32':
                        $msg = '该帐号已经绑定其他PC蛋蛋帐号！';
                        break;
                    case '33':
                        $msg = '一台电脑一天只能注册一个帐号！';
                        break;
                }
                $this->error($msg, '', 5);
            }else{

                $_SESSION['user_id'] = '123456';            //登录设置session
                $this->success('登录P网站成功', U('Index/index'), 5);
            }
        }
    }

    /**
     * 获取验证码
     */
    public function getVerifyCode()
    {
        $img = $this->_cookieRequest('http://xxx.com/VerifyCode_Login.aspx?id=' . rand(10000,999999), null, true, 1);
        echo $img;
    }

    /**
     * 删除cookie
     */
    public function clearCookie()
    {
        for($i = 0; $i <count($this->cookieName); $i++)
        {
            setcookie($this->cookieName[$i], '', time() - 3600);
        }
//        unlink($this->cookiePathFile);
        $this->success('清除cookie成功！');
    }

    /**
     * 带COOKIE的访问curl
     * @param $url
     * @param null $data
     * @param bool $redirect
     * @return mixed
     */
    public function _cookieRequest($url, $data = null, $redirect = false, $cookieNum = 0)
    {

        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Windows NT 5.1; rv:9.0.1) Gecko/20100101 Firefox/9.0.1';

        if($data)
        {
            $params[CURLOPT_POST] = true;
            $params[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
        //判断是否有cookie,有的话直接使用
        if (!empty($_COOKIE[$this->cookieName[$cookieNum]]) && is_file($this->cookiePathFile[$cookieNum]))
        {
            $params[CURLOPT_COOKIEFILE] = $this->cookiePathFile[$cookieNum];      //这里判断cookie
        }
        else
        {
//            $cookie_jar = tempnam($cookie_path, 'cookie');                //产生一个cookie文件
            $params[CURLOPT_COOKIEJAR] = $this->cookiePathFile[$cookieNum];                   //写入cookie信息
            setcookie($this->cookieName[$cookieNum], $this->cookiePathFile[$cookieNum], time() + 120);      //保存cookie路径
        }
        curl_setopt_array($ch, $params);                                //传入curl参数
        $content = curl_exec($ch);
        $headers = curl_getinfo($ch);
//        echo $content;
        curl_close($ch);
        if ($content != $headers && $redirect == false){
            return $headers["url"];
        }
        return $content;
    }
}
?>