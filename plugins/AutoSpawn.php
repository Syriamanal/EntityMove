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
		$this->spawn = 0;
		$this->api = $api;
		$this->server = ServerAPI::request();
	}
	public function __destruct(){}
	public function init(){
		$this->api->addHandler("entity.death", array($this, "han"));
		$this->conf = new Config($this->api->plugin->configPath($this)."config.yml",CONFIG_YAML, array(
			"Spawn time" => 15,//20이 1초
			"Maximum number of monsters" => 25,
		));
		$this->api->schedule($this->conf->get("Maximum number of monsters spawning time"), array($this, "han"), array(), true, "Monster.spawn");
	}
	
	public function han($data, $event){
		switch($event){
			case "Monster.Spawn":
				foreach($this->api->level->getAll() as $level){
					if($this->api->time->getPhase($level) == "night"){//밤일시에 몬스터 스폰
						if($this->spawn < $this->conf->get("Maximum number of monsters")){
							$mobrand = mt_rand(32,36);
							$data = array(
								"x" => mt_rand(0,25580)/100,
								"y" => mt_rand(50,127),
								"z" => mt_rand(0,25580)/100,
							);
							$block = $level->getBlock(new Vector3($data["x"],$data["y"],$data["z"]));
							$blockd = $level->getBlock(new Vector3($data["x"],$data["y"]-1,$data["z"]));
							if(($block->getID() == 0 or !$block->isFullBlock)
							and $blockd->getID() != 0 and $blockd->isFullBlock){
								$this->spawn++;
								$e = $this->api->entity->add($level, ENTITY_MOB, $mobrand, $data);
								$this->api->entity->spawnToAll($e);
							}
						}
					}
					if($this->spawn < $this->conf->get("Maximum number of monsters")){
						$mobrand = mt_rand(10,13);
						$data = array(
							"x" => mt_rand(0,25580)/100,
							"y" => mt_rand(50,127),
							"z" => mt_rand(0,25580)/100,
						);
						$block = $level->getBlock(new Vector3($data["x"],$data["y"],$data["z"]));
						$blockd = $level->getBlock(new Vector3($data["x"],$data["y"]-1,$data["z"]));
						if(($block->getID() == 0 or !$block->isFullBlock)
						and $blockd->getID() != 0 and $blockd->isFullBlock){
							$this->spawn++;
							$e = $this->api->entity->add($level, ENTITY_MOB, $mobrand, $data);
							$this->api->entity->spawnToAll($e);
						}
					}
				}
				break;
			case "entity.death":
				$this->spawn--;
				break;
		}
	}
}
