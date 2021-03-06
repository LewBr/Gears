<?php
namespace InfinityGamers\Gears\Task;

use InfinityGamers\Gears\Gears;
use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;

class SpiderTask extends PluginTask{

        protected $seconds = 15;

        /** @var Player */
        protected $player;
        /** @var Level */
        protected $level;
        /** @var Block[] */
        protected $blocks = [];

        public function __construct(Gears $core, Player $player, Level $level, array $blocks, int $seconds){
                parent::__construct($core);
                $this->player = $player;
                $this->level = $level;
                $this->blocks = $blocks;
                $this->seconds = $seconds;
        }

        public function onRun(int $currentTick){

                if(count($this->blocks) <= 0){
                        $this->getOwner()->getServer()->getScheduler()->cancelTask($this->getTaskId());
                        return;
                }

                if($this->seconds <= 0){
                        $this->player->setCanClimbWalls(false);
                }

                if($this->seconds <= 10){
                        for($i = 0; $i <= 10; ++$i){
                                $top = array_shift($this->blocks);
                                $this->level->setBlock($top, $top);

                                if(count($this->blocks) >= 1){
                                        $bottom = array_shift($this->blocks);
                                        $this->level->setBlock($bottom, $bottom);
                                }
                        }
                }

                --$this->seconds;
        }
}