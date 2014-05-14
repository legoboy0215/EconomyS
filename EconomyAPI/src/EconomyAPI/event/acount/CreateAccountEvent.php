<?php

namespace EconomyAPI\event\account;

use EconomyAPI\event\EconomyAPIEvent;

class CreateAccountEvent extends EconomyAPIEvent{
	private $player, $username, $defaultMoney, $defaultDebt, $defaultBankMoney, $issuer;
	public static $handlerList;
	
	public function __construct(\EconomyAPI\EconomyAPI $plugin, $username, $defaultMoney, $defaultDebt, $defaultBankMoney, $issuer){
		$this->plugin = $plugin;
		$this->username = $username;
		$this->defaultMoney = $defaultMoney;
		$this->defaultBankMoney = $defaultBankMoney;
		$this->issuer = $issuer;
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function getDefaultMoney(){
		return $this->defaultMoney;
	}
	
	public function getDefaultBankMoney(){
		return $this->defaultBankMoney;
	}
	
	public function getDefaultDebt(){
		return $this->defaultDebt;
	}
}