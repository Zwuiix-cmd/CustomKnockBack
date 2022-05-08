<?php

namespace Zwuiix\CustomKnockBack\Commands;

use Zwuiix\CustomKnockBack\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;

class Knockback extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []) {

        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("knockback");

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)){
			return true;
		}
        if(!isset($args[0]) or !isset($args[1]) or !isset($args[2] or !isset($args[3]))) {
            return $sender->sendMessage("§cUsage: knockback (x) (y) (z) (cooldown)");
        }
        if(ctype_alnum($args[0]) == false or ctype_alnum($args[1]) == false or ctype_alnum($args[2]) == false or ctype_alnum($args[3]) == false) {
            return $sender->sendMessage("§cUsage: knockback (x) (y) (z) (cooldown)");
        }
        # OLD SAVE
        $config=new Config(Main::getInstance()->getDataFolder() . "knocback.yml", Config::YAML);
        $config->set("old-knockback-x", $config->get("knockback-x"));
        $config->set("old-knockback-y", $config->get("knockback-y"));
        $config->set("old-knockback-z", $config->get("knockback-z"));
        $config->set("old-attack-cooldown", $config->get("attack-cooldown"));

        # NEW SAVE
        $config->set("knockback-x", $args[0]);
        $config->set("knockback-y", $args[1]);
        $config->set("knockback-z", $args[2]);
        $config->set("attack-cooldown", $args[3]);
        $config->save(); # SAVE

        # MESSAGE
        $sender->sendMessage("§aKnockback changern, x: {$args[0]} y: {$args[1]} z: {$args[2]} cooldown: {$args[3]}");
        $sender->sendMessage("§7(Nous avons aussi sauvegarder les anciens knockback dans la config !");
        return true;
    }
}