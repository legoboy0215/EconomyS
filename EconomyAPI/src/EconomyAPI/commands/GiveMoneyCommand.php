<?php

namespace EconomyAPI\commands;

use pocketmine\Player;

class GiveMoneyCommand extends EconomyAPICommand{
	private $plugin, $cmd;
	
	public function __construct(\EconomyAPI\EconomyAPI $api, $cmd = "givemoney"){
		parent::__construct($cmd, $api);
		$this->cmd = $cmd;
		$this->setUsage("/$cmd <player> <amount>");
		$this->setDescription("Gives money to player");
		$this->setPermission("economyapi.command.givemoney");
	}
	
	public function execute(\pocketmine\command\CommandSender $sender, $label, array $args){
		$plugin = $this->getPlugin();
		if(!$plugin->isEnabled()){
			return false;
		}
		if(!$this->testPermission($sender)){
			return false;
		}
		
		$player = array_shift($args);
		$amount = array_shift($args);
		
		if(trim($player) === "" or trim($amount) === "" or !is_numeric($amount)){
			$sender->sendMessage("Usage: /".$this->cmd." <player> <amount>");
			return true;
		}
		
		if($amount <= 0){
			$sender->sendMessage($plugin->getMessage("givemoney-invalid-number", $sender->getName()));
			return true;
		}
		
		$p = \pocketmine\Server::getInstance()->matchPlayer($player);
		if($p instanceof Player){
			$player = $player->username;
		}
		
		$result = $plugin->addMoney($player, $amount);
		$output = "";
		switch($result){
			case -2: // CANCELLED
			$output .= "Your request have been cancelled";
			break;
			case -1: // NOT_FOUND
			$output .= $plugin->getMessage("player-never-connected", $sender->getName(), array($player, "%2", "%3", "%4"));
			break;
			// INVALID is already processed
			case 1: // SUCCESS
			$output .= $plugin->getMessage("givemoney-gave-money", $sender->getName(), array($amount, $player, "%3", "%4"));
			if($p instanceof Player){
				$p->sendMessage($plugin->getMessage("givemoney-money-given", $sender->getName(), array($amount, "%2", "%3", "%4")));
			}
			break;
		}
		$sender->sendMessage($output);
		return true;
	}
}