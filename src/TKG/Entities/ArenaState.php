<?php
namespace TKG\Entities;

use TKG\Entities\Enum;

class ArenaState extends Enum
{
	 const __default = 0;
	 const DISABLED = 1;
	 const WAITING = 2;
	 const STARTING = 3;
	 const INGAME = 4;
	 const RESTARTING = 5;
}
?>