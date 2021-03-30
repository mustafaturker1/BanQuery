<?php

namespace BanQuery\Listener;

use BanQuery\BanQuery;
use BanQuery\Text\Text;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;

class BanQueryListener implements Listener{

    /** @var BanQuery */
    private $plugin;

    /**
     * BanQueryListener constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerPreLoginEvent $event
     * @return bool
     */
    public function playerLoginEvent(PlayerPreLoginEvent $event){
        $player = $event->getPlayer();
        $mysql = $this->plugin->getMySQL();
        $text = new Text($this->plugin);
        $config = $this->plugin->getConfigData();
        $isBanned = $mysql->isBanned($player->getName());

        if ($isBanned){
            $info = $mysql->listBanUser($player->getName());

            if ($info['ban_status'] != 1){
                if ($info['unban_time']){
                    if (date("Y-m-d H:i:s") == $info['unban_time']){
                        $mysql->deleteBanUser($player->getName());
                        return true;
                    }else{
                        $player->kick($text->convertCodeInTheText($config->get("Ban-Kick-Message"), $info['ban_admin'], $info['ban_reason']), false);
                        return false;
                    }
                }
            }else{
                $player->kick($text->convertCodeInTheText($config->get("Ban-Kick-Message"), $info['ban_admin'], $info['ban_reason']), false);
                return false;
            }
        }
        return true;
    }
}