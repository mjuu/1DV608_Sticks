-- Serverversion: 10.1.8-MariaDB
-- PHP-version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `sticks`
--
CREATE DATABASE IF NOT EXISTS `sticks` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sticks`;

-- --------------------------------------------------------

--
-- Tabellstruktur `members`
--

CREATE TABLE `members` (
  `user_id` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `members`
--

INSERT INTO `members` (`user_id`, `username`, `password`) VALUES
(1, 'admin', 'pass');

--
-- Index för tabell `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT för tabell `members`
--
ALTER TABLE `members`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
