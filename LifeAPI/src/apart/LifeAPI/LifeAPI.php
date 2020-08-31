<?php
namespace apart\LifeAPI;

use apart\LifeAPI\Form\moneyForm;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\form\Form;
use pocketmine\utils\Config;

class LifeAPI extends PluginBase implements Listener
{
	private static $instance;
	private $money;
	private $setting;
	public function onEnable()
	{
		$this->getLogger()->info("[LIFEAPI]LifeAPIを読み込みました。");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->setting = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
			"startmoney" => "1000",
			"language" => "japan",
		));
		$this->money = new Config($this->getDataFolder() . "money.yml", Config::YAML);
	}
	public function onLoad()
	{
		self::$instance = $this;
	}

	public function onjoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		$name = $player->getName();

		$startmoney = $this->setting->get("startmoney");
		if (!$this->money->exists($name))
		{
			$this->money->set($name,$startmoney);
			$this->money->save();
			$this->money->reload();
		}


	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool
	{
		$name = $sender->getName();
		switch ($label)
		{
			case 'money':
				$sender->sendForm(new moneyForm($this->money));
				return true;
				break;

			case 'mymoneys':
				$mymoney = $this->money->get($name);
				$sender->sendMessage("$mymoney 円もってるお");
				return true;
				break;
		}
		return true;

	}
	public static function getInstance()
	{
		return self::$instance;
	}

	public  function addmoney($name,$money)
	{
		$mymoney = $this->money->get($name);
		$addmoney = floor($money);
		$this->money->set($name,$mymoney + $addmoney);
		$this->money->save();
		$this->money->reload();
	}

	public function removemoney($name,$money)
	{
		$mymoney = $this->money->get($name);
		$removemoney = floor($money);
		if ($mymoney >= $removemoney)
		{
			$this->money->set($name,$mymoney - $removemoney);
			$this->money->save();
			$this->money->reload();
		}
	}
	public function mymoney($name)
	{
		return $this->money->get($name);
	}

	public function onDisable()
	{
		$this->setting->save();
		$this->money->save();
	}
}
