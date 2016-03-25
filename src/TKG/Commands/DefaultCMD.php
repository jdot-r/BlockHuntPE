<?php
namespace TKG\Commands;

use pocketmine\Player;
use pocketmine\command\Command;
use TKG\Managers\MessageM;

class DefaultCMD {
	
	public execute(Player $player, Command $cmd, $label, $args) {
		MessageM.sendMessage($player, "%TAG%NExample of a Command!");
		// TODO Place the command stuff here.
		return true;
	}
}
?>