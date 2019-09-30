<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\user_conversation;

class chat_manager {

    public function __construct($action){
        print_r("constructor initialized");
        if ($action == "send")
            $this->sendChatReply($_POST['sender'],$_POST['message'],$_POST['receiver']);
        else if ($action == "read")
            $this->readChatReply($_POST['sender'],$_POST['receiver']);
        else
            die("ERROR: Could not understand action: ".$action);
    }

    // public function sendChatReply($sender, $receiver, $message){
        
    //     $response = new JsonResponse([
    //         "sender"   => $sender,
    //         "receiver" => $receiver,
    //         "message"  => $message,
    //         "date"     => time()
    //         ]);
    //     $response->send();

    // }

    public function sendChatReply($sender, $message, $receiver){
        
        // Open Connection to the database          WORKS
        echo "sendChatReply initialized";
        $link = mysqli_connect("localhost", "Jerry", "123", "passproject");
        if ($link === false)
            die("ERROR: could not connect to the database. ".mysqli_connect_error());

        $sql = "INSERT INTO passproject.user_conversation (sender_username, sender_message, receiver_username, message_time) VALUES ('$sender', '$message', '$receiver',now())";

        if(mysqli_query($link, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: were not able to execute. $sql. " . mysqli_error($link);
        }
            
        // Close connection
        mysqli_close($link);

        $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        $response->send();

    }

    public function readchatReply($sender, $receiver){

        $link = mysqli_connect("localhost", "Jerry", "123", "passproject");
        if ($link === false)
            die("ERROR: could not connect to the database. ".mysqli_connect_error());
        $sql = "SELECT * FROM user_conversation WHERE sender_username=$sender AND receiver_username=$receiver";
    
    }

}
// If condition to check whether to save or read from the server
// echo '<script>';
// echo 'alert("the script has started");';
// echo '</script>';
// if (!empty($params)):
//     echo '<script>';
//     echo 'console.log('. json_encode( "params was not empty" ) .')';
//     echo '</script>';
// else: 
//     echo '<script>';
//     echo 'console.log('. json_encode( "params was empty" ) .')';
//     echo '</script>';
// endif;
// if (!empty($_REQUEST['action'])):
//     $new_row = new chat_manager($_POST['action']);
//     sendChatReply($_POST['sender'],$_POST['message'],$_POST['receiver']);
//     echo '<script>';
//     echo 'console.log('. json_encode( "POST was not empty" ) .')';
//     echo '</script>';
// else:
//     echo '<script>';
//     echo 'console.log('. json_encode( "POST was empty" ) .')';
//     echo '</script>';
// endif;
    
// $new_row->sendChatReply("messaging user","receiving user","random-content");

?>