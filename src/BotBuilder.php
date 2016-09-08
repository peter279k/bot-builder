<?php
    namespace peter\components;
    use GuzzleHttp\Client;

    class BotBuilder {
        public function __construct($accessToken) {
            $this -> accessToken = $accessToken;
            $this -> reqUrl = "https://graph.facebook.com/v2.6/me/messages?access_token=" . $this -> accessToken;
            $this -> settingUrl = "https://graph.facebook.com/v2.6/me/thread_settings?access_token=" . $this -> accessToken;
            $this -> subscribeUrl = "https://graph.facebook.com/v2.6/me/subscribed_apps?access_token=" . $this -> accessToken;
        }

        public function verify($verifyToken) {
            $hubMode = filter_input(INPUT_GET, "hub_mode");
            $hubChallenge = filter_input(INPUT_GET, "hub_challenge");
            $hubVerifyToken = filter_input(INPUT_GET, "hub_verify_token");
            
            if($verifyToken === $hubVerifyToken) {
                return $hubChallenge;
            }
            else  {
                return false;
            }
        }

        public function receiveMsg() {
            //web hook post back or raw post json data

            $rawData = file_get_contents("php://input");
            $input = json_decode($rawData, true);

            return $input;
        }

        public function sendMsg($type, $input, $data) {
            switch($type) {
                case "images":
                    $this -> sendImage($data);
                    break;
                case "texts":
                    $this -> sendText($data);
                    break;
                case "files":
                    $this -> sendFile($data);
                    break;
            }

            return $this -> clientSend($input, $data);

        }

        public function subscribe($debug) {
            $client = new Client();
            $response = $client -> request("POST", $this -> subscribeUrl);
            $json = $response -> getBody();
            $json = json_decode($json, true);
            
            if($debug === true) {
                return $json;
            }
            else if($debug === false){
                if(isset($json["success"])) {
                    return $json["success"];
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }

        public function statusBubble($data) {
            $client = new Client();
            $header = array(
                "verify" => false,
                "headers" => array(
                    "Content-Type" => "application/json"
                ),
                "json" => $data
            );
            $response = $client -> request("POST", $this -> reqUrl, $header);
            $json = $response -> getBody();
            return true;
        }

        public function sendImage($data) {
            if(count($data["attachment"]["payload"]) === 0) {
                return $this -> clientUpload($data);
            }
            else {
                return $this -> clientSend($input, $data);
            }
        }

        public function sendText($data) {
            return $this -> clientSend($input, $data);
        }

        public function sendFile($data) {
            if(count($data["attachment"]["payload"]) === 0) {
                return $this -> clientUpload($data);
            }
            else {
                return $this -> clientSend($input, $data);
            }
        }

        private function clientUpload($data) {
            $client = new Client();
            $data["filedata"] = fopen($data["filedata"], "r");
            $headers = array(
                "verify" => false,
                "form_params" => $data
            );

            $response = $client -> request("POST", $this -> reqUrl,  $data, $headers);
            $json = $response -> getBody();
            return json_decode($json, true);

        }

        private function clientSend($input, $data) {
            $client = new Client();
            $header = array(
                "verify" => false,
                "headers" => array(
                    "Content-Type" => "application/json"
                ),
                "json" => $data
            );
            
            if(!empty($input['entry'][0]['messaging'][0]['message'])) {
                $response = $client -> request("POST", $this -> reqUrl, $header);
                $json = $response -> getBody();
                $json = json_decode($json, true);
                if(isset($json["message_id"]))
                    return true;
                else
                    return $json;
            }
            else {
                return $json;
            }
        }

    }

?>
