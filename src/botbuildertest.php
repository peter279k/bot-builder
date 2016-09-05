<?php
    require_once "botbuilder.php";

    use peter\components\BotBuilder;

    class BotBuilderTest extends PHPUnit_Framework_TestCase {

        /** @test */
        public function builderTest() {

            $path = __DIR__;

            $tokenPath = $path . "/token.json";

            if(file_exists($tokenPath)) {
                $contents = json_decode(file_get_contents($tokenPath), true);
                //ignore the attention comment

                $accessToken = $contents["token"];
                $userId = $contents["user_id"];
            }
            else {
                die("the token.txt is missing.");
            }

            $builder = new BotBuilder($accessToken);
            
            //subscribe testing

            $debug = true;
            $result = $builder -> subscribe($debug);

            $expect = true;

            $this -> assertSame($expect, isset($result["success"]));

            $debug = false;
            $result = $builder -> subscribe($debug);
            $expect = true;

            $this -> assertSame($expect, $result);

            $debug = "test-false";
            $expect = false;
            $result = $builder -> subscribe($debug);
            $this -> assertSame($expect, $result);

            //statusBubble testing (return value always is true.)

            $data = $this -> statusBubbleTest();
            $result = $builder -> statusBubble($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendMsg testing

            $data = $this -> sendMsgTest();
            $result = $builder -> sendMsg($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendImage testing

            $data = $this -> sendImageTest();
            $result = $builder -> sendImage($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendAudio testing

            $data = $this -> sendAudioTest();
            $result = $builder -> sendAudio($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendVideo testing

            $data = $this -> sendVideoTest();
            $result = $builder -> sendVideo($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            //sendFile testing

            $data = $this -> sendFileTest();
            $result = $builder -> sendFile($data);
            $expect = true;

            $this -> assertSame($expect, $result);

            
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
