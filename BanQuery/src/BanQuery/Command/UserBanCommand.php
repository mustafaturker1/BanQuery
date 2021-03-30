<?php

namespace BanQuery\Command;

use BanQuery\BanQuery;
use BanQuery\Forms\BanOptionForm;
use BanQuery\Text\Text;
use pocketmine\command\{PluginCommand, CommandSender};
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class UserBanCommand extends PluginCommand{

    /** @var BanQuery */
    private $plugin;

    /**
     * UserBanCommand constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        parent::__construct("ban", $plugin);
        $this->setDescription("Ban players command!");
        $this->setPermission("ban.command");

        $this->plugin = $plugin;
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $config = $this->plugin->getConfigData();
        $text = new Text($this->plugin);

        if (!$sender instanceof Player){
            return false;
        }
        if (!$sender->hasPermission("ban.command")){
            $sender->sendMessage($text->convertCodeInTheText($config->get("No-Permission-Message"), $sender->getName()));
            return false;
        }
        $sender->sendForm(new BanOptionForm($this->plugin));
        return true;
    }
}
