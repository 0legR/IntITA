-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2015-07-24 18:27:54
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table int_ita_db.lectures
DROP TABLE IF EXISTS `lectures`;
CREATE TABLE IF NOT EXISTS `lectures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT 'lectureImage.png',
  `alias` varchar(10) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `idModule` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `idType` int(11) DEFAULT '1',
  `durationInMinutes` int(11) DEFAULT '60',
  `idTeacher` varchar(50) DEFAULT NULL,
  `isFree` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8 COMMENT='isFree ( 0 - pay, 1 - demo lecture)';

-- Dumping data for table int_ita_db.lectures: ~134 rows (approximately)
/*!40000 ALTER TABLE `lectures` DISABLE KEYS */;
INSERT INTO `lectures` (`id`, `image`, `alias`, `language`, `idModule`, `order`, `title`, `idType`, `durationInMinutes`, `idTeacher`, `isFree`) VALUES
	(1, 'lectureImage.png', 'lecture1', 'ua', 0, 0, 'Змінні та типи даних в PHP', 1, 40, '1', 1),
	(2, 'lectureImage.png', 'lecture2', 'ua', 0, 0, 'Основи синтаксису', 1, 50, '3', 1),
	(3, 'lectureImage.png', 'lecture3', 'ua', 0, 0, 'Обробка запитів з допомогою PHP', 1, 60, '4', 0),
	(5, 'lectureImage.png', 'lecture4', 'ua', 0, 0, 'Функції в PHP', 1, 60, '1', 0),
	(14, 'lectureImage.png', 'lecture5', 'ua', 0, 0, 'Об\'єкти і класи PHP', 1, 60, '2', 0),
	(15, 'lectureImage.png', 'lecture6', 'ua', 0, 0, 'Робота з масивами даних', 1, 60, '3', 0),
	(16, 'lectureImage.png', 'lecture7', 'ua', 0, 0, 'Робота з стрічками', 1, 60, '2', 0),
	(17, 'lectureImage.png', 'lecture8', 'ua', 0, 0, 'Робота з файловою системою', 1, 60, '4', 0),
	(18, 'lectureImage.png', 'lecture9', 'ua', 0, 0, 'Бази даних і СУБД. Введення в SQL', 1, 60, '2', 0),
	(19, 'lectureImage.png', 'lecture10', 'ua', 0, 0, 'Взаємодія PHP і MySQL', 1, 60, '1', 0),
	(20, 'lectureImage.png', 'lecture11', 'ua', 0, 0, 'Авторизація доступу з допомогою сесій', 1, 60, '3', 0),
	(21, 'lectureImage.png', 'lecture12', 'ua', 0, 0, 'Регулярні вирази', 1, 60, '2', 0),
	(22, 'lectureImage.png', 'lecture1', 'ua', 2, 1, 'Взаємодія PHP і XML', 1, 60, '1', 0),
	(23, 'lectureImage.png', 'lecture2', 'ua', 2, 2, 'Приклади коду', 1, 60, '2', 0),
	(24, 'lectureImage.png', 'lecture3', 'ua', 2, 3, 'Список літератури', 1, 60, '4', 0),
	(26, 'lectureImage.png', 'lecture13', 'ua', 0, 0, 'Фреймворк Yii', 1, 60, '1', 0),
	(27, 'lectureImage.png', 'lecture14', 'ua', 0, 0, 'Фреймворк Lavarel', 1, 60, '3', 0),
	(31, 'lectureImage.png', 'lecture1', 'ua', 0, 0, 'Вступ', 1, 60, '1', 0),
	(32, 'lectureImage.png', 'lecture2', 'ua', 0, 0, '2', 1, 60, '1', 0),
	(33, 'lectureImage.png', 'lecture3', 'ua', 0, 0, '3', 1, 60, '1', 0),
	(35, 'lectureImage.png', 'lecture15', 'ua', 0, 0, ',,....gergregea', 1, 60, '1', 0),
	(36, 'lectureImage.png', 'lecture16', 'ua', 0, 0, ',,....gergregea', 1, 60, '1', 0),
	(37, 'lectureImage.png', 'lecture17', 'ua', 0, 0, 'u7j5787j', 1, 60, '1', 0),
	(38, 'lectureImage.png', 'lecture18', 'ua', 0, 0, 'u7j5787j', 1, 60, '1', 0),
	(39, 'lectureImage.png', 'lecture19', 'ua', 0, 0, 'u7j5787j', 1, 60, '1', 0),
	(40, 'lectureImage.png', 'lecture15', 'ua', 0, 0, 'ythteth', 1, 60, '1', 0),
	(41, 'lectureImage.png', 'lecture16', 'ua', 0, 0, 'j7t578', 1, 60, '1', 0),
	(42, 'lectureImage.png', 'lecture17', 'ua', 0, 0, 'j7t578', 1, 60, '1', 0),
	(43, 'lectureImage.png', 'lecture18', 'ua', 0, 0, 'j7t578', 1, 60, '1', 0),
	(44, 'lectureImage.png', 'lecture19', 'ua', 0, 0, 'j7t578', 1, 60, '1', 0),
	(45, 'lectureImage.png', 'lecture15', 'ua', 0, 0, 'eargrtsg..,,', 1, 60, '1', 0),
	(46, 'lectureImage.png', 'lecture16', 'ua', 0, 0, '6363', 1, 60, '1', 0),
	(47, 'lectureImage.png', 'lecture15', 'ua', 0, 0, '15', 1, 60, '3', 0),
	(48, 'lectureImage.png', 'lecture1', 'ua', 0, 0, 'New lecture', 1, 60, '1', 0),
	(49, 'lectureImage.png', 'lecture1', 'ua', 0, 0, 'hgfjhkjcj bjkhlhkjl', 1, 60, '5', 0),
	(50, 'lectureImage.png', 'lecture2', 'ua', 7, 2, 'Математический анализ', 1, 60, '5', 0),
	(51, 'lectureImage.png', 'lecture3', 'ua', 7, 3, 'Дифференциальные уравнения', 1, 60, '5', 0),
	(52, 'lectureImage.png', 'lecture4', 'ua', 7, 4, 'Математическая физика', 1, 60, '5', 0),
	(53, 'lectureImage.png', 'lecture5', 'ua', 7, 5, 'Геометрия и топология', 1, 60, '5', 0),
	(54, 'lectureImage.png', 'lecture6', 'ua', 7, 1, 'Теория вероятностей и математическая статистика', 1, 60, '5', 0),
	(55, 'lectureImage.png', 'lecture16', 'ua', 0, 0, 'd', 1, 60, '1', 0),
	(56, 'lectureImage.png', 'lecture17', 'ua', 0, 0, '/', 1, 60, '1', 0),
	(57, 'lectureImage.png', 'lecture18', 'ua', 0, 0, '0', 1, 60, '1', 0),
	(58, 'lectureImage.png', 'lecture19', 'ua', 0, 0, '-1', 1, 60, '1', 0),
	(59, 'lectureImage.png', 'lecture20', 'ua', 0, 0, '.', 1, 60, '1', 0),
	(60, 'lectureImage.png', 'lecture21', 'ua', 0, 0, 'ооооооооооооооооооооооооооооооооооооооооммммммммммммммммммммммммммммммммммммммммммммттттттттттттттттттттттттттттттттттттттттттттттттттттввввввввввввввввввввввввввввввввввввввввввввввввссссссссссссссссссссссссссссссссссссссссммммммммммммммммммммммммммммммм', 1, 60, '1', 0),
	(61, 'lectureImage.png', 'lecture22', 'ua', 0, 0, 'ииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииииаааааааааааааааааааааааааааааааааааааааааааааааааааааааасссссссссссссссссссссссссссссссссссссссссссссссссссссссссввввввввввввввввввввввввввввввввввввввввввввввввввввииииииии', 1, 60, '1', 0),
	(62, 'lectureImage.png', 'lecture23', 'ua', 0, 0, 'чсьтмиьт)', 1, 60, '1', 0),
	(63, 'lectureImage.png', 'lecture24', 'ua', 0, 0, 'пор:', 1, 60, '1', 0),
	(64, 'lectureImage.png', 'lecture25', 'ua', 0, 0, ';', 1, 60, '1', 0),
	(65, 'lectureImage.png', 'lecture26', 'ua', 0, 0, ',', 1, 60, '1', 0),
	(66, 'lectureImage.png', 'lecture1', 'ua', 11, 2, 'Занятие 1', 1, 60, '2', 0),
	(67, 'lectureImage.png', 'lecture2', 'ua', 11, 1, 'Занятие 2,', 1, 60, '2', 0),
	(68, 'lectureImage.png', 'lecture3', 'ua', 11, 3, 'Занятие 3.', 1, 60, '2', 0),
	(69, 'lectureImage.png', 'lecture4', 'ua', 11, 4, 'Занятие 4;', 1, 60, '2', 0),
	(70, 'lectureImage.png', 'lecture5', 'ua', 11, 5, 'Занятие 5:', 1, 60, '2', 0),
	(71, 'lectureImage.png', 'lecture6', 'ua', 0, 0, 'занятие 6', 1, 60, '2', 0),
	(72, 'lectureImage.png', 'lecture1', 'ua', 23, 1, 'аатара', 1, 60, '2', 0),
	(73, 'lectureImage.png', 'lecture2', 'ua', 61, 1, 'gfggeg', 1, 60, '1', 0),
	(74, 'lectureImage.png', 'lecture4', 'ua', 0, 0, '4', 1, 60, '1', 0),
	(75, 'lectureImage.png', 'lecture27', 'ua', 0, 0, '\'`!,?їЇ', 1, 60, '1', 0),
	(76, 'lectureImage.png', 'lecture28', 'ua', 0, 0, 'jgkhjlkhl', 1, 60, '1', 0),
	(77, 'lectureImage.png', 'lecture29', 'ua', 0, 0, 'yuiuuoyil', 1, 60, '1', 0),
	(78, 'lectureImage.png', 'lecture1', 'ua', 20, 1, 'rgdgjkj', 1, 60, '3', 0),
	(79, 'lectureImage.png', 'lecture2', 'ua', 20, 2, 'hjhgjghgkg', 1, 60, '3', 0),
	(80, 'lectureImage.png', 'lecture30', 'ua', 0, 0, 'Що таке програмування', 1, 60, '9', 0),
	(81, 'lectureImage.png', 'lecture31', 'ua', 0, 0, 'кар\'єра', 1, 60, '1', 0),
	(82, 'lectureImage.png', 'lecture5', 'ua', 0, 0, 'ппппппппппппппппппппппппппппаааааааааааааааааааааааааааааааввввввввввввввввввввввввввввввссс', 1, 60, '1', 0),
	(83, 'lectureImage.png', 'lecture32', 'ua', 0, 0, 'Що потрібно щоб стати програмістом?', 1, 60, '9', 0),
	(84, 'lectureImage.png', 'lecture33', 'ua', 0, 0, 'Що таке мова програмування.', 1, 60, '9', 0),
	(85, 'lectureImage.png', 'lecture34', 'ua', 0, 0, 'Якою має бути програма?', 1, 60, '9', 0),
	(86, 'lectureImage.png', 'lecture35', 'ua', 0, 0, 'Етапи програмування', 1, 60, '9', 0),
	(87, 'lectureImage.png', 'lecture36', 'ua', 0, 0, 'Підсумкове завдання.', 1, 60, '9', 0),
	(88, 'lectureImage.png', 'lecture4', 'ua', 2, 4, 'Дроби', 1, 60, '10', 0),
	(89, 'lectureImage.png', 'lecture5', 'ua', 2, 5, 'Нескінченний періодичний десятковий дріб', 1, 60, '10', 0),
	(90, 'lectureImage.png', 'lecture6', 'ua', 2, 6, 'Одночлен і многочлени', 1, 60, '10', 0),
	(91, 'lectureImage.png', 'lecture7', 'ua', 2, 7, 'Натуральні числа', 1, 60, '10', 0),
	(92, 'lectureImage.png', 'lecture6', 'ua', 0, 0, 'xfgfghhjhkjkjhlkl', 1, 60, '1', 0),
	(93, 'lectureImage.png', 'lecture7', 'ua', 0, 0, 'lesson 7', 1, 60, '1', 0),
	(94, 'lectureImage.png', 'lecture1', 'ua', 0, 0, 'fhgfjhj', 1, 60, '1', 0),
	(95, 'lectureImage.png', 'lecture2', 'ua', 0, 0, 'yiuioioioio', 1, 60, '1', 0),
	(96, 'lectureImage.png', 'lecture3', 'ua', 0, 0, 'guuihuiuhiuhiuu', 1, 60, '1', 0),
	(97, 'lectureImage.png', 'lecture4', 'ua', 0, 0, 'fcghgcjhgfj', 1, 60, '1', 0),
	(98, 'lectureImage.png', 'lecture1', 'ua', 9, 1, '1', 1, 60, '3', 0),
	(99, 'lectureImage.png', 'lecture3', 'ua', 20, 3, '!!!!!!', 1, 60, '1', 0),
	(100, 'lectureImage.png', 'lecture8', 'ua', 3, 1, 'Основи мови С (частина 1)', 1, 60, '11', 0),
	(101, 'lectureImage.png', 'lecture9', 'ua', 3, 2, 'Основи мови С (частина 2)', 1, 60, '11', 0),
	(102, 'lectureImage.png', 'lecture3', 'ua', 3, 3, 'Процедури і функції', 1, 60, '11', 0),
	(103, 'lectureImage.png', 'lecture4', 'ua', 3, 4, 'Покажчики та рекурсія', 1, 60, '11', 0),
	(104, 'lectureImage.png', 'lecture5', 'ua', 3, 5, 'Символьні рядки', 1, 60, '11', 0),
	(105, 'lectureImage.png', 'lecture6', 'ua', 3, 6, 'Текстові файли', 1, 60, '11', 0),
	(106, 'lectureImage.png', 'lecture7', 'ua', 3, 7, 'Файли з довільним доступом', 1, 60, '11', 0),
	(107, 'lectureImage.png', 'lecture8', 'ua', 3, 8, 'Типи даних, визначені користувачем (частина 1)', 1, 60, '11', 0),
	(108, 'lectureImage.png', 'lecture9', 'ua', 3, 9, 'Типи даних, визначені користувачем (частина 2)', 1, 60, '11', 0),
	(109, 'lectureImage.png', 'lecture10', 'ua', 3, 10, 'Динамічні структури даних (частина 1)', 1, 60, '11', 0),
	(110, 'lectureImage.png', 'lecture11', 'ua', 3, 11, 'Динамічні структури даних (частина 2)', 1, 60, '11', 0),
	(111, 'lectureImage.png', 'lecture12', 'ua', 3, 12, 'Налагодження і тестування', 1, 60, '11', 0),
	(112, 'lectureImage.png', 'lecture2', 'ua', 61, 2, 'ffff', 1, 60, '1', 0),
	(113, 'lectureImage.png', 'lecture3', 'ua', 0, 0, 'dfgdfgdfg', 1, 60, '1', 0),
	(114, 'lectureImage.png', 'lecture13', 'ua', 0, 0, 'аопваотмаи', 1, 60, '1', 0),
	(115, 'lectureImage.png', 'lecture1', 'ua', 18, 1, 'Тест занятие', 1, 60, '1', 0),
	(116, 'lectureImage.png', 'lecture4', 'ua', 20, 4, 'тьмтсич', 1, 60, '1', 0),
	(117, 'lectureImage.png', 'lecture5', 'ua', 1, 1, 'Етапи програмування. Парадигма програмування.', 1, 60, '9', 0),
	(118, 'lectureImage.png', 'lecture6', 'ua', 1, 2, 'Функціонування комп\'ютера.', 1, 60, '9', 0),
	(119, 'lectureImage.png', 'lecture7', 'ua', 0, 0, 'Пристрої введення (клавіатура, мишка, джойстик, сенсорні, мікрофон) та виведення (монітор, відеоадаптер, принтер, плоттер, аудіо адаптер)', 1, 60, '9', 0),
	(120, 'lectureImage.png', 'lecture8', 'ua', 0, 0, 'Пам\'ять комп\'ютера (принципи роботи). Зберігання та перенесення даних. Програмне забезпечення (поняття, класифікація).', 1, 60, '9', 0),
	(121, 'lectureImage.png', 'lecture9', 'ua', 0, 0, 'Принципи фон Неймана. Процесор (історія, компоненти, схема, характеристики).', 1, 60, '9', 0),
	(122, 'lectureImage.png', 'lecture10', 'ua', 0, 0, 'Платформи, ОС (історія, поняття, функції, модулі, функції ядра)', 1, 60, '9', 0),
	(123, 'lectureImage.png', 'lecture11', 'ua', 0, 0, 'Системи числення. Правила переведення для різних СЧ.', 1, 60, '9', 0),
	(124, 'lectureImage.png', 'lecture12', 'ua', 0, 0, 'Алгоритм (поняття, способи подання, властивості, приклади).', 1, 60, '9', 0),
	(125, 'lectureImage.png', 'lecture13', 'ua', 1, 9, 'Технології програмування. Покоління', 1, 60, '9', 0),
	(126, 'lectureImage.png', 'lecture14', 'ua', 1, 10, 'Розвиток мов програмування', 1, 60, '9', 0),
	(127, 'lectureImage.png', 'lecture11', 'ua', 1, 3, 'Пристрої введення та виведення інформації.', 1, 60, '9', 0),
	(128, 'lectureImage.png', 'lecture12', 'ua', 0, 0, 'Пам\'ять комп\'ютера. Зберігання та перенесення даних. Програмне забезпечення', 1, 60, '9', 0),
	(129, 'lectureImage.png', 'lecture11', 'ua', 1, 5, 'Принципи фон Неймана. Що таке процесор.', 1, 60, '9', 0),
	(130, 'lectureImage.png', 'lecture11', 'ua', 1, 6, 'Що таке операційна система.', 1, 60, '9', 0),
	(131, 'lectureImage.png', 'lecture11', 'ua', 1, 4, 'Пам\'ять комп\'ютера. Програмне забезпечення', 1, 60, '9', 0),
	(132, 'lectureImage.png', 'lecture11', 'ua', 1, 8, 'Що таке алгоритм.', 1, 60, '9', 0),
	(133, 'lectureImage.png', 'lecture11', 'ua', 1, 7, 'Системи числення. Правила переведення.', 1, 60, '9', 0),
	(134, 'lectureImage.png', 'lecture1', 'ua', 0, 0, '1', 1, 60, '1', 0),
	(135, 'lectureImage.png', 'lecture1', 'ua', 111, 1, '1', 1, 60, '1', 0),
	(136, 'lectureImage.png', 'lecture3', 'ua', 61, 3, 'Test3', 1, 60, '1', 0),
	(137, 'lectureImage.png', 'lecture11', 'ua', 0, 0, 'test', 1, 60, '1', 0),
	(138, 'lectureImage.png', 'lecture2', 'ua', 111, 2, 'ghhkgjkjk', 1, 60, '1', 0),
	(139, 'lectureImage.png', 'lecture3', 'ua', 111, 3, 'yfugg', 1, 60, '1', 0),
	(140, 'lectureImage.png', 'lecture8', 'ua', 2, 8, 'Дроби', 1, 60, '10', 0),
	(141, 'lectureImage.png', 'lecture4', 'ua', 0, 0, 'Test 4', 1, 60, '1', 0),
	(142, 'lectureImage.png', 'lecture5', 'ua', 0, 0, 'test 5', 1, 60, '1', 0),
	(143, 'lectureImage.png', 'lecture6', 'ua', 0, 0, 'Test 6', 1, 60, '1', 0),
	(144, 'lectureImage.png', 'lecture4', 'ua', 61, 4, 'Test 4', 1, 60, '1', 0),
	(145, 'lectureImage.png', 'lecture5', 'ua', 61, 5, 'test 5', 1, 60, '1', 0),
	(146, 'lectureImage.png', 'lecture6', 'ua', 61, 6, 'Тест 6', 1, 60, '1', 0),
	(147, 'lectureImage.png', 'lecture7', 'ua', 61, 7, 'тест 7', 1, 60, '1', 0),
	(148, 'lectureImage.png', 'lecture8', 'ua', 61, 8, 'ТЕСТ 8', 1, 60, '1', 0);
/*!40000 ALTER TABLE `lectures` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
