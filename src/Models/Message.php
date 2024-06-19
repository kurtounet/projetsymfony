<?php

namespace App\Models;




class Message
{
    private ?int $id = null;





    private ?string $queue_name = null;


    private ?\DateTimeInterface $created_at = null;


    private ?\DateTimeImmutable $available_at = null;


    private ?\DateTimeImmutable $delivered_at = null;


    private ?string $body = null;


    private ?string $headers = null;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getQueueName(): ?string
    {
        return $this->queue_name;
    }

    public function setQueueName(string $queue_name): static
    {
        $this->queue_name = $queue_name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAvailableAt(): ?\DateTimeImmutable
    {
        return $this->available_at;
    }

    public function setAvailableAt(\DateTimeImmutable $available_at): static
    {
        $this->available_at = $available_at;

        return $this;
    }

    public function getDeliveredAt(): ?\DateTimeImmutable
    {
        return $this->delivered_at;
    }

    public function setDeliveredAt(?\DateTimeImmutable $delivered_at): static
    {
        $this->delivered_at = $delivered_at;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getHeaders(): ?string
    {
        return $this->headers;
    }

    public function setHeaders(string $headers): static
    {
        $this->headers = $headers;

        return $this;
    }
}
