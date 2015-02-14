SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `cifrex_filters` (
  `filtr_id` int(11) NOT NULL,
  `filtr_hash` varchar(64) NOT NULL,
  `regexdb_id` int(11) NOT NULL,
  `author` varchar(64) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `cve` varchar(32) NOT NULL,
  `cwe` varchar(32) NOT NULL,
  `wlb` varchar(15) NOT NULL,
  `filtr` text NOT NULL,
  `date_created` int(11) unsigned NOT NULL,
  `date_lastmod` int(11) NOT NULL,
  `qs_lastused_path` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `cifrex_filters` (`filtr_id`, `filtr_hash`, `regexdb_id`, `author`, `name`, `description`, `cve`, `cwe`, `wlb`, `filtr`, `date_created`, `date_lastmod`, `qs_lastused_path`) VALUES
(1, 'bbe24a474d87633a02771fba6ed71cd9', 0, 'Maksymilian Arciemowicz', 'Classic Cross Site Scripting', 'The software does not neutralize or incorrectly neutralizes user-controllable input before it is placed in output that is used as a web page that is served to other users.', 'CVE-2011-4544', 'CWE-79', '', '{\n"v1":"(.*echo.*\\\\$_(?:POST|GET)\\\\[(?:\\\\''|\\\\\\")(?<v1>\\\\w+)(?:\\\\''|\\\\\\")\\\\].*)",\n"v2":"",\n"v3":"",\n"t1":"",\n"t2":"",\n"t3":"",\n"f1":"htmlspecialchars.*<v1>",\n"f2":"\\\\(int\\\\)\\\\$_(?:POST|GET)\\\\[.<v1>.\\\\]",\n"f3":""\n}', 1422304649, 1423683576, 'Maksymilian Arciemowicz'),
(2, '7a09eceac4b9b9a5fa67e1393917e38c', 0, 'Maksymilian Arciemowicz', 'Classic SQL Injection', 'The software constructs all or part of an SQL command using externally-influenced input from an upstream component, but it does not neutralize or incorrectly neutralizes special elements that could modify the intended SQL command when it is sent to a downstream component.', '', 'CWE-89', '', '{\n"v1":"\\\\$(?<v1>\\\\w+) \\\\=.*\\\\$_(?:GET|POST)\\\\[(?<v2>.*)\\\\]",\n"v2":"",\n"v3":"",\n"t1":"mysql_query\\\\(.*\\\\$<v1>",\n"t2":"",\n"t3":"",\n"f1":"addslashes.*\\\\$<v1>",\n"f2":"",\n"f3":""\n}', 1422304752, 1423683616, 'Maksymilian Arciemowicz'),
(3, 'af32d7c8aec60d2566cbe02fe3cd02ef', 0, 'Kamil Uptas', 'Remote code execution in PHP', 'The software receives input from an upstream component, but it does not neutralize or incorrectly neutralizes code syntax before using the input in a dynamic evaluation call eval().', 'CVE-2012-0993', 'CWE-95', 'WLB-2012020080', '{\n"v1":"\\\\$(?<v1>\\\\w+)(?: |)\\\\=(?: |)\\\\$_(?:POST|GET|REQUEST|COOKIE)",\n"v2":"",\n"v3":"",\n"t1":"eval.*<v1>",\n"t2":"",\n"t3":"",\n"f1":"",\n"f2":"",\n"f3":""\n}', 1422304896, 1423683649, 'Kamil Uptas'),
(4, '0951984e319624f6fab13755ca381049', 0, 'Maksymilian Arciemowicz', 'Remote/Local File Inclusion', 'In certain versions and configurations of PHP, this can allow an attacker to specify a URL to a local or remote location from which the software will obtain the code to execute. \n\nCheck oscommerce admin: \nosCommerce/OM/Core/Site/Admin/Application/modules_order_total/pages/edit.php', '', 'CWE-98', '', '{\n"v1":"(.*(?:\\\\@| )(?:include|require|file)\\\\(.*\\\\$\\\\_(?:POST|GET).*)",\n"v2":"",\n"v3":"",\n"t1":"",\n"t2":"",\n"t3":"",\n"f1":"",\n"f2":"",\n"f3":""\n}', 1422304955, 1423683704, 'Maksymilian Arciemowicz'),
(5, '826541fdbe2015b1a0a0a147a50d6f4a', 0, 'Maksymilian Arciemowicz', 'Local File Inclusion phpMyAdmin 2.6.1', 'The PHP application receives input from an upstream component, but it does not restrict or incorrectly restricts the input before its usage in "require," "include," or similar functions.', 'CVE-2005-3299', 'CWE-98', 'WLB-2005100029', '{\n"v1":"(?<v1>\\\\w+) \\\\= \\\\$_(?:POST|GET)\\\\[\\\\''(?<v2>\\\\w+)\\\\''",\n"v2":"",\n"v3":"",\n"t1":"(?:include|require).*<v1>",\n"t2":"",\n"t3":"",\n"f1":"file_exist.*<v1>",\n"f2":"",\n"f3":""\n}', 1422305076, 1423683800, 'Maksymilian Arciemowicz'),
(6, '8e0446e69cb88387f43aa7617a07d9ab', 0, 'Kamil Uptas', 'Source Code Disclosure in PHP', 'The PHP application receives input from an upstream component, but it does not restrict or incorrectly restricts the input before its usage in: file, file_get_contents, show_source or highlight_file.', '', 'CWE-98', '', '{\n"v1":"\\\\$(?<v1>\\\\w+)(?: |)\\\\=(?: |)\\\\$_(?:POST|GET|REQUEST|COOKIE)",\n"v2":"",\n"v3":"",\n"t1":"(?:file|file_get_contents|show_source|highlight_file)(?: |)\\\\(.*<v1>",\n"t2":"",\n"t3":"",\n"f1":"Content-Disposition",\n"f2":"",\n"f3":""\n}', 1422315830, 1423683837, 'Kamil Uptas'),
(7, '43d5f08e421727343e900acb12e3828d', 0, 'Maksymilian Arciemowicz', 'Buffer overflow with strcpy and sprintf', 'The program copies an input buffer to an output buffer without verifying that the size of the input buffer is less than the size of the output buffer, leading to a buffer overflow.', '', 'CWE-120', '', '{\n"v1":"(?<v1>\\\\w+).=.(?:\\\\(.*\\\\)|).malloc",\n"v2":"",\n"v3":"",\n"t1":"(.*(?:sprintf|strcpy).*<v1>.*)",\n"t2":"",\n"t3":"",\n"f1":"<v1>.=.*malloc.*strlen",\n"f2":"(?:<v1>.*NULL|NULL.*<v1>)",\n"f3":""\n}', 1422315924, 1423683997, 'Maksymilian Arciemowicz'),
(8, '21c91caff0156f9234f08e83222f9a53', 0, 'Maksymilian Arciemowicz', 'Array overrun with char', 'The product uses untrusted input when calculating or using an array index, but the product does not validate or incorrectly validates the index to ensure the index references a valid position within the array.', '', 'CWE-120', '', '{\n"v1":"(?<v1>\\\\w{2,})(?:| )\\\\[(?:| )(?<v2>[\\\\-\\\\.\\\\>a-z]{4,})(?:| )\\\\]",\n"v2":"",\n"v3":"",\n"t1":"char.* <v1>(?: |)\\\\[.*\\\\](?:\\\\;|,).*",\n"t2":"(?:<v2>(?: |)\\\\=(?: |)strlen)",\n"t3":"char.* <v1>(?: |)\\\\[(\\\\d)\\\\]",\n"f1":"if.*<v2>(?:| )\\\\<(?:| )(\\\\w+)",\n"f2":"char.* <v1>(?: |)\\\\[([A-Z]+)\\\\]",\n"f3":""\n}', 1422316013, 1423684047, 'Maksymilian Arciemowicz'),
(9, 'f3b16c80ddc826b6457f6d56abaca16c', 0, 'Maksymilian Arciemowicz', 'Off-by one with wrong calculated buffer', 'The software does not correctly calculate the size to be used when allocating a buffer, which could lead to a buffer overflow.', '', 'CWE-131', '', '{\n"v1":"(?<v1>\\\\w+).\\\\=.(?:\\\\(\\\\)|).*lloc\\\\(",\n"v2":"for.\\\\(.*\\\\;.*\\\\<(?<v2>\\\\w+).*",\n"v3":"",\n"t1":"<v1>.*\\\\[<v2>\\\\].*",\n"t2":"",\n"t3":"",\n"f1":"<v1>.\\\\=.(?:\\\\(\\\\)|).*lloc\\\\(.*\\\\+.1",\n"f2":"",\n"f3":""\n}', 1422316140, 1423685232, 'Maksymilian Arciemowicz'),
(10, 'c40491d29cdce81e0b7a1e34e6a1e61a', 0, 'Maksymilian Arciemowicz', 'Off-by one with char table', 'If the incorrect calculation is used in the context of memory allocation, then the software may create a buffer that is smaller or larger than expected. If the allocated buffer is smaller than expected, this could lead to an out-of-bounds read or write (CWE-119), possibly causing a crash, allowing arbitrary code execution, or exposing sensitive dat', '', 'CWE-131', '', '{\n"v1":"char.* (?<v1>\\\\w+)\\\\[(?<v2>\\\\w+)\\\\]",\n"v2":"",\n"v3":"",\n"t1":"for.*\\\\<\\\\=.<v2>",\n"t2":"<v1>\\\\[.*\\\\].\\\\=.*",\n"t3":"",\n"f1":"",\n"f2":"",\n"f3":""\n}', 1422316228, 1423685499, 'Maksymilian Arciemowicz'),
(11, '319632c706422680fa2de43811c2aae4', 0, 'Maksymilian Arciemowicz', 'Integer overflow multipling 10', 'The software performs a calculation that can produce an integer overflow or wraparound, when the logic assumes that the resulting value will always be larger than the original value. This can introduce other weaknesses when the calculation is used for resource management or execution control.', '', 'CWE-189', '', '{\n"v1":"int.* (?<v1>\\\\w{2,})(?:\\\\;|\\\\,| \\\\=)",\n"v2":"",\n"v3":"",\n"t1":"(?:(<v1>.\\\\*.10)|(10.\\\\*.<v1>)|(<v1>.\\\\*\\\\=.10))",\n"t2":"",\n"t3":"",\n"f1":"if.*(?:(<v1>.*\\\\<.*)|(<v1>.*\\\\>.*)|(.*(?:\\\\<|\\\\>)<v1))",\n"f2":"",\n"f3":""\n}', 1422316311, 1423684194, 'Maksymilian Arciemowicz');

CREATE TABLE IF NOT EXISTS `cifrex_groups` (
  `group_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `path` varchar(4096) NOT NULL,
  `source` text NOT NULL,
  `custom_files` text NOT NULL,
  `date_created` int(11) NOT NULL,
  `date_lastmod` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `cifrex_groups` (`group_id`, `name`, `description`, `path`, `source`, `custom_files`, `date_created`, `date_lastmod`) VALUES
(1, 'Example of Group (Alloca use)', 'Description of the group', '/', '', 'c', 1422730850, 1423683058);

CREATE TABLE IF NOT EXISTS `cifrex_languages` (
  `lang_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `files` text NOT NULL,
  `date_created` int(11) NOT NULL,
  `date_lastmod` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `cifrex_languages` (`lang_id`, `name`, `description`, `files`, `date_created`, `date_lastmod`) VALUES
(0, 'Default', 'All files', '*', 1422041350, 1422041350),
(1, 'C', 'Common weaknesses for C', 'c|h', 1422041351, 1422041351),
(2, 'C++', 'Common weaknesses for C++', 'cc|cpp|hpp|hh', 1422041379, 1422041920),
(3, 'PHP', 'Common weaknesses for PHP scripts', 'php|php4', 1422041468, 1422041468),
(4, 'JAVA', 'Common weaknesses for JAVA', 'java', 1422041637, 1422041637),
(5, 'Perl', 'Common weaknesses for Perl', 'pl', 1422042131, 1422042131),
(6, 'Python', 'Common weaknesses for Python', 'py', 1422042151, 1422042151),
(7, 'HTML', 'Common weaknesses for html', 'htm|html', 1422042173, 1422042173),
(8, 'JavaScript', 'Common weaknesses for Java Script', 'js', 1422042193, 1422299038);

CREATE TABLE IF NOT EXISTS `cifrex_relation_fil_gro` (
  `relation_fg` int(11) NOT NULL,
  `filtr_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cifrex_relation_lang_fil` (
  `relation_fl` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `filtr_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

INSERT INTO `cifrex_relation_lang_fil` (`relation_fl`, `lang_id`, `filtr_id`) VALUES
(3, 3, 3),
(4, 3, 4),
(6, 3, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(24, 1, 10),
(32, 3, 2),
(34, 3, 1),
(35, 3, 5),
(36, 1, 11);

CREATE TABLE IF NOT EXISTS `cifrex_results` (
  `result_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date` int(11) NOT NULL,
  `path` text NOT NULL,
  `files` text NOT NULL,
  `filtr` text NOT NULL,
  `hasz` varchar(64) NOT NULL,
  `credit` text NOT NULL,
  `count_result` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cifrex_results_details` (
  `result_id` int(11) NOT NULL,
  `result` longtext NOT NULL,
  `debug_log` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `cifrex_filters`
  ADD PRIMARY KEY (`filtr_id`), ADD KEY `filtr_id` (`filtr_id`), ADD KEY `filtr_id_2` (`filtr_id`);

ALTER TABLE `cifrex_groups`
  ADD UNIQUE KEY `group_id` (`group_id`);

ALTER TABLE `cifrex_languages`
  ADD UNIQUE KEY `lang_id` (`lang_id`);

ALTER TABLE `cifrex_relation_fil_gro`
  ADD UNIQUE KEY `relation_fg` (`relation_fg`), ADD KEY `relation_fg_2` (`relation_fg`), ADD KEY `filtr_id` (`filtr_id`), ADD KEY `group_id` (`group_id`), ADD KEY `filtr_id_2` (`filtr_id`), ADD KEY `relation_fg_3` (`relation_fg`);

ALTER TABLE `cifrex_relation_lang_fil`
  ADD PRIMARY KEY (`relation_fl`), ADD KEY `filtr_id` (`filtr_id`), ADD KEY `relation_fl` (`relation_fl`);

ALTER TABLE `cifrex_results`
  ADD PRIMARY KEY (`result_id`);

ALTER TABLE `cifrex_results_details`
  ADD UNIQUE KEY `result_id` (`result_id`);


ALTER TABLE `cifrex_filters`
  MODIFY `filtr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
ALTER TABLE `cifrex_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
ALTER TABLE `cifrex_languages`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
ALTER TABLE `cifrex_relation_fil_gro`
  MODIFY `relation_fg` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=71;
ALTER TABLE `cifrex_relation_lang_fil`
  MODIFY `relation_fl` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
ALTER TABLE `cifrex_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
