<?php

/*
__PocketMine Plugin__
name=AutoSpawn
description=
version=
author=KoMC
class=AutoSpawn
apiversion=11,12,13
*/


class MilkRPG implements Plugin{
	private $api;
	private $server;
	public function __construct(ServerAPI $api, $server = false){
		$this->api = $api;
		$this->spawn = 0;
		$this->server = ServerAPI::request();
	}
	public function __destruct(){}
	public function init(){
		$this->api->addHandler("entity.death", array($this, "han"));
		$this->api->schedule(10, array($this, "han"), array(), true, "Monster.spawn");
	}
	
	public function han($data, $event){
		switch($event){
			case "Monster.Spawn":
				foreach($this->api->player->getAll() as $play){
					if(!$play->spawned)continue;
					//준비중
				}
				break;
			case "entity.death":
				break;
		}
	}
}
