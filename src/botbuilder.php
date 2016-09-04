<?php
    require "vendor/autoload.php";
    use GuzzleHttp\Client;

    class BotBuilder {
        public function __construct($accessToken) {
            $this -> accessToken = $accessToken;
            $this -> reqUrl = "https://graph.facebook.com/v2.6/me/messages?access_token=" . $this -> accessToken;
            $this -> settingUrl = "https://graph.facebook.com/v2.6/me/thread_settings?access_token=" . $this -> accessToken;
        }

        public function verify($verifyToken) {
            $hubMode = filter_input(INPUT_GET, "hub_mode");
            $hubChallenge = filter_input(INPUT_GET, "hub_challenge");
            $hubVerifyToken = filter_input(INPUT_GET, "hub_verify_token");
            
            if($verifyToken === $hubVerifyToken) {
                echo $hubChallenge;
            }
        }

        public function receiveMsg() {
            //web hook post back or raw post json data

            $rawData = file_get_contents("php://input");
            $input = json_decode($rawData, true);

            return $input;
        }

        public function sendMsg($type, $data) {
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

            return $this -> clientSend($data);

        }

        public function subscribe($data) {
            $client = new Client();
            $response = $client -> request("POST", $this -> settingUrl);
            $json = $response -> getBody();
            $json = json_decode($json, true);

            if(isset($json["success"])) {
                return $json["success"];
            }
            else {
                return $json;
            }
        }

        public function addMenu($data) {
            return $this -> threadSetting($data, "do-setting");
        }

        public function addGreeting($data) {
            return $this -> threadSetting($data, "do-setting");
        }

        public function deleteMenu($data) {
            return $this -> threadSetting($data, "delete-setting");
        }

        public function deleteGreeting($data) {
            return $this -> threadSetting($data, "delete-setting");
        }

        public function statusBubble($data) {
            $client = new Client();
            $headers = array(
                "json" => $data
            );
            $response = $client -> request("POST", $this -> reqUrl, $headers);
            $json = $response -> getBody();
        }

        private function sendImage($data) {
            return $this -> clientSend($data);
        }

        private function sendText($data) {
            return $this -> clientSend($data);
        }

        private function sendFile($data) {
            return $this -> clientSend($data);
        }

        private function clientSend($input, $data) {
            $client = new Client();
            $headers = array(
                "json" => $data
            );
            
            if(!empty($input['entry'][0]['messaging'][0]['message'])) {
                $response = $client -> request("POST", $this -> reqUrl, $headers);
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

        private function threadSetting($data) {
            $client = new Client();
            $headers = array(
                "json" => $data
            );

            if($action === "do-setting") {
                $response = $client -> request("POST", $this -> reqUrl, $headers);
            }
            else if($action === "delete-setting"){
                $response = $client -> request("DELETE", $this -> settingUrl, $headers);
            }
            else {
                return "invalid-setting";
            }

            $json = json_decode($response -> getBody(), true);
            
            if(isset($json["result"])) {
                return true;
            }
            else {
                return $json;
            }
        }

        /*
         //Get the senders graph id

            $sender = $input["entry"][0]["messaging"][0]["sender"]["id"];
            
            //Receive the message

            if(empty($input["entry"][0]["messaging"]["text"])) {
                $attachments = $input["entry"][0]["messaging"]["attachments"];
                
            }
            else {
                $message = $input["entry"][0]["messaging"]["text"];
            }
        */

    }

?>
