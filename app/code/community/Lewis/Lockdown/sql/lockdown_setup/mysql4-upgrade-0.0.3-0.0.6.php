<?php

$sql = "create table `%s` (
	`lockdown_id` int(10) unsigned not null,
	`page_id` smallint(6) not null,
	unique key `page_id` (`page_id`),
	constraint `lockdown_entity_relation_lockdown_id` foreign key (`lockdown_id`) references `lockdown_entity` (`lockdown_id`) on delete cascade,
	constraint `lockdown_entity_relation_page_id` foreign key (`page_id`) references `cms_page` (`page_id`) on delete cascade
);";
$sql = sprintf($sql, $this->getTable('lockdown/relation_page'));

$this->startSetup();
$this->run($sql);
$this->endSetup();
