<?php
namespace tcp_extension;
/**
 * Class ServerData
 *
 * @author  vyuziuk <vlad8yuziuk@gmail.com> <Telegram:@vyuziuk>
 * @version 1.0.0
 * @since   1.0.0
 */
class ServerData{
    public $ip;
    public $port;
    public $online;
    public $maxOnline;
    public $type;
    public $name;

    public function __construct(string $name = "", string $type = "", int $maxOnline = 0, int $online = 0, int $port = 19132, string $ip = "127.0.0.1"){
        $this->ip = $ip;
        $this->port = $port;
        $this->online = $online;
        $this->maxOnline = $maxOnline;
        $this->type = $type;
        $this->name = $name;
    }

    public function pack(): string{
        return sprintf("%s:%s:%s:%d:%d:%d", $this->name, $this->type, $this->ip, $this->port, $this->online, $this->maxOnline);
    }

    public function unpack(string $data): ServerData{
        $data = explode(":", $data);
        if(count($data) !== 6){
            throw new InvalidArgumentException(sprintf("Invalid data provided: %s", implode(":", $data)));
        }

        $this->name = $data[0];
        $this->type = $data[1];
        $this->ip = $data[2];
        $this->port = $data[3];
        $this->online = $data[4];
        $this->maxOnline = $data[5];
        return $this;
    }
}