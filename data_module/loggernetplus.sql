/* SQL script creation database */
DROP DATABASE IF EXISTS loggernetplus;
CREATE DATABASE loggernetplus;
USE loggernetplus;

/* Package data */
CREATE TABLE Dataloggers (
	id		BIGINT AUTO_INCREMENT,
	name		VARCHAR(255),
	processor	VARCHAR(255),
	model		VARCHAR(255),
	reference	VARCHAR(255),
	detected_at	TIMESTAMP,
	PRIMARY KEY(id)
);

CREATE TABLE Sensors (
	id		BIGINT AUTO_INCREMENT,
	name		VARCHAR(255),
	unit		VARCHAR(255),
	operation	VARCHAR(255),
	datalogger_id	BIGINT,
	detected_at	TIMESTAMP,
	PRIMARY KEY(id),
	FOREIGN KEY(datalogger_id) REFERENCES Dataloggers(id)
);

CREATE TABLE Datarows (
	id		BIGINT,
	datalogger_id	BIGINT,
	count_infile	BIGINT,
	measured_at	DATE
);

CREATE TABLE Data (
	datarow_id	BIGINT,
	sensor_id	BIGINT,
	data		REAL
);


/* Package Users */
CREATE TABLE Users (
	id		BIGINT AUTO_INCREMENT,
	username	VARCHAR(255) UNIQUE NOT NULL,
	email		VARCHAR(255) UNIQUE NOT NULL,
	password 	VARCHAR(255),
	entity	 	VARCHAR(255),
	digest		VARCHAR(255),
	role		INTEGER,
	PRIMARY KEY(id)
);

CREATE TABLE Dashboards (
	id		BIGINT AUTO_INCREMENT,
	user_id		BIGINT,
	display_order	INTEGER,
	title		VARCHAR(255),
	description	TEXT,
	is_default	INTEGER,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES Users(id)
);

CREATE TABLE ChartType (
	id		BIGINT AUTO_INCREMENT,
	name		VARCHAR(255),
	description	VARCHAR(255),
	chartJS_type	VARCHAR(255),
	min_params	INTEGER,
	max_params	INTEGER,
	PRIMARY KEY(id)
);

CREATE TABLE Charts (
	id		BIGINT AUTO_INCREMENT,
	dashboard_id	BIGINT,
	title		VARCHAR(255),
	description	TEXT,
	row_num		INTEGER,
	column_num      INTEGER,
	width		INTEGER,
	height		INTEGER,
	data_from	DATE,
	data_to		DATE,
	sensor_id	BIGINT, /* Will be a table one day */
	type		BIGINT,
	PRIMARY KEY(id),
	FOREIGN KEY(dashboard_id) REFERENCES Dashboards(id),
	FOREIGN KEY(type) REFERENCES ChartType(id)
);
