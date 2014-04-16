<?php

$sql = "alter table `%s`
	add `auth_type` tinyint(1) not null default 1 after `identifier`,
	add `auth_username` varchar(60) after `auth_type`,
	add `auth_password` varchar(60) after `auth_username`,
	add `hash` varchar(32) after `auth_password`,
	add constraint `lockdown_entity_identifier_unq` unique (`identifier`)
;";
$sql = sprintf($sql, $this->getTable('lockdown/lockdown'));

$this->startSetup();
$this->run($sql);
$this->endSetup();
