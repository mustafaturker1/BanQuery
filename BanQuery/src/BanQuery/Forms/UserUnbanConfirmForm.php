<?php

namespace BanQuery\Forms;

use BanQuery\BanQuery;
use BanQuery\Text\Text;
use dktapps\pmforms\ModalForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class UserUnbanConfirmForm extends ModalForm{

    /** @var BanQuery */
    private $plugin;

    /** @var string */
    private $user;

    /**
     * UserUnbanConfirmForm constructor.
     * @param BanQuery $plugin
     * @param string $user
     */
    public function __construct(BanQuery $plugin, string $user){
       $this->plugin = $plugin;
       $this->user = $user;

       parent::__construct(
           C::BOLD . C::DARK_GRAY . "Unban - {$user}",
           "Do you confirm to unban the user?",

           function (Player $player, bool $selected): void{
               $mysql = $this->plugin->getMySQL();
               $text = new Text($this->plugin);
               $config = $this->plugin->getConfigData();

                if ($selected){
                    if ($mysql->deleteBanUser($this->user)){
                        $player->sendMessage($text->convertCodeInTheText($config->get("Unban-Successfully-Message"), $player->getName(), $this->user));
                    }
                }
           },
           "Confirm",
           "Refuse"
       );
    }
}
