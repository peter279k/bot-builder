<?php
	echo json_encode(array(
        	 "attachment" => array(
              		"type" => "image",
                            "payload" => json_encode('{}')
                        )
        ));
	echo "\n";
	echo json_encode('{"attachment":{"type":"audio", "payload":{}}}');
?>

