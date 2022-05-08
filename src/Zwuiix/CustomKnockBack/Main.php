<?php

namespace Zwuiix\CustomKnockBack;

use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerCreationEvent;

class Main extends PluginBase implements Listener {

    private static $instance;

    public function onEnable() {
        @mkdir($this->getDataFolder());
        if (!file_exists($this->getDataFolder()."knockback.yml")) {
            $this->saveResource('knockback.yml');
        }
        self::$instance = $this;
        $this->getServer()->getCommandMap()->registerAll('Zwuiix', [new Knockback('knockback', "Permet de modifier les kbs", "/knockback", ["customkb"])]);
    }
    public static function getInstance() : Main {
        return self::$instance;
    }
    public function onPlayer(PlayerCreationEvent $event) : void {
        $event->setPlayerClass(CustomPlayer::class);
    }
}