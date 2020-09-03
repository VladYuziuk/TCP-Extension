<?php

namespace tcp_extension;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;

class Main extends PluginBase{
    protected function onEnable(){
        $this->getScheduler()->scheduleRepeatingTask(new class($this) extends Task{
            private $plugin;

            public function __construct(Main $plugin){
                $this->plugin = $plugin;
            }

            public function onRun(): void{
                $client = new Client("10.223.124.252", 4002, "password");
                $info = ["prison", "main", count($this->plugin->getServer()->getOnlinePlayers()), 100, $this->plugin->getServer()->getPort(), "10.223.124.252"];
                $client->run(new ServerData(...$info));
            }
        }, 20 * 10);
    }
}