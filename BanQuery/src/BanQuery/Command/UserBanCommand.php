<?php

namespace BanQuery\Command;

use BanQuery\BanQuery;
use BanQuery\Forms\BanOptionForm;
use pocketmine\command\{PluginCommand, CommandSender};
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class UserBanCommand extends PluginCommand
{

    public function __construct(BanQuery $plugin)
    {
        parent::__construct("ban", $plugin);
        $this->setDescription("Ban players command!");
        $this->setPermission("ban.command");
    }

    /**
     * @var CommandSender $sender
     * @var string $commandLabel
     * @var array $args
     * @return bool|mixed
     */

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player){
            return false;
        }
        if (!$sender->hasPermission("ban.command")){
            $sender->sendMessage(TextFormat::RED . "You have not permission!");
            return false;
        }
        $sender->sendForm(new BanOptionForm());
        return true;
    }
}