<?php

namespace App\Classes;


class ResponseStruct
{
    private Array $result;
    private String $status;
    private String $typeMessage;
    private Array $messages;

    public function __construct(
        Array $result = [],
        String $status = 'success',
        string $typeMessage = 'success',
        Array $messages = []
    ) {
        $this->result = $result;
        $this->status = $status;
        $this->typeMessage = $typeMessage;
        $this->messages = $messages;
    }

    public function setResponse(
        Array $result = [],
        String $status = 'success',
        string $typeMessage = 'success',
        Array $messages = []
    ) {
        $this->result = $result;
        $this->status = $status;
        $this->typeMessage = $typeMessage;
        $this->messages = $messages;
    }

    public function getResult() {
        return $this->result;
    }

    public function setResult(Array $result) {
        $this->result = $result;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus(String $status) {
        $this->status = $status;
    }

    public function getTypeMessage() {
        return $this->typeMessage;
    }

    public function setTypeMessage(String $typeMessage) {
        $this->typeMessage = $typeMessage;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function setMessages(Array $messages) {
        $this->messages = $messages;
    }

    public function addMessages(String $messages) {
        $this->messages[] = $messages;
    }

    public function returnStruct()
    {
        $response = new \stdClass();
        $response->result = $this->result;
        $response->status = $this->status;
        $response->typeMessage = $this->typeMessage;
        $response->messages = $this->messages;

        return $response;
    }
}
