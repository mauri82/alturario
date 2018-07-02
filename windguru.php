<?php
$salida='{
    "fulfillmentText": "Windguru Rosario",
    "fulfillmentMessages": [
      {
        "card": {
          "title": "Windguru",
          "subtitle": "Rosario",
          "imageUri": "http://old.windguru.cz/images/windguru_final2-huri.png",
          "buttons": [
            {
              "text": "Ver",
              "postback": "http://old.windguru.cz/int/mview.php?s=643563&m=3"
            }
          ]
        }
      }
    ]
  }';
print $salida;
?>