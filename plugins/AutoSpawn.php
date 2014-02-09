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
				foreach($this->api->level->getAll as $level){
					if($this->api->time->getPhase($level) == "night"){//밤일시에 몬스터 스폰
						if($this->spawn <= 25 and mt_rand(0,5) == mt_rand(0,5)){
							$mobrand = mt_rand(32,36);
							$data = array(
								"x" => mt_rand(0,25580)/100,
								"y" => mt_rand(64,100),//이부분은 현재 베타
								"z" => mt_rand(0,25580)/100,
							);
							$this->spawn++;
							$e = $this->api->entity->add($this->api->level->getDefault(), ENTITY_MOB, $mobrand, $data);
							$this->api->entity->spawnToAll($e);
						}
					}
					if($this->spawn <= 25 and mt_rand(0,5) == mt_rand(0,5)){
						$mobrand = mt_rand(10,13);
						$data = array(
							"x" => mt_rand(0,25580)/100,
							"y" => mt_rand(64,100),//이부분은 현재 베타
							"z" => mt_rand(0,25580)/100,
						);
						$this->spawn++;
						$e = $this->api->entity->add($this->api->level->getDefault(), ENTITY_MOB, $mobrand, $data);
						$this->api->entity->spawnToAll($e);
					}
				break;
			case "entity.death":
				$this->spawn--;
				break;
		}
	}
}
