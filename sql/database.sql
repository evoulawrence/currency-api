--
-- Database: `agpay`
--

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS currencies (
    iso_code VARCHAR(100) NOT NULL,
    iso_numeric_code INT NOT NULL,
    common_name VARCHAR(200) NOT NULL,
    official_name VARCHAR(200) NOT NULL,
    symbol VARCHAR(50) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8;


--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS countries (
    continent_code VARCHAR(50) NOT NULL,
    currency_code VARCHAR(50) NOT NULL,
    iso2_code VARCHAR(50) NOT NULL,
    iso3_code VARCHAR(50) NOT NULL,
    iso_numeric_code INT NOT NULL ,
    fips_code VARCHAR(50) DEFAULT NULL,
    calling_code INT NOT NULL,
    common_name VARCHAR(200) NOT NULL,
    official_name VARCHAR(200) NOT NULL,
    endonym VARCHAR(200) DEFAULT NULL,
    demonym VARCHAR(200) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`iso_code`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`iso_numeric_code`);
