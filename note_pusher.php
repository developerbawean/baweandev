<?php
/**
 * 
 *  app_id = "2022160"
 *  key = "0df1ad36cfb88a17637f"
 *  secret = "2f74ec27f1927a1f3106"
 *  cluster = "ap1"
 */

// library Pusher.php
use Pusher\Pusher as PusherClient;

class Pusher {
    protected $pusher;

    public function __construct() {
        $options = array(
            'cluster' => 'your_cluster',
            'useTLS' => true
        );

        $this->pusher = new PusherClient(
            'your_key', 
            'your_secret', 
            'your_app_id', 
            $options
        );
    }

    public function trigger($channel, $event, $data) {
        return $this->pusher->trigger($channel, $event, $data);
    }
}

// pasang di controller 
$this->pusher->trigger('my-channel', 'my-event', $data);
// 

// //pasang di js
// <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
// var pusher = new Pusher('your_key', {
//     cluster: 'your_cluster'
// });

// var channel = pusher.subscribe('my-channel');
// channel.bind('my-event', function(data) {
//     alert('Received: ' + JSON.stringify(data));
// });
