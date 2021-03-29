<?php

namespace BanQuery;

use BanQuery\Provider\MySQL;
use BanQuery\Command\UserBanCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class BanQuery extends PluginBase{

    /** @var Config */
    private $config;

    private $mysql;

    public function onEnable(){
        $this->getLogger()->info("Plugin Enable - ByAlperenS & MustafaTurker1");
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->mysql = new MySQL($this);
        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->unregister($commandMap->getCommand("ban"));
        $commandMap->unregister($commandMap->getCommand("unban"));
        $commandMap->unregister($commandMap->getCommand("ban-ip"));
        $commandMap->unregister($commandMap->getCommand("banlist"));
        $commandMap->register("ban", new UserBanCommand($this));
    }

    /**
     * @return Config|null
     */
    public function getConfigData(): ?Config{
        return $this->config;
    }

    /**
     * @return MySQL
     */
    public function getMySQL(): MySQL{
        return $this->mysql;
    }
}
