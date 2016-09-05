<?php
    require_once "botbuilder.php";

    use peter\components\botbuilder;

    class BotBuilderTest extends PHPUnit_Framework_TestCase {

        /** @test */
        public function builderTest() {
            
        }

        public function subscribeTest() {
            $data = array(

            );
            return $data;
        }

        public function addMenuTest() {
            $data = array(

            );
            return $data;
        }

        public function addGreetingTest() {
            $data = array(
                
            );
            return $data;
        }

        public function deleteMenuTest() {
            $data = array(
                
            );
            return $data;
        }

        public function deleteGreetingTest() {
            $data = array(
                
            );
            return $data;
        }

        public function statusBubbleTest() {
            $data = array(
                
            );
            return $data;   
        }
        

        public function sendMsgTest($type) {
            if($type === "texts") {
                $data = array(
                    "recipient" => array(
                        "id" => "1670246977"
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
                        "id" => "1670246977"
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
                        "id" => "1670246977"
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "image",
                            "payload" => "{}"
                        )
                    )),
                    "filedata" => "./image.png"
                );
            }

            return $data;
        }

        public function sendAudioFileTest($type) {
            if($type === "audio-url") {
                $data = array(
                    "recipient" => array(
                        "id" => "1670246977"
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
                        "id" => "1670246977"
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "audio",
                            "payload" => "{}"
                        )
                    )),
                    "filedata" => "./audio.mp3"
                );
            }

            return $data;
        }

        public function sendVideoTest($type) {
            if($type === "video-url") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => "1670246977"
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "video",
                            "payload" => array(
                                "url" => "http://techslides.com/demos/sample-videos/small.mp4"
                            )
                        )
                    )),
                    "filedata" => "./image.png"
                );
            }

            if($type === "video") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => "1670246977"
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "video",
                            "payload" => "{}"
                        )
                    )),
                    "filedata" => "./video.mp4"
                );
            }

            return $data;
        }

        public function sendFileTest($type) {
            if($type === "file-url") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => "1670246977"
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "file",
                            "payload" => array(
                                "url" => "http://txt2html.sourceforge.net/sample.txt"
                            )
                        )
                    )),
                    "filedata" => "./image.png"
                );
            }

            if($type === "file") {
                $data = array(
                    "recipient" => json_encode(array(
                        "id" => "1670246977"
                    )),
                    "message" => json_encode(array(
                        "attachment" => array(
                            "type" => "file",
                            "payload" => "{}"
                        )
                    )),
                    "filedata" => "./file.txt"
                );
            }

            return $data;
        }

    }

?>
