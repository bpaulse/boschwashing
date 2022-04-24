/*SELECT  
	ROW_NUMBER() OVER (ORDER BY CAST(REPLACE(sc.score, ':', '') AS UNSIGNED) ASC) AS mypoints,
	CONCAT(ath.Name, ' ', ath.Surname) as fullname,
   sc.athlete_id,
   sc.wod_id,
   athev.event_id,
   sc.score
FROM scores as sc
inner join athletes as ath on ath.id = sc.athlete_id
INNER JOIN athlete_events AS athev ON athev.athlete_id = sc.athlete_id
WHERE athev.event_id = 1 AND sc.wod_id = 40;*/



INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('MOM SQUAD', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('FLORENCE AND THE MACHINE', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('THE AM SQUAD', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('SCALED FOR LIFE', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('DOUBLE BLONDES', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('BANGERS AND MASH', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('HUSTLE AND MUSCLE', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('CORE FITNESS LEGENDS', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('KNIGHTS OF THE ROUND WEIGHTS', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('SUICIDE SQUAD', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('HARDLY ATHLETICS', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('DOUBLE D', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('MARCO EN MONI', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('CORE FITNESS MASTERS', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('JOLLY OLIVES', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('UNBROKEN', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('AGGRESSIVELY AVERAGE', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('WOMEN OF STEEL', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('DIT + DAT', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('THE REAL SLIM SHADY`S', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('THE ODD ONES', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('VERSNEL', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('THE BALD AND THE BEAUTIFUL', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('DEADLY DUO`S', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('CAT + THE JACKAL', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('SHAKE AND BAKE', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('HANNIES', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('FIKS MISFITS', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('MC SQUARED', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('SWEATY SMILIES', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('BACK 2 THE FUTURE', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('SE MY NIKS', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('PRETTY FIKS', '', '07969688690', 'bevanpaulse@gmail.com');
INSERT INTO `athletes` (`Name`, `Surname`, `cellphone`, `email`) VALUES ('THE UNKNOWNS', '', '07969688690', 'bevanpaulse@gmail.com');

26 - 41  - SCALED
41 - 59 - Intermediate

INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('26', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('27', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('28', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('29', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('30', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('31', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('32', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('33', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('34', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('35', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('36', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('37', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('38', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('39', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('40', '15', '13', '6');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('41', '15', '13', '6');

INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('42', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('43', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('44', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('45', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('46', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('47', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('48', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('49', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('50', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('51', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('52', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('53', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('54', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('55', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('56', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('57', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('58', '15', '13', '5');
INSERT INTO `athlete_events` (`athlete_id`, `event_id`, `gender`, `athletetype`) VALUES ('59', '15', '13', '5');


INSERT INTO `wods` (`wodname`, `woddesc`, `wodtype`, `event_id`) VALUES ('Wod Number 1', 'Wod Number 1', '1', '15'), ('Wod Number 2', 'Wod Number 2', '1', '15');
INSERT INTO `wods` (`wodname`, `woddesc`, `wodtype`, `event_id`) VALUES ('Wod Number 3', 'Wod Number 3', '1', '15'), ('Wod Number 4', 'Wod Number 4', '1', '15');

INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '26');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '27');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '28');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '29');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '30');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '31');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '32');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '33');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '34');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '35');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '36');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '37');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '38');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '39');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '40');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '41');

INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '42');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '43');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '44');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '45');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '46');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '47');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '48');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '49');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '50');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '51');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '52');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '53');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '54');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '55');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '56');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '57');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '58');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '50', '59');


INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '26');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '27');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '28');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '29');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '30');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '31');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '32');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '33');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '34');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '35');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '36');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '37');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '38');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '39');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '40');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '41');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '42');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '43');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '44');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '45');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '46');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '47');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '48');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '49');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '50');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '51');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '52');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '53');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '54');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '55');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '56');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '57');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '58');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '51', '59');



INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '26');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '27');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '28');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '29');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '30');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '31');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '32');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '33');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '34');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '35');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '36');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '37');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '38');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '39');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '40');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '41');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '42');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '43');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '44');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '45');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '46');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '47');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '48');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '49');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '50');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '51');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '52');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '53');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '54');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '55');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '56');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '57');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '58');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '52', '59');


INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '26');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '27');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '28');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '29');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '30');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '31');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '32');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '33');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '34');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '35');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '36');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '37');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '38');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '39');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '40');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '41');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '42');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '43');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '44');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '45');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '46');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '47');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '48');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '49');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '50');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '51');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '52');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '53');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '54');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '55');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '56');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '57');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '58');
INSERT INTO `scores` (`score`, `wod_id`, `athlete_id`) VALUES (NULL, '53', '59');