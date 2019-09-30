<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\user_conversationRepository")
 */
class user_conversation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $sender_username;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $sender_message;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $receiver_username;

    /**
     * @ORM\Column(type="datetime", length=6)
     */
    private $message_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    // Sender Username

    public function getSenderUsername(): ?string
    {
        return $this->sender_username;
    }

    public function setSenderUsername(string $sender_username): self
    {
        $this->sender_username = $sender_username;

        return $this;
    }

    //  Sender Message

    public function getSenderMessage(): ?string
    {
        return $this->sender_message;
    }

    public function setSenderMessage(string $sender_message): self
    {
        $this->sender_message = $sender_message;

        return $this;
    }

    // Receiver Username

    public function getReceiverUsername(): ?string
    {
        return $this->receiver_username;
    }

    public function setReceiverUsername(string $receiver_username): self
    {
        $this->receiver_username = $receiver_username;

        return $this;
    }

    // Time of the message

    public function getTime(): ?string
    {
        return $this->message_time;
    }

    public function setTime(): self
    {
        $this->message_time = date("Y-m-d H:i:s"); //getdate();

        return $this;
    }
}
