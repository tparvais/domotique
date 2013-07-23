-- Adminer 3.7.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+02:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DELIMITER ;;

DROP PROCEDURE IF EXISTS `clean_counter`;;
CREATE PROCEDURE `clean_counter`()
delete from t_mesures where (sonde_id = 16)or (sonde_id = 17)or (sonde_id = 18)or (sonde_id = 19);;

DELIMITER ;

DROP TABLE IF EXISTS `t_grandeurs`;
CREATE TABLE `t_grandeurs` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `t_grandeurs` (`id`, `nom`, `description`) VALUES
(1,	'Température',	''),
(2,	'Humidité',	''),
(3,	'Pluie',	''),
(4,	'Compteur',	'Compteur'),
(5,	'Pression',	''),
(6,	'Vitesse vent',	''),
(7,	'Direction vent',	''),
(8,	'Etat',	'Etat binaire'),
(11,	'puissance',	'');

DROP TABLE IF EXISTS `t_mesures`;
CREATE TABLE `t_mesures` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sonde_id` tinyint(4) DEFAULT NULL,
  `Mesure_brute` double DEFAULT NULL,
  `Mesure` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sonde_id` (`sonde_id`),
  CONSTRAINT `t_mesures_ibfk_2` FOREIGN KEY (`sonde_id`) REFERENCES `t_sondes` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `t_sondes`;
CREATE TABLE `t_sondes` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nom` char(50) DEFAULT NULL,
  `zone_id` tinyint(4) DEFAULT NULL,
  `grandeur_id` tinyint(4) DEFAULT NULL,
  `polling_time` smallint(6) DEFAULT '5',
  `label_unite` varchar(15) DEFAULT NULL,
  `y_axe_max` float DEFAULT NULL,
  `y_axe_min` float DEFAULT NULL,
  `offset` double DEFAULT '0',
  `conversion` float NOT NULL DEFAULT '1',
  `adresse_source` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zone_id` (`zone_id`),
  KEY `grandeur_id` (`grandeur_id`),
  CONSTRAINT `t_sondes_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `t_zones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `t_sondes_ibfk_2` FOREIGN KEY (`grandeur_id`) REFERENCES `t_grandeurs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `t_sondes` (`id`, `nom`, `zone_id`, `grandeur_id`, `polling_time`, `label_unite`, `y_axe_max`, `y_axe_min`, `offset`, `conversion`, `adresse_source`, `description`) VALUES
(1,	'Temp_Cave_Vin',	2,	1,	5,	'°C',	45,	0,	NULL,	1,	'sheevaplug@1W@/1F.4E2904000000/main/temperature_cave_vin/temperature',	'Température de la cave à vin'),
(2,	'humidite_cave_vin',	1,	2,	5,	'%',	100,	0,	NULL,	1,	'sheevaplug@1W@/1F.4E2904000000/main/humidite_cave_vin/humidity',	'Humidité de la cave à vin'),
(3,	'Pression_atmospherique',	2,	5,	15,	'mbar',	1150,	950,	NULL,	1,	'sheevaplug@1W@/1F.2B2B04000000/aux/barometre/B1-R1-A/pressure',	'Pression atmosphérique'),
(4,	'Temp_VMC_pulsion_frais',	3,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'webcontrol8@WC@gett1.cgi',	'Température de l\'air frais pulsée dans la maison'),
(5,	'Temp_VMC_aspiration_air_frais',	5,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'webcontrol8@WC@gett2.cgi',	'Température de l\'air frais à l\'entrée de la VMC'),
(6,	'Temp_VMC_pulsion_vicie',	4,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'webcontrol8@WC@gett3.cgi',	'Température de l\'air vicié rejeté à l\'extérieur'),
(7,	'Temp_PuitCanadien',	7,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'webcontrol8@WC@gett4.cgi',	'Température de l\'air à la sortie du puit canadien'),
(8,	'Temp_VMC_aspiration_air_vicie',	6,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'webcontrol8@WC@gett5.cgi',	'Température de l\'air vicié à l\'entrée de la VMC'),
(9,	'Hum_VMC_aspiration_air_vicie',	6,	2,	5,	'%',	100,	0,	NULL,	1,	'webcontrol8@WC@geth1.cgi',	'Humidité de l\'air intérieur aspiré par la VMC'),
(10,	'Eau_sanitaire_chaude',	8,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'sheevaplug@1W@/1F.2B2B04000000/main/temperature_eau_chaude/temperature',	'Température de l\'eau chaude sanitaire'),
(11,	'Temp_balon_solaire_haut',	11,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'sheevaplug@1W@/1F.2B2B04000000/main/temperature_balon_haut/temperature',	'Température en haut du Ballon solaire'),
(12,	'Temp_balon_solaire_bas',	12,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'sheevaplug@1W@/1F.2B2B04000000/main/temperature_balon_bas/temperature',	'Température en bas du balon solaire'),
(13,	'Temp_CES_tyco_chaud',	14,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'sheevaplug@1W@/1F.2B2B04000000/main/temperature_tyco_chaud/temperature',	'Température fluide Tycofor en sortie de capteurs'),
(14,	'Temp_CES_tyco_froid',	15,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'sheevaplug@1W@/1F.2B2B04000000/main/temperature_tyco_froid/temperature',	'Température fluide Tycofor à l\'entrée des capteurs'),
(15,	'Production_electrique_PV',	13,	4,	5,	'Wh',	NULL,	NULL,	0,	1,	'sheevaplug@1W@/uncached/1F.313104000000/main/compteur_electricite/counters.A',	'Production photovoltaïque'),
(16,	'Conso_electrique',	16,	4,	5,	'Wh',	NULL,	NULL,	0,	1,	'sheevaplug@1W@/uncached/1F.313104000000/main/compteur_electricite/counters.B',	'Compteur de la consommation électrique'),
(17,	'Conso_eau_chaude',	8,	4,	5,	'L',	NULL,	NULL,	0,	0.25,	'sheevaplug@1W@/uncached/1F.2B2B04000000/main/compteur_eau_chaude/counters.A',	'Consommation d\'eau chaude sanitaire'),
(18,	'Conso_eauville',	9,	4,	5,	'L',	NULL,	NULL,	0,	1,	'sheevaplug@1W@/uncached/1F.4E2904000000/main/compteur_eau_froide/counters.B',	'Consommation d\'eau de ville'),
(19,	'Conso_eaupluie',	10,	4,	5,	'L',	NULL,	NULL,	0,	0.25,	'sheevaplug@1W@/uncached/1F.4E2904000000/main/compteur_eau_froide/counters.A',	'Consommation d\'eau de pluie'),
(20,	'Temp_eaupluie',	10,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'sheevaplug@1W@/1F.4E2904000000/main/temperature_eau_pluie/temperature',	'Température de l\'eau de pluie'),
(21,	'Temp_eau_sanitaire_froide',	9,	1,	5,	'°C',	NULL,	0,	NULL,	1,	'sheevaplug@1W@/1F.4E2904000000/main/temperature_eau_froide/temperature',	'Température de l\'eau froide de ville'),
(22,	'puissance_PV',	13,	11,	5,	'W',	NULL,	0,	0,	3600,	'15@VS@derivate',	'Puissance des panneaux photovotaïques (5min)'),
(23,	'puissance_electrique',	16,	11,	5,	'W',	NULL,	0,	0,	3600,	'16@VS@derivate',	'Puissance électrique consommée (5min)'),
(24,	'bilan_electrique',	16,	11,	5,	'W',	NULL,	NULL,	0,	1,	'23@VS@substract|22',	'Bilan puissance électrique (5min)');

DROP TABLE IF EXISTS `t_zones`;
CREATE TABLE `t_zones` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `t_zones` (`id`, `nom`, `description`) VALUES
(1,	'Cave vin',	'Cave à vin'),
(2,	'Météo',	'Relevés météorologiques'),
(3,	'VMC pulsion frais',	'Sortie air frais de la VMC'),
(4,	'VMC pulsion vicié',	'Sortie air vicié de la VMC'),
(5,	'VMC aspiration frais',	'Entrée air frais dans la VMC'),
(6,	'VMC aspiration vicié',	'Entrée air vicié dans la VMC'),
(7,	'Puit canadien',	'Sortie du puit canadien'),
(8,	'Eau chaude sanitaire',	'Eau chaude sanitaire (après la vanne 3 voies)'),
(9,	'Eau ville',	'Eau froide sanitaire'),
(10,	'Eau pluie',	'Eau de pluie (groupe hydrophobe)'),
(11,	'Ballon haut',	'Haut du ballon solaire'),
(12,	'Ballon bas',	'Bas du ballon solaire'),
(13,	'Capteurs photovolatïques',	'Capteurs photovoltaïques'),
(14,	'CES sortie',	'Sortie des capteurs thermiques'),
(15,	'CES entrée',	'Entrée des capteurs thermiques'),
(16,	'Electricité',	'Compteur consommation électrique');

DROP VIEW IF EXISTS `v_measures_last24`;
CREATE TABLE `v_measures_last24` (`sonde_id` tinyint(4), `Mesure` double, `temps` timestamp);


DROP VIEW IF EXISTS `v_mesures_avg_1jour`;
CREATE TABLE `v_mesures_avg_1jour` (`sonde_id` tinyint(4), `start_period` timestamp, `end_period` timestamp, `mid_period` datetime, `dur_period` time, `avg_mesure` double, `min_mesure` double, `max_mesure` double, `nb_mesure` bigint(21));


DROP VIEW IF EXISTS `v_mesures_avg_30min`;
CREATE TABLE `v_mesures_avg_30min` (`sonde_id` tinyint(4), `start_period` timestamp, `end_period` timestamp, `mid_period` datetime, `dur_period` time, `avg_mesure` double, `min_mesure` double, `max_mesure` double, `nb_mesure` bigint(21));


DROP VIEW IF EXISTS `v_mesures_avg_3h`;
CREATE TABLE `v_mesures_avg_3h` (`sonde_id` tinyint(4), `start_period` timestamp, `end_period` timestamp, `mid_period` datetime, `dur_period` time, `avg_mesure` double, `min_mesure` double, `max_mesure` double, `nb_mesure` bigint(21));


DROP VIEW IF EXISTS `v_sondes_avg_last24h`;
CREATE TABLE `v_sondes_avg_last24h` (`sonde_id` tinyint(4), `avg_mesure` double, `max_mesure` double, `min_mesure` double, `sonde_nom` char(50), `sonde_description` varchar(255), `label_unite` varchar(15));


DROP TABLE IF EXISTS `v_measures_last24`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_measures_last24` AS select `t_mesures`.`sonde_id` AS `sonde_id`,`t_mesures`.`Mesure` AS `Mesure`,`t_mesures`.`timestamp` AS `temps` from `t_mesures` where (`t_mesures`.`timestamp` > (now() - interval 24 hour)) order by `t_mesures`.`timestamp` desc;

DROP TABLE IF EXISTS `v_mesures_avg_1jour`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_mesures_avg_1jour` AS select `t_mesures`.`sonde_id` AS `sonde_id`,min(`t_mesures`.`timestamp`) AS `start_period`,max(`t_mesures`.`timestamp`) AS `end_period`,from_unixtime((unix_timestamp(min(`t_mesures`.`timestamp`)) + floor(((unix_timestamp(max(`t_mesures`.`timestamp`)) - unix_timestamp(min(`t_mesures`.`timestamp`))) / 2)))) AS `mid_period`,timediff(max(`t_mesures`.`timestamp`),min(`t_mesures`.`timestamp`)) AS `dur_period`,avg(`t_mesures`.`Mesure`) AS `avg_mesure`,min(`t_mesures`.`Mesure`) AS `min_mesure`,max(`t_mesures`.`Mesure`) AS `max_mesure`,count(`t_mesures`.`Mesure`) AS `nb_mesure` from `t_mesures` group by `t_mesures`.`sonde_id`,date_format(`t_mesures`.`timestamp`,'%Y%m%d');

DROP TABLE IF EXISTS `v_mesures_avg_30min`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_mesures_avg_30min` AS select `t_mesures`.`sonde_id` AS `sonde_id`,min(`t_mesures`.`timestamp`) AS `start_period`,max(`t_mesures`.`timestamp`) AS `end_period`,from_unixtime((unix_timestamp(min(`t_mesures`.`timestamp`)) + floor(((unix_timestamp(max(`t_mesures`.`timestamp`)) - unix_timestamp(min(`t_mesures`.`timestamp`))) / 2)))) AS `mid_period`,timediff(max(`t_mesures`.`timestamp`),min(`t_mesures`.`timestamp`)) AS `dur_period`,avg(`t_mesures`.`Mesure`) AS `avg_mesure`,min(`t_mesures`.`Mesure`) AS `min_mesure`,max(`t_mesures`.`Mesure`) AS `max_mesure`,count(`t_mesures`.`Mesure`) AS `nb_mesure` from `t_mesures` group by `t_mesures`.`sonde_id`,(floor((unix_timestamp(`t_mesures`.`timestamp`) / 1800)) * 1800);

DROP TABLE IF EXISTS `v_mesures_avg_3h`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_mesures_avg_3h` AS select `t_mesures`.`sonde_id` AS `sonde_id`,min(`t_mesures`.`timestamp`) AS `start_period`,max(`t_mesures`.`timestamp`) AS `end_period`,from_unixtime((unix_timestamp(min(`t_mesures`.`timestamp`)) + floor(((unix_timestamp(max(`t_mesures`.`timestamp`)) - unix_timestamp(min(`t_mesures`.`timestamp`))) / 2)))) AS `mid_period`,timediff(max(`t_mesures`.`timestamp`),min(`t_mesures`.`timestamp`)) AS `dur_period`,avg(`t_mesures`.`Mesure`) AS `avg_mesure`,min(`t_mesures`.`Mesure`) AS `min_mesure`,max(`t_mesures`.`Mesure`) AS `max_mesure`,count(`t_mesures`.`Mesure`) AS `nb_mesure` from `t_mesures` group by `t_mesures`.`sonde_id`,(floor((unix_timestamp(`t_mesures`.`timestamp`) / 10800)) * 10800);

DROP TABLE IF EXISTS `v_sondes_avg_last24h`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_sondes_avg_last24h` AS select `v_measures_last24`.`sonde_id` AS `sonde_id`,avg(`v_measures_last24`.`Mesure`) AS `avg_mesure`,max(`v_measures_last24`.`Mesure`) AS `max_mesure`,min(`v_measures_last24`.`Mesure`) AS `min_mesure`,`t_sondes`.`nom` AS `sonde_nom`,`t_sondes`.`description` AS `sonde_description`,`t_sondes`.`label_unite` AS `label_unite` from (`v_measures_last24` join `t_sondes`) where (`t_sondes`.`id` = `v_measures_last24`.`sonde_id`) group by `v_measures_last24`.`sonde_id`;

-- 2013-07-24 00:51:43
