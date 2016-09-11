<?php
    require "BotBuilder.php";
    use peter\components\BotBuilder;
    /*
    testing:
    verifyTest
    subscribeTest
    addGreetingTest
    delGreetingTest
    addMenuTest
    delMenuTest
    */

    class BuilderTest extends PHPUnit_Framework_TestCase {
        /** @test */
        public function processTest() {
            //subscribeTest
            $expect = true;
            $response = $this -> subscribeTest();
            $this -> assertSame($expect, $response);

            //addGreetingTest
            $expect = true;
            $response = $this -> addGreetingTest("Hello World!");
            $this -> assertSame($expect, $response);

            //delGreetingTest
            $expect = true;
            $response = $this -> delGreetingTest();
            $this -> assertSame($expect, $response);

            //addMenuTest
            $menus = array(
                 array(
                     "type" => "postback",
                     "title" => "Help(幫助)",
                     "payload" => "DEVELOPER_DEFINED_PAYLOAD_FOR_HELP"
                 ),
                 array(
                     "type" => "postback",
                     "title" => "About(關於)",
                     "payload" => "DEVELOPER_DEFINED_PAYLOAD_FOR_ABOUT"
                 )
             );
            $expect = true;
            $response = $this -> addMenuTest($menus);
            $this -> assertSame($expect, $response);

            //delMenuTest
            $expect = true;
            $response = $this -> delMenuTest();
            $this -> assertSame($expect, $response);

        }

        public function subscribeTest() {
            $tokens = $this -> getToken();
            if($tokens === false) {
                exit("token.json file not found");
            }

            $builder = new BotBuilder($tokens["token"], $tokens["page_token"]);
            $response = $builder -> subscribe();
            return $response;
        }

        public function addGreetingTest($greetingText) {
            $tokens = $this -> getToken();
            if($tokens === false) {
                exit("token.json file not found");
            }

            $builder = new BotBuilder($tokens["token"], $tokens["page_token"]);
            $response = $builder -> addGreeting();
            return $response;
        }

        public function delGreetingTest() {
            $tokens = $this -> getToken();
            $builder = new BotBuilder($tokens["token"], $tokens["page_token"]);
            $response = $builder -> delGreeting();
            return $response;
        }

        public function addMenuTest($menus) {
            $tokens = $this -> getToken();
            $builder = new BotBuilder($tokens["token"], $tokens["page_token"]);
            $response = $builder -> addMenu($menus);
            return $response;
        }

        public function delMenuTest() {
            $tokens = $this -> getToken();
            $builder = new BotBuilder($tokens["token"], $tokens["page_token"]);
            $response = $builder -> delMenu();
            return $response;
        }

        public function getToken() {
            if(file_exists(__DIR__ . "/token.json")) {
                $tokens = file_get_contents(__DIR__ . "/token.json");
                $tokens = json_decode($tokens, true);
                return $tokens;
            }
            else {
                return false;
            }
        }
    }

?>
