-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2015-04-29 19:49:11
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table int_ita_db.teacher
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(6) NOT NULL,
  `first_name` varchar(35) NOT NULL,
  `middle_name` varchar(35) NOT NULL,
  `last_name` varchar(35) NOT NULL,
  `foto_url` varchar(100) NOT NULL,
  `subjects` varchar(100) NOT NULL,
  `profile_text_first` text NOT NULL,
  `profile_text_short` text NOT NULL,
  `profile_text_last` text NOT NULL,
  `readMoreLink` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `skype` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `linkName` varchar(50) NOT NULL,
  `smallImage` varchar(255) NOT NULL,
  `rate_knowledge` int(2) NOT NULL,
  `rate_efficiency` int(2) NOT NULL,
  `rate_relations` int(2) NOT NULL,
  `sections` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `courses` varchar(255) NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table int_ita_db.teacher: ~6 rows (approximately)
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` (`teacher_id`, `lang`, `first_name`, `middle_name`, `last_name`, `foto_url`, `subjects`, `profile_text_first`, `profile_text_short`, `profile_text_last`, `readMoreLink`, `email`, `tel`, `skype`, `title`, `linkName`, `smallImage`, `rate_knowledge`, `rate_efficiency`, `rate_relations`, `sections`, `user_id`, `courses`) VALUES
	(1, 'UA', 'Олександра', 'Василівна', 'Сіра', '/css/images/teacher1.jpg', 'кройка и шитье сроков; програмування самоубийств', '<p>Народила<em><strong><del>ся і виросла в Сакраменто, у 18 років вона переїхала до Лос-Анджелеса й незабаром стала</del></strong></em></p><p><strong><em><del>                                викладачем. У 2007, 2008 і 2010 рр.. вона виграла кілька номінацій премії AVN Awards</del></em></strong></p><p><strong><em><del>                                (також була названа «Найкращою програмісткою» у 2007 році за версією XRCO).</del></em></strong></p><p><strong><em><del>                                Паралельно з вікладауцью роботою та роботою програміста в Саша Грей грає головну роль в тестванні Інтернету.<br></del></em></strong></p><p><strong><em><del>                                Марина Енн Генціс народилася у родині механіка. Її батько мав грецьке походження.</del></em></strong></p><p>                                Батьки дівчинки розлучилися коли їй було 5 років, надалі її виховувала мати, яка вступила</p><p>                                в повторний шлюб у 2000 роц. Марина не ладнала з вітчимом, і, коли їй виповнилося 16 років,</p><p>                                дівчина повідомила матері, що збирається покинути будинок. Достеменно невідомо, втекла вона з свого</p><p>                    будинку або ж її відпустила мати. Сама Олександра пізніше зізнавалася, що в той час робила все те,</p><p>                    що не подобалося її батькам і що вони їй забороняли.<br></p><p>                    Главный бухгалтер акционерного предприятия, специализирующегося на:</p><ul>	<li>оказании полезных услуг горизонтального характера;</li>	<li>торговле, внешнеэкономической и внутреннеэкономической;</li>	<li>позитивное обучение швейного мастерства;</li></ul>', '<p>Профессиональный преподаватель бухгалтерского и налогового учета Национальноготранспортного университета кафедры финансов, учета и аудита со стажем преподавательской работы более 25 лет. Закончила аспирантуру, автор 36 научных работ в области учета и аудита, в т.ч. уникальной обучающей методики написания бухгалтерских проводок: <span>"Как украсть и не сесть" </span> и <span>"Как украсть и посадить другого" </span>.</p><p>Главный бухгалтер акционерного предприятия, специализирующегося на:<ul><li>оказании полезных услуг горизонтального характера;</li><li>торговле, внешнеэкономической и внутреннеэкономической;</li><li>позитивное обучение швейного мастерства;</li></ul></p>', '<p>Олександра Сіра <del><em><strong>виконала головну роль у фільмі оскароносного режисера </strong></em></del></p><p><del><em><strong>                        Стівена Содерберга «Дівчина за викликом»[27][28]. Олександра грає дівчину на ім\'я Челсі, яка надає </strong></em></del></p><p><del><em><strong>                        ескорт послуги заможним людям. Содерберг взяв її на роль після того, як прочитав статтю про неї у </strong></em></del></p><p><del><em><strong>                        журналі Los Angeles, коментуючи це так: «She\'s kind of a new breed, I think. She doesn\'t really fit </strong></em></del></p><p><del><em><strong>                        the typical mold of someone who goes into the adult film business. … I\'d never heard anybody talk </strong></em></del></p><p><del><em><strong>                        about the business the way that she ta</strong></em></del>lked about it». Журналіст Скотт Маколей каже, що можливо</p><p>                        Грей вибрала саме цю роль через свій інтерес до незалежних режисерів, таких як Жан-Люк Годар,</p><p>                        Хармоні Корін, Девід Гордон Грін, Мікеланджело Антоніоні, Аньєс Варда та Вільям Клейн.</p><p><br>Коли Олександра  готувалася до ролі у «Дівчині за викликом»,</p><p>                        Содерберг попросив її подивитися «Жити своїм життям» і «Божевільний П\'єро»[29].</p><p>                        У фільмі «Жити своїм життям» піднімаються проблеми проституції, звідки Грей могла</p><p>                        взяти щось і для своєї ролі, в той час як у «Божевільному П\'єро» показані відносини,</p><p>                        схожі на ті, що відбуваються між Челсі, її хлопцем і клієнтами.</p>', '/profile/index/1/', 'teacher1@gmail.com', '/067/56-569-56, /093/26-45-65', '', '', '', '/css/images/teacherImage.png', 12, 12, 12, 'Програмування ПХП;\r\nJava для IOS;', 38, ''),
	(2, 'UA', 'Константин', 'Константинович', 'Константинопольский', '/css/images/teacher2.jpg', 'программування БДСМ; программування на Php для пострадавших в ЧАЭС; GlobalLoqic, Samsung, Coqniance', '<p>Hello!</p>', '<p>Консультант по вопросам бухгалтерского и налогового учета, отчетности для предприятий разной формы собственности. Преподаватель с многолетним стажем работы. <span>Реально шарит в компьютерах.</span></p><p>Автор технологии повышения квалификации специалистов экономического профиля.</p><p>Опыт преподавательской работы около 20 лет в учебных центрах и ВУЗах Киева. Опыт работы главным бухгалтером, финансовым директором. Большой опыт внедрения программ системы Виндовз 3:11.</p>', '<h2>Hello!</h2>', '/profile/index/2/', 'teacher2@gmail.com', '/067/56-569-56, /093/26-45-65', '', '', '', '/css/images/teacherImage.png', 10, 10, 10, 'Програмування ПХП;\r\nJava для IOS;', 39, ''),
	(3, 'UA', 'Любовь', 'Анатольевна', 'Ктоятакая-Замухриншская', '/css/images/teacher3.jpg', 'Бухгалтер с «О» и до первой отсидки; Программирование своего позитивного прошлого', '', '<p>Практикующий главный бухгалтер. Учредитель ПП <span>«Логика тут безсильна»</span>;</p>\r\n<p>Образование высшее - ДонГУ (1987г.)</p>\r\n<p>Опыт работы 27 лет, в т. ч. преподавания - 9 лет.</p>\r\n<ul><li>специалист по позитивной энергетике;</li><li>эксперт по эффективному ремонту баянов;</li><li>мастер психотерапии для сложных бабушек и дедушек;</li></ul>', '', '/profile/index/3/', 'teacher3@gmail.com', '/067/56-569-56, /093/26-45-65', '', '', '', '/css/images/teacherImage.png', 11, 11, 11, 'Програмування ПХП;\r\nJava для IOS;', 40, ''),
	(4, 'UA', 'Василий', 'Васильевич', 'Меняетпроффесию', '/css/images/teacher4.jpg', 'программування БДСМ; программування на Php для пострадавших в ЧАЭС; GlobalLoqic, Samsung, Coqniance', '', '<p>Консультант по вопросам бухгалтерского и налогового учета, отчетности для предприятий разной формы собственности. Преподаватель с многолетним стажем работы. <span>Реально шарит в компьютерах.</span></p><p>Автор технологии повышения квалификации специалистов экономического профиля.</p><p>Опыт преподавательской работы около 20 лет в учебных центрах и ВУЗах Киева. Опыт работы главным бухгалтером, финансовым директором. Большой опыт внедрения программ системы Виндовз 3:11.</p>', '', '/profile/index/4/', 'teacher4@gmail.com', '/067/56-569-56, /093/26-45-65', '', '', '', '/css/images/teacherImage.png', 9, 9, 9, 'Програмування ПХП;\r\nJava для IOS;', 41, ''),
	(5, 'UA', 'Ия', 'Тожевна', 'Воваяготова', '/css/images/teacher5.jpg', 'программування БДСМ; программування на Php для пострадавших в ЧАЭС; GlobalLoqic, Samsung, Coqniance', '', '<p>Консультант по вопросам бухгалтерского и налогового учета, отчетности для предприятий разной формы собственности. Преподаватель с многолетним стажем работы. <span>Реально шарит в компьютерах.</span></p><p>Автор технологии повышения квалификации специалистов экономического профиля.</p><p>Опыт преподавательской работы около 20 лет в учебных центрах и ВУЗах Киева. Опыт работы главным бухгалтером, финансовым директором. Большой опыт внедрения программ системы Виндовз 3:11.</p>', '', '/profile/index/5/', 'teacher5@gmail.com', '/067/56-569-56, /093/26-45-65', '', '', '', '/css/images/teacherImage.png', 10, 10, 10, 'Програмування ПХП;\r\nJava для IOS;', 42, ''),
	(6, 'UA', 'Петросян', 'Петросянович', 'Забугорный', '/css/images/teacher6.jpg', 'программування БДСМ; программування на Php для пострадавших в ЧАЭС; GlobalLoqic, Samsung, Coqniance', '<p>hello!</p>', '<p>Консультант по вопросам бухгалтерского и налогового учета, отчетности для предприятий разной формы собственности. Преподаватель с многолетним стажем работы. <span>Реально шарит в компьютерах.</span></p><p>Автор технологии повышения квалификации специалистов экономического профиля.</p><p>Опыт преподавательской работы около 20 лет в учебных центрах и ВУЗах Киева. Опыт работы главным бухгалтером, финансовым директором. Большой опыт внедрения программ системы Виндовз 3:11.</p>', '<h3>hello2!</h3>', '/profile/index/6/', 'teacher6@gmail.com', '/067/56-569-56, /093/26-45-65', '', '', '', '/css/images/teacherImage.png', 11, 11, 11, 'Програмування ПХП;\r\nJava для IOS;', 43, '');
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
