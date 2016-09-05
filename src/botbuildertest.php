<?php
    require_once "botbuilder.php";

    use peter\components\BotBuilder;

    class BotBuilderTest extends PHPUnit_Framework_TestCase {

        /** @test */
        public function builderTest() {

            $path = __DIR__;

            $tokenPath = $path . "/token.txt";

            if(file_exists($tokenPath)) {
                $handle = fopen($tokenPath);
                //ignore the attention comment

                fgets($handle, 4096);
                $accessToken = fgets($handle, 4096);
                $userId = fgets($handle, 4096);
                fclose($handle);
            }
            else {
                die("the token.txt is missing.");
            }

            $builder = new BotBuilder(file_get_contents($path . "/token.txt"));
            
            //subscribe testing

            $debug = true;
            $result = $this -> subscribe($debug);

            $expect = true;

            $this -> assertSame($expect, $result);

            $debug = false;
            $result = $this -> subscribe($debug);

            $this -> assertSame(false, !empty($result["success"]));

            $debug = "test-false";
            $expect = false;
            $result = $this -> assertSame($expect, $result);

            //addMenu testing

            $data = $this -> addMenuTest();
            $result = $this -> addMenu($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //addMenu testing (error)

            $data = $this -> errMenu();
            $result = $this -> addMenu($data);
            $expect = false;

            $this -> assertSame($expect, $result["success"]);

            //addGreeting testing

            $data = $this -> addGreetingTest();
            $result = $this -> addGreeting($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //addGreeting testing (error)

            $data = $this -> errGreeting();
            $result = $this -> addGreeting($data);
            $expect = false;

            $this -> assertSame($expect, $result["success"]);

            //statusBubble testing (return value always is true.)

            $data = $this -> statusBubbleTest();
            $result = $this -> statusBubble($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendMsg testing

            $data = $this -> sendMsgTest();
            $result = $this -> sendMsg($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendImage testing

            $data = $this -> sendImageTest();
            $result = $this -> sendImage($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendAudio testing

            $data = $this -> sendAudioTest();
            $result = $this -> sendAudio($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendVideo testing

            $data = $this -> sendVideoTest();
            $result = $this -> sendVideo($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendFile testing

            
            
        }

        public function addMenuTest() {
            $data = array(
                "setting_type" => "call_to_actions",
                "thread_state" => "existing_thread",
                "call_to_actions" => array(
                    array(
                        "type" => "postback",
                        "title" => "Help",
                        "payload" => "DEVELOPER_DEFINED_PAYLOAD_FOR_HELP"
                    )
                )
            );
            return $data;
        }

        public function errMenu() {
            $data = array(
                "setting_type" => "call_to_actions",
                "thread_state" => "existing_thread",
                "call_to_actions" => array(
                    array(
                        "type" => "postback123",
                        "title" => "Help",
                        "payload" => "DEVELOPER_DEFINED_PAYLOAD_FOR_HELP"
                    )
                )
            );
            return $data;
        }

        public function addGreetingTest() {
            $data = array(
                "setting_type" => "greeting",
                "greeting" => array(
                    "text" => "Welcome to my bot service !"
                )
            );
            return $data;
        }

        public function errGreeting() {
            $data = array(
                "setting_type" => "greeting123",
                "greeting" => array(
                    "text" => "Welcome to my bot service !"
                )
            );
            return $data;
        }

        public function deleteMenuTest() {
            $data = array(
                "setting_type" => "call_to_actions",
                "thread_state" => "existing_thread"
            );
            return $data;
        }

        public function deleteGreetingTest() {
            $data = array(
                "setting_type" => "greeting",
                "thread_state" => "existing_thread"
            );
            return $data;
        }

        public function statusBubbleTest() {
            $data = array(
                "recipient" => array(
                    "id" => $userId
                ),
                "sender_action" => "typing_on"
            );
            return $data;   
        }
        

        public function sendMsgTest($type) {
            if($type === "texts") {
                $data = array(
                    "recipient" => array(
                        "id" => $userId
                    ),
                    "message" => array(
                        "text" => "Hello World!"
                    )
                );
            }

            return $data;
        }

        public function sendImageTest($type) {
            if($type === "image-url") {
                $data = array(
                    "recipient" => array(
                        "id" => $userId
                    ),
                    "message" => array(
                        "attachment" => array(
                            "type" => "image",
                            "payload" => array(
                                "url" => "http://i.imgur.com/nLLUurJ.gifv"
                            )
                        )
                    )
                );
            }

            if($type === "image") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => $userId
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "image",
                            "payload" => "{}"
                        )
                    )),
                    "filedata" => $path . "/image.png"
                );
            }

            return $data;
        }

        public function sendAudioTest($type) {
            if($type === "audio-url") {
                $data = array(
                    "recipient" => array(
                        "id" => $userId
                    ),
                    "message" => array(
                        "attachment" => array(
                            "type" => "audio",
                            "payload" => array(
                                "url" => "https://cdn.fbsbx.com/v/t59.3654-21/14163359_1251368261569686_126122173_n.mp4/audioclip-1472488756000-0.mp4?oh=2bb69dc9c0e77ab28df3f6aae58777cc&oe=57CF26B3&dl=1"
                            )
                        )
                    )
                );
            }

            if($type === "audio") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => $userId
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "audio",
                            "payload" => "{}"
                        )
                    )),
                    "filedata" => $path . "/audio.mp3"
                );
            }

            return $data;
        }

        public function sendVideoTest($type) {
            if($type === "video-url") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => $userId
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "video",
                            "payload" => array(
                                "url" => "http://techslides.com/demos/sample-videos/small.mp4"
                            )
                        )
                    )),
                    "filedata" => $path . "/image.png"
                );
            }

            if($type === "video") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => $userId
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "video",
                            "payload" => "{}"
                        )
                    )),
                    "filedata" => $path . "/video.mp4"
                );
            }

            return $data;
        }

        public function sendFileTest($type) {
            if($type === "file-url") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => $userId
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "file",
                            "payload" => array(
                                "url" => "http://txt2html.sourceforge.net/sample.txt"
                            )
                        )
                    )),
                    "filedata" => $path . "/image.png"
                );
            }

            if($type === "file") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => $userId
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "file",
                            "payload" => "{}"
                        )
                    )),
                    "filedata" => $path . "/file.txt"
                );
            }

            return $data;
        }

    }

?>
