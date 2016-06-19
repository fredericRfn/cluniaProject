/* SQL script creation database */
DROP DATABASE loggernetplus IF EXISTS;
CREATE DATABASE loggernetplus;
USE loggernetplus;

/* Package data */
CREATE TABLE Stations (
	id		BIGINT AUTO_INCREMENT,
	ip		VARCHAR(255) UNIQUE NOT NULL,
	port		INTEGER,
	name		VARCHAR(255) UNIQUE NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE Dataloggers (
	id		BIGINT AUTO_INCREMENT,
	station_id	BIGINT,
	name		VARCHAR(255),
	processor	VARCHAR(255),
	model		VARCHAR(255),
	reference	VARCHAR(255),
	detected_at	TIMESTAMP,
	PRIMARY KEY(id),
	FOREIGN KEY(station_id) REFERENCES Stations.id
);

CREATE TABLE Sensors (
	id		BIGINT AUTO_INCREMENT,
	name		VARCHAR(255),
	unit		VARCHAR(255),
	operation	VARCHAR(255),
	datalogger_id	BIGINT,
	detected_at	TIMESTAMP,
	PRIMARY KEY(id),
	FOREIGN KEY(datalogger_id) REFERENCES Dataloggers.id
);

CREATE TABLE Rows (
	id		BIGINT AUTO_INCREMENT,
	datalogger_id	BIGINT,
	count_infile	BIGINT,
	datestamp	TIMESTAMP,
	PRIMARY KEY(id),
	FOREIGN KEY(sensor_id) REFERENCES Sensors.id,
	FOREIGN KEY(datalogger_id) REFERENCES Dataloggers.id
);

CREATE TABLE Data (
	row_id		BIGINT,
	sensor_id	BIGINT,
	value		INTEGER
	PRIMARY KEY(row_id, sensor_id),
	FOREIGN KEY(row_id) REFERENCES Rows.id,
	FOREIGN KEY(sensor_id) REFERENCES Sensors.id,
);


/* Package Users */
CREATE TABLE Users (
	id		BIGINT AUTO_INCREMENT,
	username	VARCHAR(255) UNIQUE NOT NULL,
	email		VARCHAR(255) UNIQUE NOT NULL,
	password 	VARCHAR(255),
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
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES Users.id
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

CREATE TABLE Chart (
	id		BIGINT AUTO_INCREMENT,
	dashboard_id	BIGINT,
	title		VARCHAR(255),
	description	TEXT,
	x		INTEGER,
	y		INTEGER,
	width		INTEGER,
	length		INTEGER,
	parameters	VARCHAR(255), // Will be a table one day
	type		BIGINT,
	PRIMARY KEY(id),
	FOREIGN KEY(dashboard_id) REFERENCES Dashboards.id,
	FOREIGN KEY(type) REFERENCES ChartType.id
);
