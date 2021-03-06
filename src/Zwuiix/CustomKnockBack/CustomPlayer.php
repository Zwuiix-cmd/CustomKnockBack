<?php

namespace Zwuiix\CustomKnockBack;

use pocketmine\entity\Attribute;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Player;
use pocketmine\utils\Config;

class CustomPlayer extends Player {

    /**
     * @param Entity $attacker
     * @param float $damage
     * @param float $x
     * @param float $z
     * @param float $base
     */
    public function knockBack(Entity $attacker, float $damage, float $x, float $z, float $base = 0.4): void {
        if ($attacker instanceof self) {
            $f = sqrt($x * $x + $z * $z);

            if ($f <= 0){
                return;
            }

            $config=new Config(Main::getInstance()->getDataFolder() . "knocback.yml", Config::YAML);
            $knockbackx=$config->get("knockback-x");
            $knockbacky=$config->get("default-y");
            $knockbackz=$config->get("default-z");

            if (mt_rand() / mt_getrandmax() > $this->getAttributeMap()->getAttribute(Attribute::KNOCKBACK_RESISTANCE)->getValue()){
                $f = 1 / $f;

                $motion = clone $this->motion;

                $motion->x /= 2;
                $motion->y /= 2;
                $motion->z /= 2;
                $motion->x += $x * $f * $base * $knockbackx;
                $motion->y += $base * $knockbacky;
                $motion->z += $z * $f * $base * $knockbackz;

                if ($motion->y > $base){
                    $motion->y = $base;
                }

                $this->setMotion($motion);
            }
            return;
        }
        parent::knockBack($attacker, $damage, $x, $z, $base);
    }

    public function attack(EntityDamageEvent $source) : void {
        parent::attack($source);

        if ($source->isCancelled()) {
            return;
        }

        $config = new Config(Main::getInstance()->getDataFolder() . "knocback.yml", Config::YAML);
        $attackSpeed = $config->get("attackcooldown");

        if ($attackSpeed < 0) {
        $attackSpeed = 0;
        } $this->attackTime = $attackSpeed;
    }
}