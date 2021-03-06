CREATE TABLE downloads (
	id INT NOT NULL AUTO_INCREMENT,
	time_access DATETIME,
	remote_ip VARCHAR(20),
	remote_hostname VARCHAR(255),
	email VARCHAR(255),
	filename VARCHAR(255),
	useragent VARCHAR(255),
	json TEXT NOT NULL,
	success BOOLEAN,
	PRIMARY KEY(id),
	UNIQUE unique_index(time_access,remote_ip,email,filename)
) ENGINE=InnoDB;

CREATE TABLE uploads (
	id INT NOT NULL AUTO_INCREMENT,
	time_access DATETIME,
	remote_ip VARCHAR(20),
	remote_hostname VARCHAR(255),
	filename VARCHAR(255),
	useragent VARCHAR(255),
	json TEXT NOT NULL,
	success BOOLEAN,
	PRIMARY KEY(id),
	UNIQUE unique_index(time_access,remote_ip,filename)
) ENGINE=InnoDB;
