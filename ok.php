<?
class OkApi{

    private $access_token ='';
    private $secret_session_key ='';
    private $application_key='';


    public function send($data){
        $key=array('application_key' => $this->application_key);
        return $this->get_data($key+$data);
    }

    private function get_data($data){
        $url=http_build_query($data);
        $sig=$this->sig($url);
        $data_url=$url.'&sig='.$sig.'&access_token='.$this->access_token;
        $response_json = @file_get_contents('https://api.ok.ru/fb.do?'.$data_url);
        $response = json_decode($response_json);
        if($response->error_code)$this->show_error($response_json);
        return $response;
    }

    private function show_error($data){
        print_r($data);
        exit();
    }

    private function sig($url){
        $sig=str_replace('&', '', $url);
        $sig=md5(urldecode($sig.$this->secret_session_key));
        return $sig;
    }
}


$ok = new OkApi;
$data= array(
    "format"=>"json",
    "gid"=>    "#####",
    "method"=> "photosV2.getUploadUrl",
    );

$load = $ok->send($data);
print_r($load);