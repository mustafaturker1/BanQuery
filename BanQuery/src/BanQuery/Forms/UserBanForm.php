<?php

namespace BanQuery\Forms;

use BanQuery\BanQuery;
use BanQuery\Text\Text;
use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Dropdown;
use dktapps\pmforms\element\Input;
use dktapps\pmforms\element\Label;
use dktapps\pmforms\element\Toggle;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class UserBanForm extends CustomForm{

    /** @var BanQuery */
    private $plugin;

    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;

        parent::__construct(
            C::BOLD . C::DARK_GRAY . "Ban",

            [
                new Label("element0", "\n"),
                new Dropdown("element1", "Players:", $this->getAllPlayers()),
                new Toggle("element2", "Unlimited ban", false),
                new Input("element3", "Reason:", "Fly, Hack..."),
                new Input("element4", "Time (Day):", "5, 10, 30...")
            ],

            function (Player $player, CustomFormResponse $response): void{
                $dropdown = $this->getElement(1)->getOption($response->getInt("element1"));
                $toggle = $response->getBool("element2");
                $reason = $response->getString("element3");
                $day = $response->getString("element4");
                $mysql = $this->plugin->getMySQL();
                $text = new Text($this->plugin);
                $config = $this->plugin->getConfigData();
                $enum = null;

                if ($dropdown == $player->getName()){
                    $player->sendMessage($text->convertCodeInTheText($config->get("Player-Same-User-Message"), $player->getName()));
                    return;
                }
                if ($toggle){
                    $enum = true;
                }else{
                    $enum = false;
                }
                if ($enum){
                    $day = 0;
                }else{
                    if (!is_numeric($day)){
                        $player->sendMessage($text->convertCodeInTheText($config->get("Non-Numeric-Day-Message"), $player->getName()));
                        return;
                    }
                    if (strstr($day, "-")){
                        $player->sendMessage($text->convertCodeInTheText($config->get("Negative-Numeric-Day-Message"), $player->getName()));
                        return;
                    }
                }
                if ($mysql->addBanUser($player->getName(), $dropdown, $reason, $day, $enum)){
                    $player->sendMessage($text->convertCodeInTheText($config->get("Ban-Successfully-Message"), $player->getName(), $reason, $dropdown));
                }
                if ($config->get("Ban-Broadcast") == true){
                    $this->plugin->getServer()->broadcastMessage($text->convertCodeInTheText($config->get("Ban-Broadcast-Message"), $player->getName(), $reason, $dropdown));
                }
                $info = $mysql->listBanUser($player->getName());
                $banned = $this->plugin->getServer()->getPlayerExact($dropdown);
                $banned->kick($text->convertCodeInTheText($config->get("Ban-Kick-Message"), $info['ban_admin'], $info['ban_reason']), false);
            }
        );
    }

    /**
     * @return array
     */
    public function getAllPlayers(): array{
        $array = [];

        foreach ($this->plugin->getServer()->getOnlinePlayers() as $players){
            $array = [$players->getName()];
        }
        return $array;
    }
}
