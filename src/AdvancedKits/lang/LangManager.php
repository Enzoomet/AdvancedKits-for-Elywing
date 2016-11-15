<?php

namespace AdvancedKits\lang;

use AdvancedKits\Main;
use pocketmine\utils\Config;

class LangManager{

    const LANG_VERSION = 0;

    private $ak;
    private $defaults;
    private $data;

    public function __construct(Main $ak){
        $this->ak = $ak;
        $this->defaults = [
            "lang-version" => 0,
            "in-game" => "§7- §cYou must run this command in-game§8.",
            "av-kits" => "§6Kits§7:§a {%0}",
            "no-kit" => "§7- §cThat kit doesn't exist.§8.",
            "reload" => "§7- §aAll kits have been reloaded.",
            "sel-kit" => "Selected kit: {%0}",
            "cant-afford" => "§7- §cSorry, you're kinda broke, you cannot afford§d: §8{%0}",
            "one-per-life" => "§7- §cYou can only get one kit per life.§8.",
            "cooldown1" => "§7- §cThe kit§7:§d {%0} §c is on cool-down for you at the moment.§8.",
            "cooldown2" => "§7- §aYou can get the kit in§8: {%0}",
            "no-perm" => "§7- §cYou must upgrade to a higher rank to get that kit§7: §ahttp://shop.xeon-pe.com",
            "cooldown-format1" => "{%0} minutes.",
            "cooldown-format2" => "{%0} hours and {%1} minutes.",
            "cooldown-format3" => "{%0} hours.",
            "no-sign-on-kit" => "§7- §cERROR§8: §eSIGNKIT",
            "no-perm-sign" => "§7- §cERROR§8: §eSIGNPERM"
        ];
        $this->data = new Config($this->ak->getDataFolder()."lang.properties", Config::PROPERTIES, $this->defaults);
        if($this->data->get("lang-version") != self::LANG_VERSION){
            $this->ak->getLogger()->alert("Translation file is outdated. The old file has been renamed and a new one has been created");
            @rename($this->ak->getDataFolder()."lang.properties", $this->ak->getDataFolder()."lang.properties.old");
            $this->data = new Config($this->ak->getDataFolder()."lang.properties", Config::PROPERTIES, $this->defaults);
        }
    }

    public function getTranslation(string $dataKey, ...$args) : string{
        if(!isset($this->defaults[$dataKey])){
            $this->ak->getLogger()->error("Invalid datakey $dataKey passed to method LangManager::getTranslation()");
            return "";
        }
        $str = $this->data->get($dataKey, $this->defaults[$dataKey]);
        foreach($args as $key => $arg){
            $str = str_replace("{%".$key."}", $arg, $str);
        }
        return $str;
    }

}
