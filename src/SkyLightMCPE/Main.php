<?php
namespace SkyLightMCPE;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
class Main extends PluginBase implements Listener{
    
    public $iswildin = [];
    
    public function onEnable(){
              $this->getServer()->getPluginManager()->registerEvents($this, $this);
              $this->getLogger()->info(TF::GREEN . "wild enabled");
    }
    public function onDisable(){
              $this->getLogger()->info(TF::RED . "wild disabled");
    }
    
    public function onCommand(CommandSender $s, Command $cmd, string $label, array $args) : bool{
    if(strtolower($cmd->getName() == "wild")){
        if($s instanceof Player){
            $x = rand(1,999);
            $y = 128;
            $z = rand(1,999);
	    $level = Server::getInstance()->getLevelByName('world');
            $s->teleport($s->getLevel()->getSafeSpawn(new Vector3($x, $y, $z, $level)));
            $s->addTitle(TF::AQUA . "§c§lTeleporting...");
	    $s->sendMessage(TF::AQUA . "§dyou have teleported to a random spot");
            $this->iswildin[$s->getName()] = true;
        
        }
        }else{
            $s->sendMessage(TF::RED."You dont have permission");
        }
        return true;
    } 
    public function onDamage(EntityDamageEvent $event){
       if($event->getEntity() instanceof Player){
           if(isset($this->iswildin[$event->getEntity()->getName()])){
               $p = $event->getEntity();
               unset($this->iswildin[$p->getName()]);
                     $event->setCancelled();
           }
       }
    }
}
