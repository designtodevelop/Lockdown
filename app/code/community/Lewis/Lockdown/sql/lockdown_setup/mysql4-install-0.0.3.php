<?php

$sql = "create table `%s` (
	`lockdown_id` int(10) unsigned not null auto_increment,
	`identifier` varchar(60) not null default '',
	`active` tinyint(1) not null default '0',
	primary key (`lockdown_id`)
);";
$sql = sprintf($sql, $this->getTable('lockdown/lockdown'));

$this->startSetup();
$this->run($sql);
$this->endSetup();
