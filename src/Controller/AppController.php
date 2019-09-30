<?php
// src/Controller/AppController.php

namespace App\Controller;

use App\Entity\user_conversation;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller {

    /**
     * @Route("/", name="login-panel")
     * @Method({"POST"})
     */
    
    public function index(){

    session_start();
    session_unset();
    return $this->render('/pages/loginform.html.twig');
    }

    /**
     * @Route("/user/")
     */


    /**
     * @Route("/user/login")
     */

    public function attempt(){                                                      //attempt to log in to the control panel

        session_start();
        $repository = $this->getDoctrine()->getRepository(User::class);             // Check if the login credentials match any users
        if (isset($_POST['username']))
            $user = $repository->findOneBy(['username' => $_POST['username']]);
        else
            $user = NULL;
        if ($user != NULL)
            if ($_POST['password'] == $user->getPassword() && $_SESSION['captcha'] == $_POST['captcha_code']):                        // Check if the passwords and Captcha match
                $_SESSION['access'] = true;                                         // Sends confirmation to the control panel
                $_SESSION['username'] = $_POST['username'];                         // Sends username to the control panel
                if (file_exists("Logs/authorization_logs.txt")){                    // Check existence of the log file
                    $handler = fopen("Logs/authorization_logs.txt", "r+");          // Open the file and add new entry
                        $file_data = date('l jS \of F Y h:i:s A').' user named "'.$_SESSION['username'].'" logged in with the IP address: '.$_SERVER['REMOTE_ADDR']."\n";
                        $file_data .= file_get_contents("Logs/authorization_logs.txt");
                        if (filesize("Logs/authorization_logs.txt") > 8192)         // Truncate the file if it is too big
                            ftruncate($handler, 1024);
                        file_put_contents("Logs/authorization_logs.txt", $file_data);
                    fclose($handler);}
                else{                                                               // Log file missing, Creating a new one
                    $handler = fopen("Logs/authorization_logs.txt", "a+");          
                    fwrite($handler, "New log file created");
                    fclose($handler);
                    return $this->render('/pages/login-success.html.twig',[          // Informing the client about Log file status
                    'response' => 404,
                    'username' => $_SESSION['username'],
                    ]);          
                }
                return $this->redirectToRoute('control-panel');
            endif;
        return $this->redirectToRoute('login-panel');                               // Access Denied, returning to the login panel
    }
    
    /**
     * @Route("/user/control-panel", name="control-panel")
     */

    public function controlPanel(){
        
        session_start();
        if (isset($_SESSION['access']))             // Security Checks
            if ($_SESSION['access'] == true):       // Security Checks
                $handler = fopen("Logs/authorization_logs.txt", "r+");
                for($i=0;$i<10;$i++){
                    $data_logs[$i] = fgets($handler);
                }
                fclose($handler);
                return $this->render('/pages/login-success.html.twig', [  // Loading Control Panel and passing the log along
                'data_logs_1' => $data_logs[0],
                'data_logs_2' => $data_logs[1],
                'data_logs_3' => $data_logs[2],
                'data_logs_4' => $data_logs[3],
                'data_logs_5' => $data_logs[4],
                'data_logs_6' => $data_logs[5],
                'data_logs_7' => $data_logs[6],
                'data_logs_8' => $data_logs[7],
                'data_logs_9' => $data_logs[8],
                'data_logs_10' => $data_logs[9],
                'response' => 200,
                'username' => $_SESSION['username'],
                ]);
                 
            endif;
        return $this->redirectToRoute('login-panel');                    // Access Denied, returning to the login panel
    }

    /**
     * @Route("/user/control-panel/reply")
     */
    public function sendChatReply(){

        if (isset($_POST)):
            try{
                $error = "POST hasn't been initialized";
                throw new Exception($error);
            }
            catch(Exception $e){
                echo "Caught exception".$e->getMessage();
            }
        else:
        $message = $_POST['reply-content'];
        $receiver = $_POST['receiver_username'];
        $sender = $_POST['sender_username'];

        $entityManager = $this->getDoctrine()->getManager();
        
        $data = new user_conversation();
        $data->setSenderUsername($sender);
        $data->setSenderMessage($message);
        $data->setReceiverUsername($receiver);
        $data->setTime();
        
        $entityManager->persist($data);
        $entityManager->flush();
        endif;
    }


    /**
     * @Route("/user/control-panel/notepad")
     */

    public function notepad(){

        session_start();
        if (isset($_SESSION['access']))
            if ($_SESSION['access'] == true):               // Security Check
                exec(($_SERVER["DOCUMENT_ROOT"].'/public/bin/notepad/notepad/bin/Debug/notepad.exe'));
            endif;
        return $this->redirectToRoute('control-panel');
    }

    /**
    * @Route("/user/control-panel/shutdown")
    */

    public function shutdown(){

        session_start();
        if (isset($_SESSION['access']))
            if ($_SESSION['access'] == true):               // Security Check
                exec(($_SERVER["DOCUMENT_ROOT"].'/public/bin/shutdown/shutdown/bin/Debug/shutdown.exe'));
            endif;
        return $this->redirectToRoute('control-panel');
    }

    /**
     * @Route("/user/control-panel/logout")
     */

    public function logout(){

        session_start();
        if (isset($_SESSION['access']))
            if ($_SESSION['access'] == true):               // Security check
                if (file_exists("Logs/authorization_logs.txt")){                   // Check if file exists
                    $handler = fopen("Logs/authorization_logs.txt", "r+");         // Adding Log entry to the File
                    $file_data = date('l jS \of F Y h:i:s A').' user named "'.$_SESSION['username'].'" logged out with the IP address: '.$_SERVER['REMOTE_ADDR']."\n";
                    $file_data .= file_get_contents("Logs/authorization_logs.txt");
                    if (filesize("Logs/authorization_logs.txt") > 8192)
                        ftruncate($handler, 1024);
                    file_put_contents("Logs/authorization_logs.txt", $file_data);
                    fclose($handler);
                }
                unset($_SESSION['access']);
                unset($_SESSION['username']);
            endif;
        return $this->redirectToRoute('login-panel');
    }

    // /**
    //  * @Route("/test/new")
    //  */

    //  public function display(){             // Development Test Function

    //     return $this->render('pages/login-success.html.twig');
    //  }

    // /**
    //  * @Route("/users/new")
    //  */
    // public function create(){
    //     $entityManager = $this->getDoctrine()->getManager();

    //     $user = new User();
    //     $user->setUsername("admin");
    //     $user->setPassword("admin");

    //     $entityManager->persist($user);

    //     $entityManager->flush();

    //     return new Response('Created a new user with an id of '.$user->getId());

    // }

}


?>