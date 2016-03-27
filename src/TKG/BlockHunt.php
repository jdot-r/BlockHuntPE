<?php

namespace TKG;

use pocketmine\listener\EventListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class BlockHunt extends PluginBase {

    public $prefix = TF::BLACK."[ ".TF::AQUA."Block".TF::GOLD."Hunt".TF::BLACK." ] ";
    public $arenas;
    public $mysqlmgr;
    public $listener;
    public $cfg;
    public $msg;
    
    public function onLoad(){
        $this->checkFiles();
        $this->getLogger()->notice($this->prefix.TF::GRAY."Initiating language...");
        $this->initLangugage();
        $this->getLogger()->info($this->prefix.TF::YELLOW.$this->getMsg("listener"));
        $this->listener = new EventListener($this);
        $this->getServer()->getPluginManager()->registerEvents($this->listener, $this);
        $this->getLogger()->info($this->prefix.TF::GREEN.$this->getMsg("listener_true"));
        $this->createMySQLConnection();
        //$this->registerArenas();
    }
    
    public function checkFiles(){
        if (!file_exists($this->getDataFolder())){
            @mkdir($this->getDataFolder(), 0777);
        }
        if (!file_exists($this->getDataFolder()."config.yml") or \yaml_parse($this->getDataFolder()."config.yml")["version"] !== 1){
            $this->saveResource("config.yml", true);
            $this->cfg = new Config($this->getDataFolder()."config.yml", Config::YAML);
        }
        if (!\file_exists($this->getDataFolder()."arena/") or \scandir($this->getDataFolder()."arena/") === false){
            @mkdir($this->getDataFolder()."arena/", 0777);
            $this->saveResource("default.yml", true);
        }
        if (!\file_exists($this->getDataFolder().$this->cfg->get("language").".yml") or \yaml_parse($this->getDataFolder().$this->cfg->get("language").".yml")["lang"] != $this->cfg->get("language")){
            $this->saveResource($this->cfg->get("language").".yml", true);
        }
    } 
    
    public function initLanguage(){
        $this->msg = new Config($this->getDataFolder().$this->cfg->get("language").".yml", Config::YAML);
        $this->getLogger()->info($this->prefix.$this->getMsg("init"));
    }
    
    public function createMySQLConnection(){
        $this->mysqlmgr = new MySQLManager($this);
        $mysql = $this->cfg->get("mysql");
        $this->mysqlmgr->createMySQLConnection($mysql["host"], $mysql["user"], $mysql["pass"], $mysql["database"], $mysql["port"]);
    }
    
    /*public function registerArenas(){
        foreach (\scandir($this->getDataFolder()."arena/") as $i => $name){
                $temp = [$i+1 => new Config($this->getDataFolder()."arena/".$name, Config::YAML)]
            }
    }*/
    
    public function getMsg($key){
        return \str_replace("&", TF::ESCAPE, $this->msg->get($key));
    }
    
}
