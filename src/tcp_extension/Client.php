<?php
namespace tcp_extension;
/**
 * Class Client
 *
 * @author  vyuziuk <vlad8yuziuk@gmail.com> <Telegram:@vyuziuk>
 * @version 1.0.0
 * @since   1.0.0
 */
class Client{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var resource|false
     */
    private $sock;

    /**
     * Client constructor.
     *
     * @param string $host
     * @param int $port
     * @param string $secret
     */
    public function __construct(string $host, int $port, string $secret){
        $this->host = $host;
        $this->port = $port;
        $this->secret = $secret;
    }

    public function run(ServerData $serverData): ?array{
        $this->sock = fsockopen($this->host, $this->port);

        $this->write($serverData->pack());

        $data = $this->read();
        if(is_null($data)){
            return null;
        }

        $result = [];
        $arr = explode(':', $data);
        foreach($arr as $dat){
            if($dat === ""){
                continue;
            }

            $dat = (new ServerData())->unpack($data);
            $result[$dat->name] = $dat;
        }

        return $result;
    }

    /**
     * @param string $data
     */
    private function write(string $data){
        fwrite($this->sock, $data);
    }

    /**
     * @return string
     */
    private function read(): ?string{
        if(!is_resource($this->sock)){
            return null;
        }

        $buf = fread($this->sock, 4096);
        $buf = str_replace("\n", "", $buf);

        return $buf;
    }
}